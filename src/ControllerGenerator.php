<?php

namespace Isync\Demo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ControllerGenerator
{
    protected $databaseName;

    protected $module_og;

    protected $panel;

    protected $data = [];

    protected $module;

    protected $image = '';

    public function __construct(Request $request)
    {
        $this->databaseName = config('database.connections.mysql.database');
        $this->panel = 'admin';
        $this->data['listing'] = $request->has('listing') ? $request->listing : null;
        $this->data['add'] = $request->has('add') ? $request->add : null;
        $this->module = $request->has('module') ? $request->module : null;
        $this->module_og = $request->has('module') ? $request->module : null;

        if ($request->has('module') && preg_match('/[_-]/', $request->module)) {
            
            $words = preg_split('/[_-]/', $request->module);       
            $words = array_map('ucfirst', $words);
            $this->module = implode('', $words);
            $this->module_og = strtolower($request->module);
        }
    }

    public function create()
    {
        $methods = ['make_controller', 'make_model', 'make_resources'];

        foreach ($methods as $method) {

            $result = $this->$method();
            // $result = $this->$method($this->module, $this->panel, $this->data);

            if ($result === false) {
                return 'File Exists';
            }
        }
        Artisan::call('optimize');

        return 'All well';
    }

    private function make_controller()
    {
        $controllerName = ucwords($this->module).'Controller';
        $controllerPathName = "Http/Controllers/{$this->panel}/".$controllerName.".php";
        $controllerFilePath = app_path($controllerPathName);


        $getAllColumns = DB::select(
            '
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? order by ORDINAL_POSITION ASC',
            [$this->databaseName, $this->module]
        );

        $directory = dirname($controllerFilePath);

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($controllerFilePath)) {
            return 'false';
        }

        $file = __DIR__.'/views/controller.txt';
        $content = file_get_contents($file);
        $content = $this->replace_placeholders($content, $this->module, $this->panel);

        $code = $this->generate_code_snippets($getAllColumns, $this->data['listing'], $this->data['add']);

        $content = str_replace(['//Module Columns', '//criterias', '//addData'], $code, $content);

        if (! $this->has_image_column($getAllColumns)) {
            $pattern = '/\/\/Image Code Start.*?\/\/Image Code End/s';
            $content = preg_replace($pattern, '', $content);
        }

        File::put($controllerFilePath, $content);
        exec(__DIR__."/../../../bin/pint {$controllerFilePath}",$output,$status);

        $this->generate_route($controllerPathName ,$controllerName);
        

