@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @if(isset($pages))
    @section('title', 'Page Edit- '.$setting_info['COMPANY_NAME']['vValue'])
    @else
    @section('title', 'Page Add- '.$setting_info['COMPANY_NAME']['vValue'])
    @endif
@endif
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($pages) ? 'Edit' : 'Add' }} Page</h5>
            </div>
         </div>
         <form action="{{url('admin/page/store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
              <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($pages)){{$pages->vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Page</label>
                        <input type="text" name="vPage" id="vPage" class="form-control"
                           placeholder="Enter Page"
                           value="@if(isset($pages)){{$pages->vPage}}@endif">
                        <div id="vPage_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Page
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Slug</label>
                        <input type="text" name="vSlug" id="vSlug" class="form-control"
                           placeholder="Enter Slug"
                           value="@if(isset($pages)){{$pages->vSlug}}@endif">
                        <div id="vSlug_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Slug
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Seo Title</label>
                        <input type="text" name="vSeoTitle" id="vSeoTitle" class="form-control"
                           placeholder="Enter Slug"
                           value="@if(isset($pages)){{$pages->vSeoTitle}}@endif">
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="Active" @if(isset($pages)) @if($pages->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($pages)) @if($pages->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Meta Description</label>
                        <textarea class="form-control" id="tMetaDescription" name="tMetaDescription" placeholder="Enter Description" >@if(!empty($pages->tMetaDescription)) {{$pages->tMetaDescription}} @endif</textarea>
                     </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Focus Keywords</label>
                        <textarea class="form-control" id="vFocusKeywords" name="vFocusKeywords" placeholder="Enter Focus Keywords" >@if(!empty($pages->vFocusKeywords)) {{$pages->vFocusKeywords}} @endif</textarea>
                     </div>

                     <div class="form-group col-lg-12 ">
                        <label>Description</label>
                        <textarea class="form-control" id="tDescription" name="tDescription" placeholder="Enter Description" >@if(!empty($pages->tDescription)) {{$pages->tDescription}} @endif</textarea>
                        <input name="image" type="file" id="upload" class="hidden" onchange="" style="display:none">
                        <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">Please Enter Description
                        </div>
                     </div>

                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/page')}}" class="btn-info btn">Back</a>
               </div>
              </div>
            </form>
         </div>
     </div>
</div>
@endsection
@section('custom-css')
<style></style>
@endsection
@section('custom-js')

<script type="text/javascript" src="{{asset('admin/assets/js/tinymce/tinymce.min.js')}}"></script>


<script type="text/javascript">

tinymce.init({
    selector: 'textarea#tDescription',
    height: 500,
    menubar: false,
    convert_urls : false,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code help wordcount'
    ],
    toolbar: 'insert | undo redo | formatselect fontselect fontsizeselect | bold italic underline backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | removeformat | blockquote | help | code',
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
    ],
    theme_advanced_fonts : "Andale Mono=andale mono,times;"+
    "Arial=arial,helvetica,sans-serif;"+
    "Arial Black=arial black,avant garde;"+
    "Book Antiqua=book antiqua,palatino;"+
    "Comic Sans MS=comic sans ms,sans-serif;"+
    "Courier New=courier new,courier;"+
    "Georgia=georgia,palatino;"+
    "Helvetica=helvetica;"+
    "Impact=impact,chicago;"+
    "Symbol=symbol;"+
    "Tahoma=tahoma,arial,helvetica,sans-serif;"+
    "Terminal=terminal,monaco;"+
    "Times New Roman=times new roman,times;"+
    "Trebuchet MS=trebuchet ms,geneva;"+
    "Verdana=verdana,geneva;"+
    "Webdings=webdings;"+
    "Wingdings=wingdings,zapf dingbats",
    fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',
    textcolor_map: [
    "000000", "Black",
    "993300", "Burnt orange",
    "333300", "Dark olive",
    "003300", "Dark green",
    "003366", "Dark azure",
    "000080", "Navy Blue",
    "333399", "Indigo",
    "333333", "Very dark gray",
    "800000", "Maroon",
    "FF6600", "Orange",
    "808000", "Olive",
    "008000", "Green",
    "008080", "Teal",
    "0000FF", "Blue",
    "666699", "Grayish blue",
    "808080", "Gray",
    "FF0000", "Red",
    "FF9900", "Amber",
    "99CC00", "Yellow green",
    "339966", "Sea green",
    "33CCCC", "Turquoise",
    "3366FF", "Royal blue",
    "800080", "Purple",
    "999999", "Medium gray",
    "FF00FF", "Magenta",
    "FFCC00", "Gold",
    "FFFF00", "Yellow",
    "00FF00", "Lime",
    "00FFFF", "Aqua",
    "00CCFF", "Sky blue",
    "993366", "Red violet",
    "FFFFFF", "White",
    "FF99CC", "Pink",
    "FFCC99", "Peach",
    "FFFF99", "Light yellow",
    "CCFFCC", "Pale green",
    "CCFFFF", "Pale cyan",
    "99CCFF", "Light sky blue",
    "CC99FF", "Plum"
    ],
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype == 'image') {
            $('#upload').trigger('click');
            $('#upload').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    callback(e.target.result, {
                        alt: ''
                    });
                };
                reader.readAsDataURL(file);
            });
        }
    },
});

$(document).on('click', '.submit', function() {
      var vPage         = $("#vPage").val();
      var vSlug         = $("#vSlug").val();
      var eStatus       = $("#eStatus").val();
      tDescription      = tinyMCE.get('tDescription').getContent();
      
      var error = false;

      if (vPage.length == 0) {
         $("#vPage_error").show();
         error = true;
      } else {
         $("#vPage_error").hide();
      }

      if (vSlug.length == 0) {
         $("#vSlug_error").show();
         error = true;
      } else {
         $("#vSlug_error").hide();
      }

      if (tDescription.length == 0) {
         error = true;
         $("#tDescription_error").show();
      } else {
         $("#tDescription_error").hide();
      }

      if (eStatus.length == 0) {
         error = true;
         $("#eStatus_error").show();
      } else {
         $("#eStatus_error").hide();
      }

   
      if (error == true) {
         return false;
      } else {
         $('.submit').hide();
         $('.loading').show();
         
         setTimeout(function() {
            $("#frm").submit();
            return true;
         }, 1000);
      }
});
</script>
@endsection