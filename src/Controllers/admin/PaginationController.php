<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\PaginationModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Illuminate\Support\Facades\Route;

class PaginationController extends Controller
{
    public function index()
    {
        return view('admin.pagination.listing');
    }

    public function ajax_listing(Request $request)
    {

        $Pagination_Information     = General::get_pagination_count();

        $vAction         = $request->vAction;
        $vUniqueCode     = $request->vUniqueCode;
        $vController     = $request->vController;
        $vSize           = $request->vSize;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iPaginationId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eDeleted        = $request->eDeleted;

        if ($vAction == "delete" && !empty($vUniqueCode)) {

            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $ID = PaginationModel::DeleteData($where);
        }
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));

            if ($eStatus == "delete") {
                foreach ($result as $key => $value) {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
                    $ID = PaginationModel::UpdateData($where, $data);
                }
            } elseif ($eStatus == "Recover") {
                foreach ($result as $key => $value) {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
                    $ID = PaginationModel::UpdateData($where, $data);
                }
            } else {
                foreach ($result as $key => $value) {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;

                    $ID = PaginationModel::UpdateData($where, $data);
                }
            }
        }

        $criteria                    = array();
        $criteria['vController']     = $vController;
        $criteria['vSize']           = $vSize;
        $criteria["paging"]          = false;
        if ($eStatus_search != null) {
            $criteria['eStatus']      = $eStatus_search;
        }

        if ($eDeleted != null) {
            $criteria['eDelete']      = $eDeleted;
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $PaginationData              = PaginationModel::total_pagination_data($criteria);
        $pages                       = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $PaginationData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
        if (!empty($request->limit_page)) {
            $selectedpagelimit = $request->limit_page;
        } else {
            $selectedpagelimit = $paginator->itemsPerPage;
        }
        $start = ($paginator->currentPage - 1) * $selectedpagelimit;
        $limit = $selectedpagelimit;
        $paginator->is_ajax = true;
        $paging = true;
        $criteria["start"]      = $start;
        $criteria["limit"]      = $limit;
        $criteria["paging"]     = $paging;

        $data                   = array();
        $data['data']           = PaginationModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }

        $data['PaginationData']  = $PaginationData;
        return view('admin.pagination.ajax_listing')->with($data);
        
    }
    public function add()
    {
       
            $controllers = [];
            foreach (Route::getRoutes()->getRoutes() as $route) {
                $action = $route->getAction();
                if (array_key_exists('controller', $action)) {
                    $controllers[]  = $action['controller'];
                    $result = preg_grep('/^App/', $controllers);
                }
            }

            $i = 0;
            foreach ($result as $key => $val) {
                $find = array("\\");
                $replace = array("-");
                $arry[] = str_replace($find, $replace, $val);
                $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                $i++;
            }

            $j = 0;
            foreach ($results as $key => $vals) {
                $tests[]  = explode("-", $vals);
                $lastElementResult = end($tests[$j]);
                $arrry1[] = explode("@", $lastElementResult);
                $ControllerName[] = $arrry1[$j][0];
                $j++;
            }

            sort($ControllerName);
            $clength = count($ControllerName);
            for ($x = 0; $x < $clength; $x++) {
                $ControllerName[$x];
            }

            $listofcontrollers = array_unique($ControllerName);

            if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }
            if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }

            if (($key = array_search('DashboardController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }
            if (($key = array_search('ProfileController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }

            $criteria                   = array();
            $criteria["eDelete"]        = "No";
            $criteria["eStatus"]        = "Active";
            $foundControllers           = PaginationModel::get_all_data($criteria);
            $foundvalues = [];
            if (!empty($foundControllers)) {
                foreach ($foundControllers as $found) {
                    $foundvalues[] = $found->vController;
                }
            }
            $getExistControllers       = $foundvalues;
            $data['listofcontrollers'] = array_diff($listofcontrollers, $getExistControllers);

            return view('admin.pagination.add')->with($data);
    }

    public function edit($vUniqueCode)
    {

        if (!empty($vUniqueCode)) {
           
                $controllers = [];
                foreach (Route::getRoutes()->getRoutes() as $route) {
                    $action = $route->getAction();
                    if (array_key_exists('controller', $action)) {
                        $controllers[]  = $action['controller'];
                        $result = preg_grep('/^App/', $controllers);
                    }
                }
                $i = 0;
                foreach ($result as $key => $val) {
                    $find = array("\\");
                    $replace = array("-");
                    $arry[] = str_replace($find, $replace, $val);
                    $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                    $i++;
                }

                $j = 0;
                foreach ($results as $key => $vals) {
                    $tests[]  = explode("-", $vals);
                    $lastElementResult = end($tests[$j]);
                    $arrry1[] = explode("@", $lastElementResult);
                    $ControllerName[] = $arrry1[$j][0];
                    $j++;
                }
                sort($ControllerName);
                $clength = count($ControllerName);
                for ($x = 0; $x < $clength; $x++) {
                    $ControllerName[$x];
                }

                $listofcontrollers = array_unique($ControllerName);

                if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                    //dd($key);
                    unset($listofcontrollers[$key]);
                }
                if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                    //dd($key);
                    unset($listofcontrollers[$key]);
                }

                if (($key = array_search('DashboardController', $listofcontrollers)) !== false) {
                    //dd($key);
                    unset($listofcontrollers[$key]);
                }

                $data['listofcontrollers'] = $listofcontrollers;

                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['paginations']        = PaginationModel::get_by_id($criteria);

                if (!empty($data['paginations']) || !empty($data['listofcontrollers'])) {
                    return view('admin.pagination.add')->with($data);
                } else {
                    return redirect()->route('admin.pagination.listing');
                }
            } else {

                return redirect()->route('admin.pagination.listing')->withError('can not access without permission.');
            }
    }

    public function store(Request $request)
    {

        $vUniqueCode = $request->vUniqueCode;

        $data                 = array();
        if (!empty($request->vController) || $request->vController != null) {
            $data['vController']  = $request->vController;
        }
        $data['vSize']        = $request->vSize;
        $data['eStatus']      = $request->eStatus;

        if (!empty($vUniqueCode)) {
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = PaginationModel::UpdateData($where, $data);

            return redirect()->route('admin.pagination.listing')->withSuccess('Pagination updated successfully.');
        } else {

            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $ID = PaginationModel::AddData($data);

            $where = array();
            $where["iPaginationId"]  = $ID;
            $data = array();
            $data['vUniqueCode']     = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
            PaginationModel::UpdateData($where, $data);

            return redirect()->route('admin.pagination.listing')->withSuccess('Pagination created successfully.');
        }
    }
}