        return 'true';
    }

    private function replace_placeholders($content)
    {
        return str_replace(
            ['module_name', 'ModelName', 'Panel', 'ControllerName', 'ModuleData', 'module', 'Module data', 'iModuleId'],
            [$this->module_og, ucwords($this->module).'Model', $this->panel, ucwords($this->module).'Controller', ucwords($this->module).'Data', $this->module, ucwords($this->module).' data', 'i'.ucwords($this->module).'Id'],
            $content
        );
    }

    private function generate_code_snippets($getAllColumns, $listing, $addList)
    {
        $code = '';
        $criterias = '';
        $add = '';

        foreach ($getAllColumns as $val) {
            if ($val->COLUMN_NAME == 'eStatus') {
                $code .= "\$eStatus = \$request->eStatus;\n\$eStatus_search = \$request->eStatus_search;\n";
            }
            if ($val->COLUMN_NAME == 'eDelete') {
                $code .= "\$eDelete = \$request->eDelete;\n\$eDeleted = \$request->eDeleted;\n";
            }
            if ($val->COLUMN_NAME == 'vImage') {
                $this->image = 'true';
            }
        }

        foreach ($listing as $col) {
            $code .= "\$$col = \$request->$col;\n";
            $criterias .= "\$criteria['$col'] = \$$col;\n";
        }

        foreach ($addList as $col) {
            $add .= "\$data['$col'] = \$request->$col;\n";
        }

        return ['//Module Columns' => $code, '//criterias' => $criterias, '//addData' => $add];
    }

    private function has_image_column($getAllColumns)
    {
        foreach ($getAllColumns as $val) {
            if ($val->COLUMN_NAME == 'vImage') {
                return true;
            }
        }

        return false;
    }

    private function generate_route($ControllerPath, $controllerName)
    {
        $webFile = base_path('routes/web.php'); // Use `base_path` for clarity and convention
        if (File::exists($webFile)) {
            $webContent = file_get_contents($webFile);
            $routePathContain = str_replace(['/','.php'], ['\\',''], $ControllerPath);
            
            // Add the new use statement after the 'use Illuminate\Support\Facades\Route;'
            $search = "use Illuminate\Support\Facades\Route;";
            $replace = "use App\\" . $routePathContain . ";" . PHP_EOL . "use Illuminate\Support\Facades\Route;";  // Add the new use statement
            
            // Check if the use statement already exists to avoid duplication
            if (strpos($webContent, "use {$ControllerPath};") === false) {
                // If not, add the new use statement after the specified 'Route' import
                $webContent = str_replace($search, $replace, $webContent);
                
                // Prevent duplicate route blocks
                $routeModule = str_replace('_', '-', $this->module_og);
                if (strpos($webContent, "Route::prefix('{$this->panel}/{$routeModule}')") !== false) {
                    return; // Skip adding if the route already exists
                }

                $search1 = "/*********************** New Admin Routes will be here ********************/";
                
                // Construct the new route block
                $newRoutes = PHP_EOL . PHP_EOL . "// {$this->module_og}" . PHP_EOL;
                $newRoutes .= "Route::prefix('{$this->panel}/{$routeModule}')->name('{$this->panel}.{$this->module_og}.')->group(function () {" . PHP_EOL;
                $newRoutes .= "    Route::get('/', [{$controllerName}::class, 'index'])->name('listing');" . PHP_EOL;
                $newRoutes .= "    Route::post('ajax_listing', [{$controllerName}::class, 'ajax_listing'])->name('ajax_listing');" . PHP_EOL;
                $newRoutes .= "    Route::get('add', [{$controllerName}::class, 'add'])->name('add');" . PHP_EOL;
                $newRoutes .= "    Route::post('store', [{$controllerName}::class, 'store'])->name('store');" . PHP_EOL;
                $newRoutes .= "    Route::get('edit/{vUniqueCode}', [{$controllerName}::class, 'edit'])->name('edit');" . PHP_EOL;
                $newRoutes .= "});";
                $newRoutes .= PHP_EOL . PHP_EOL . $search1;

                // Replace the placeholder with the new routes block in the web content
                $webContent = str_replace($search1, $newRoutes, $webContent);

                // Write the updated content back to the file
                File::put($webFile, $webContent);

                // Optionally run Pint for formatting
                $RouteFilePath = base_path('routes/web.php');
                exec(__DIR__ . "/../../../bin/pint {$RouteFilePath}", $output, $status);
            }
        }

    }
    


    private function make_model()
    {
        $ModelFilePath = app_path("Models/{$this->panel}/".ucwords($this->module).'Model.php');

        $getAllColumns = DB::select(
            '
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? order by ORDINAL_POSITION ASC',
            [$this->databaseName, $this->module]
        );

        if (! File::exists($directory = dirname($ModelFilePath))) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($ModelFilePath)) {
            return 'false';
        }

        $columns = array_column($getAllColumns, 'COLUMN_NAME');
        $columnsString = $this->format_columns($columns);

        $content = $this->get_model_template();
        $content = $this->replace_placeholders1($content, $columnsString);
        $content = $this->insert_criteria_code($content, $columns, $this->data['listing']);

        File::put($ModelFilePath, $content);
        exec(__DIR__."/../../../bin/pint {$ModelFilePath}",$output,$status);

    }

    private function format_columns(array $columns)
    {
        return "['".implode("', '", $columns)."']";
    }

    private function get_model_template()
    {
        return file_get_contents(__DIR__.'/views/model.txt');
    }

    private function replace_placeholders1($content, $columnsString)
    {
        return str_replace(
            ['ModelName', 'module', 'iModelId', 'ColumnName', 'Panel'],
            [ucwords($this->module).'Model', $this->module, 'i'.ucwords($this->module).'Id', $columnsString, $this->panel],
            $content
        );
    }

    private function insert_criteria_code($content, array $columns, array $listing)
    {
        $code = '';

        foreach ($listing as $col) {
            if (! in_array($col, ['vImage', 'eStatus'])) {
                $code .= " if (!empty(\$criteria['$col'])) {
                          \$SQL->where('$col', 'like', '%' . \$criteria['$col'] . '%');
                      }\n";
            }
        }

        if (in_array('eStatus', $columns)) {
            $code .= " if (!empty(\$criteria['eStatus'])) {
                      \$SQL->where('eStatus', \$criteria['eStatus']);
                  }\n";
        }

        if (in_array('eDelete', $columns)) {
            $code .= " if (!empty(\$criteria['eDelete'])) { 
                      \$SQL->where('eDelete', \$criteria['eDelete']);
                  } else {
                      \$SQL->where('eDelete', 'No');
                  }\n";
        }

        return str_replace('//criterias', $code, $content);
    }

    private function make_resources()
    {
        $paths = [
            'listing' => resource_path("views/{$this->panel}/{$this->module}/listing.blade.php"),
            'ajax' => resource_path("views/{$this->panel}/{$this->module}/ajax_listing.blade.php"),
            'add' => resource_path("views/{$this->panel}/{$this->module}/add.blade.php"),
        ];

        $getAllColumns = DB::select(
            '
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? order by ORDINAL_POSITION ASC',
            [$this->databaseName, $this->module]
        );

        $placeholders = implode(',', array_fill(0, count($this->data['listing']), '?'));

        $columns = DB::select(
            "
        SELECT COLUMN_NAME, COLUMN_TYPE, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME IN ($placeholders)",
            array_merge([$this->databaseName, $this->module], $this->data['listing'])
        );

        $listColumn = [];
        foreach ($columns as $column) {
            $listColumn[$column->COLUMN_NAME] = [
                'data_type' => $column->DATA_TYPE,
                'column_type' => $column->COLUMN_TYPE,
            ];
        }

        $this->ensureDirectoryExists(dirname($paths['listing']));

        if (File::exists($paths['listing'])) {
            return 'false';
        }

        $listingContent = $this->generateListingContent($getAllColumns, $listColumn);
        File::put($paths['listing'], $listingContent);
        exec(__DIR__."/../../../bin/pint {$paths['listing']}",$output,$status);

        $this->generateAjaxContent($this->data['listing'], $paths['ajax']);
        $this->generateAddContent($this->data['add'], $paths['add']);
    }

    private function ensureDirectoryExists($directory)
    {
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    private function generateListingContent($getAllColumns, $listColumn)
    {
        $file = __DIR__.'/views/list.txt';
        $content = file_get_contents($file);
        $content = str_replace(['ModuleName', 'module_name'], [ucwords($this->module), $this->module_og], $content);

        $listingCode = $this->generateListingCode($getAllColumns, $listColumn);

        $tHead = $listingCode['tHead'];
        $js = $listingCode['js'];
        $jsvar = $listingCode['jsvar'];

        $content = str_replace(['//permissionsCode', '//TableHeading', '//jsvar', 'variables'], [$listingCode['permissionsCode'], $tHead, $js, $jsvar], $content);

        return $content;
    }

    private function generateListingCode($getAllColumns, $listColumn)
    {
        $check = $del = false;
        $js = $jsvar = $code = $delOptions = '';
        foreach ($getAllColumns as $val) {
            if (! is_object($val)) {
                continue;
            }

            if ($val->COLUMN_NAME == 'eStatus') {
                $check = true;
                $js .= "var eStatus = $('#eStatus :selected').val();\n";
                $js .= "var eStatus_search = $('#eStatus_search :selected').val();\n";
                $jsvar .= 'eStatus:eStatus,eStatus_search:eStatus_search,';
                $code .= "@if(\$permission->eWrite == 'Yes')
                        <option value='Active'>Active</option>
                        <option value='Inactive'>Inactive</option>
                        @endif\n";
            }
            if ($val->COLUMN_NAME == 'eDelete') {
                $check = true;
                $del = true;
                $js .= "var eDeleted = $('#eDeleted').val()\n";
                $jsvar .= 'eDeleted:eDeleted,';
                $code .= "@if(\$permission->eDelete == 'Yes')
                            <option value='delete'>Delete</option>
                            <option value='Recover'>Recover</option>
                            @endif\n";
            }
        }

        $permissionsCode = '';
        if ($check) {
            $permissionsCode = "@if(isset(\$permission) && \$permission != null && (\$permission->eWrite == 'Yes' || \$permission->eDelete == 'Yes'))
                            <div class='space'>
                                <select name='eStatus' id='eStatus' class='form-select'>
                                    <option value=''>Action</option>
                                    {$code}
                                </select>
                            </div>
                            @endif\n";
            if ($del) {
                $permissionsCode .= "@if(isset(\$permission) && \$permission != null && \$permission->eDelete == 'Yes')
                                    <div class='space'>
                                        <select name='eDeleted' id='eDeleted' class='form-select'>
                                            <option value=''>Deleted</option>
                                            <option value='Yes'>Yes</option>
                                            <option value='No'>No</option>
                                        </select>
                                    </div>
                                    @endif\n";
            }
        }

        $no = $this->generateTableHead($listColumn);
        $js .= $no['js'];
        $jsvar .= $no['jsvar'];

        return [
            'permissionsCode' => $permissionsCode,
            'tHead' => $no['head'],
            'js' => $js,
            'jsvar' => $jsvar,
        ];
    }

    private function generateTableHead($listColumn)
    {
        $var = '';
        $exvar = '';
        $tHead1 = "@if(isset(\$permission) && \$permission != null && (\$permission->eWrite == 'Yes' || \$permission->eDelete == 'Yes'))
                <th style='width: 10px'>
                    <div class='checkbox adcheck mt-2'>
                        <input id='selectall' type='checkbox' name='selectall' class='css-checkbox form-check-input'>
                        <label for='selectall'>&nbsp;</label>
                    </div>
                </th>
                @endif\n";
        // dd($listColumn);
        foreach ($listColumn as $k => $v) {
            $heading = ucwords(substr($k, 1));
            $tHead1 .= $this->generateColumnHead($k, $v, $heading);
            $var .= "var {$k} = $('#{$k}').val()\n";
            $exvar .= "{$k}:{$k},";
        }

        $tHead1 .= "<th class='text-center space-w'>Action</th>";
        $no = [];
        $no['head'] = $tHead1;
        $no['jsvar'] = $exvar;
        $no['js'] = $var;

        return $no;
    }

    private function generateColumnHead($column, $datatype, $heading)
    {
        // dd($column, $datatype, $heading);
        if ($datatype['data_type'] == 'enum') {
            preg_match("/^enum\((.*)\)$/", $datatype['column_type'], $matches);
            if (! isset($matches[1])) {
                return '';
            }

            $enumValues = str_getcsv($matches[1], ',', "'");
            $options = "<select class='form-select' name='{$column}' id='{$column}_search'>";
            $options .= "<option value=''>{$heading}</option>";

            foreach ($enumValues as $value) {
                $options .= "<option value='{$value}'>{$value}</option>";
            }

            $options .= '</select>';

            return "<th class='space-w'>{$options}</th>";
        }

        return "<th><input placeholder='{$heading}' id='{$column}' type='text' name='{$column}' class='search form-control'></th>";
    }

    private function generateAjaxContent($listingData, $ajaxFilePath)
    {
        $path = __DIR__.'/views/ajax.txt';
        $ajaxTemplate = file_get_contents($path);
        $ajaxContent = $this->generateAjaxHtml($listingData);
        $ajaxContent = str_replace(['ModuleData', 'module_name', '//ajaxHtml'], [ucwords($this->module).'Data', $this->module_og, $ajaxContent], $ajaxTemplate);
        File::put($ajaxFilePath, $ajaxContent);
        exec(__DIR__."/../../../bin/pint {$ajaxFilePath}",$output,$status);

    }

    private function generateAjaxHtml($listingData)
    {

        $placeholders = implode(',', array_fill(0, count($listingData), '?'));

        $columns = DB::select(
            "
            SELECT COLUMN_NAME, COLUMN_TYPE, DATA_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME IN ($placeholders)",
            array_merge([$this->databaseName, $this->module], $listingData)
        );

        $getColDesc = [];
        foreach ($columns as $column) {
            $getColDesc[$column->COLUMN_NAME] = [
                'data_type' => $column->DATA_TYPE,
                'column_type' => $column->COLUMN_TYPE,
            ];
        }

        $ajaxHtml = '';

        foreach ($getColDesc as $k => $v) {
            if (! is_array($v)) {
                continue;
            }

            $ajaxHtml .= $this->generateAjaxColumnHtml($k, $v, $this->module);
        }

        return $ajaxHtml;
    }

    private function generateAjaxColumnHtml($column)
    {
        if ($column == 'vImage') {
            return "<td class='text-center'>
                    @if (!empty(\$value->vWebpImage) && file_exists(public_path() . '/uploads/{$this->module}/{$this->module}_small/' . \$value->vWebpImage))
                    <a href='{{asset('uploads/{$this->module}/{$this->module}_small/'.\$value->vWebpImage)}}' target='_blank'>
                    <img style='width: 90px;border-radius: 10px;' class='card-img-top' src='{{asset('uploads/{$this->module}/{$this->module}_small/'.\$value->vWebpImage)}}' alt='Card image cap' /></a>
                    @else
                    <div class='text-center'>
                    <img style='width: 90px;border-radius: 10px;' src='{{ asset('admin/assets/img/no_image.png') }}' alt='No photo'>
                    </div>
                    @endif
                </td>\n";
        } elseif ($column == 'eStatus') {
            return "<td class='text-center'><span class=' @if(\$value->eStatus == 'Active')badge bg-label-primary me-1 @elseif(\$value->eStatus == 'Pending') badge bg-label-warning me-1  @else badge bg-label-danger me-1 @endif'>{{\$value->eStatus}}</span></td>\n";
        } else {
            return "<td class='text-left'>
                    @if(!empty(\$value->{$column}))
                        @if(strlen(\$value->{$column}) >= 60)
                        {{substr(\$value->{$column}, 0, 60)}} {{'...'}}
                        @else
                        {{\$value->{$column}}}
                        @endif
                    @else
                    {{ 'N/A' }}
                    @endif
                </td>\n";
        }
    }

    private function generateAddContent($addData, $addFilePath)
    {
        $path = __DIR__.'/views/add.txt';
        $addTemplate = file_get_contents($path);
        $addContent = $this->generateAddHtml($addData);
        $addContent = str_replace(['ModuleName', 'module_name', '//AddFields', '//ImageAdd', '//VarAdd', '//ValAdd'], [ucwords($this->module), $this->module_og, $addContent['html'], $addContent['jsImage'], $addContent['jsVars'], $addContent['jsValidation']], $addTemplate);
        File::put($addFilePath, $addContent);
        exec(__DIR__."/../../../bin/pint {$addFilePath}",$output,$status);
       
    }

    private function generateAddHtml($addData)
    {
        $addHtml = $jsImageAdd = $jsAdd = $jsVars = $jsValidation = '';

        $placeholders = implode(',', array_fill(0, count($addData), '?'));

        $columns = DB::select(
            "
            SELECT COLUMN_NAME, COLUMN_TYPE, DATA_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME IN ($placeholders)",
            array_merge([$this->databaseName, $this->module], $addData)
        );

        $addData = [];
        foreach ($columns as $column) {
            $addData[$column->COLUMN_NAME] = [
                'data_type' => $column->DATA_TYPE,
                'column_type' => $column->COLUMN_TYPE,
            ];
        }

        foreach ($addData as $column => $datatype) {
            if (! is_array($datatype)) {
                continue;
            }

            $columnHtml = $this->generateAddFieldHtml($column, $datatype);
            $addHtml .= $columnHtml['html'];
            $jsImageAdd .= $columnHtml['jsImage'];
            $jsAdd .= $columnHtml['jsVars'];
            $jsValidation .= $columnHtml['jsValidation'];
        }

        return [
            'html' => $addHtml,
            'jsImage' => $jsImageAdd,
            'jsVars' => $jsAdd,
            'jsValidation' => $jsValidation,
        ];
    }

    private function generateAddFieldHtml($column, $datatype)
    {
        $html = $jsImage = $jsVars = $jsValidation = '';

        if ($column == 'vImage') {
            $html = "<div class='form-group col-xl-6 col-lg-12 col-md-6'>
                    <label>Image</label>
                    <input type='file' name='vImage' id='vImage' class='form-control' accept='.jpg,.jpeg,.png'>
                    <img style='width: 100px; display: none; border-radius: 10px; margin-top: 7px;' id='image_display' src='{{ asset('admin/assets/img/no_image.png') }}' alt='Image'>
                    <img style='width: 100px; display: none; border-radius: 10px; margin-top: 7px;' class='image_Preview' src='#' alt='your image'>
                    <div id='vImage_error' class='error mt-1' style='color:red;display: none;'>Please Select Image</div>
                    <div id='vImage_error_max' class='error mt-1' style='color:red;display: none;'>Allowed Maximum size of 10MB</div>
                    <div id='vImage_error_min' class='error mt-1' style='color:red;display: none;'>Allowed Minimum size of 10KB</div>
                    <div id='vImage_type_error' class='error mt-1' style='color:red;display: none;'>Please Select JPG, JPEG, or PNG Image.</div>
                </div>\n";

            $jsImage = "$('.vImage_preview_img').hide();
                    $('#vImage').change(function() {
                        var fileName = $('#vImage').val();
                        if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/)) {
                            $('#vImage_error').hide();
                            $('#image_display').hide();
                            $('#vImage_preview').show();
                            $('#image_none').hide();
                        } else {
                            $('#image_display').show();
                            $('#vImage_preview').hide();
                        }
                    });

                    vImage.onchange = evt => {
                        $('#vImage_preview').removeClass('vImage_preview_img');
                        $('#image_display').addClass('vImage_preview_img');
                        const fileUrl = window.URL.createObjectURL(event.target.files[0]);
                        const imgExtensions = ['jpg', 'png', 'jpeg'];
                        const name = event.target.files[0].name;
                        const ext = name.split('.').pop();
                        if (imgExtensions.includes(ext)) {
                            $('#vImage_preview').show().attr('src', fileUrl);
                        } else {
                            $('#vImage_type_error').show();
                        }
                    }

                    $(document).on('change', '#vImage', function() {
                        var filesize = this.files[0].size;
                        var maxfilesize = parseInt(filesize / 1024);
                        if (maxfilesize > 10240) {
                            $('#vImage').val('');
                            $('#vImage_error_max').show();
                            $('#save').removeClass('submit');
                        } else if (maxfilesize < 10) {
                            $('#vImage').val('');
                            $('#vImage_error_max').hide();
                            $('#vImage_error_min').show();
                            $('#save').removeClass('submit');
                        } else {
                            $('#save').addClass('submit');
                            $('#vImage_error_max').hide();
                            $('#vImage_error_min').hide();
                        }
                    });";

            $jsValidation = "if($('#vImage_type_error').is(':visible')) {
                            $('#vImage_type_error').show();
                            error = true;
                        } else {
                            $('#vImage_type_error').hide();
                        }
                        @if(!isset(\${$this->module}s))
                        if(vImage.length == 0) {
                            $('#vImage_error').show();
                            $('#vImage_format_error').hide();
                            error = true;
                        } else {
                            $('#vImage_error').hide();
                        }
                        @endif";
        } elseif ($datatype['data_type'] == 'enum') {
            preg_match("/^enum\((.*)\)$/", $datatype['column_type'], $matches);
            if (isset($matches[1])) {
                $enumValues = str_getcsv($matches[1], ',', "'");
                $html = "<div class='form-group col-xl-6 col-lg-12 col-md-6'>
                        <label>{$column}</label>
                        <select name='{$column}' id='{$column}' class='form-select'>
                            <option>Select {$column}</option>\n";
                foreach ($enumValues as $value) {
                    $html .= "<option value='{$value}' @if(isset(\${$this->module}s)) @if(\${$this->module}s->{$column} == '{$value}') selected @endif @endif>{$value}</option>\n";
                }
                $html .= "</select>
                        <div id='{$column}_error' class='error mt-1' style='color:red;display: none;'>Please Select {$column}</div>
                    </div>\n";
            }
        } else {
            $html = "<div class='form-group col-xl-6 col-lg-12 col-md-6'>
                    <label>{$column}</label>
                    <input type='text' name='{$column}' id='{$column}' class='form-control' placeholder='Enter {$column}' value='@if(isset(\${$this->module}s)){{\${$this->module}s->{$column}}}@endif'>
                    <div id='{$column}_error' class='error mt-1' style='color:red;display: none;'>Please Enter {$column}</div>
                </div>\n";
        }

        $jsVars = "var {$column} = $('#{$column}').val();\n";

        if ($column == 'vImage') {
            $jsValidation .= "if($('#vImage_type_error').is(':visible')) {
                            $('#vImage_type_error').show();
                            error = true;
                        } else {
                            $('#vImage_type_error').hide();
                        }
                        @if(!isset(\${$this->module}s))
                        if(vImage.length == 0) {
                            $('#vImage_error').show();
                            $('#vImage_format_error').hide();
                            error = true;
                        } else {
                            $('#vImage_error').hide();
                        }
                        @endif";
        } else {
            $jsValidation .= "if ({$column}.length == 0) {
                            $('#{$column}_error').show();
                            error = true;
                        } else {
                            $('#{$column}_error').hide();
                        }";
        }

        return [
            'html' => $html,
            'jsImage' => $jsImage,
            'jsVars' => $jsVars,
            'jsValidation' => $jsValidation,
        ];
    }
}
