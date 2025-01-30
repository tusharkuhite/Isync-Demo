@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'Survey Add- '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="d-flex justify-content-between flex-wrap gap-3 top-input-space">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    @if(isset($vUniqueCode))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('profile.edit',$vUniqueCode)}}"
                        ></i>Basic Organization</a
                      >
                    </li>
                    
                    <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.organization_profile',$vUniqueCode)}}"><i class='bx bx-user' ></i> Other Information</a
                      >
                    </li>

                     <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode)) disabled @endif " href="{{route('admin.profile.licence_edit',$vUniqueCode)}}"><i class='bx bx-file'></i> Licence Information</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.licenseusage_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> License Used</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.participant_listing',$vUniqueCode)}}"><i class='bx bx-user-circle' ></i> Participant</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.survey_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> Survey</a>
                    </li>
                    
                    @endif
                </ul>
            </div>
         <form action="{{url('admin/profile/survey_store', $vUniqueCode)}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
               <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($surveys)){{$surveys->vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Survey Title</label>
                        <input type="text" name="vSurvey" id="vSurvey" class="form-control"
                           placeholder="Enter Survey Title"
                           value="@if(isset($surveys)){{$surveys->vSurvey}}@endif">
                        <div id="vSurvey_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Survey Title
                        </div>
                     </div>
                 
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="Active" @if(isset($surveys)) @if($surveys->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($surveys)) @if($surveys->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>

                     <div class="form-group col-lg-12">
                        <label>Description</label>
                        <textarea class="form-control" id="tDescription" name="tDescription" placeholder="Enter Description" >@if(!empty($surveys->tDescription)) {{$surveys->tDescription}} @endif</textarea>
                        <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">Please Enter  Description
                        </div>
                     </div>

                      <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Image </label>
                            <input class="form-control media_image only_image" accept="image/jpg, image/jpeg, image/png" type="file" id="vImage"
                                name="vImage">

                            <img style="width: 100px; border-radius: 10px;margin-top: 7px; display:none;" class="vImage_preview_img" id="vImage_preview"
                                src="#" alt="your image" />

                            @if (!empty($surveys->vWebpImage) && file_exists(public_path() . "/uploads/survey/survey_small/" . $surveys->vWebpImage))                       
                               <img style="width: 100px; border-radius: 10px;margin-top: 7px;" alt="survey-avatar" class=" rounded " id="image_display"
                                value="@if(old('vWebpImage') == 'vWebpImage') @endif"
                                src="{{asset('/uploads/survey/survey_small/'.$surveys->vWebpImage)}}">
                            @elseif(isset($surveys))
                            <!-- default image -->
                            
                            <div id="image_none">
                                <img  style="display: block;" height="100" width="100" class="d-block rounded"
                                    src="{{ asset('admin/assets/img/no_image.png') }}" alt="No photo">
                            </div>
                          
                            <!-- selected image -->
                            <img style="width: 100px;display:none;border-radius: 10px;margin-top: 7px;" class="image_Preview"
                                 src="#" alt="your image" />

                            @endif

                            @if(!(isset($surveys)))
                            <!-- default image -->
                            <div id="image_none">
                                <img style="width: 100px; display: block;"
                                    src="{{ asset('admin/assets/img/no_image.png') }}" alt="No photo">
                            </div>
                            <!-- selected image -->
                            <img style="width: 100px;display:none;" class="image_Preview"
                                 src="#" alt="your image" />
                            @endif
                            <div id="vImage_error" class="error mt-1" style="color:red;display: none;">
                                Please Select Banner Image
                            </div>
                            <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">
                                    Allowed Maximum size of 5MB
                            </div>
                            <div id="vImage_error_min" class="error mt-1" style="color:red;display: none;">
                                Allowed Minimum size of 10KB
                            </div>
                            <div id="vImage_type_error" class="error mt-1" style="color:red;display: none;">
                                Plese Select JPG,JPEG or PNG Image.
                            </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Image Alt</label>
                        <input type="text" name="vImageAlt" id="vImageAlt" class="form-control"
                           placeholder="Enter Survey Image Alt"
                           value="@if(isset($surveys)){{$surveys->vImageAlt}}@endif">
                        <div id="vImageAlt_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Survey Image Alt
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/profile/survey_listing', $vUniqueCode)}}" class="btn-info btn">Back</a>
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
    selector: 'textarea',
    height: 200,
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
    ]
  });

$(".vImage_preview_img").hide();
$("#vImage").change(function() { 
    var fileName = $("#vImage").val();

    if (this.files && this.files[0] && this.files[0].name.match(/\.(jpg|jpeg|png|gif)$/) ) {
    if(fileName) { 
         $("#vImage_error").hide();
         $("#image_display").hide();  
         $("#vImage_preview").show();
         $("#image_none").hide();
    } else {

        $("#image_display").show(); 
        $("#vImage_preview").hide();
    }
   }
});

vImage.onchange = evt => {
  $( "#vImage_preview" ).removeClass("vImage_preview_img")
  $( "#image_display" ).addClass("vImage_preview_img")
  const fileUrl = window.URL.createObjectURL(event.target.files[0]);
  const imgExtensions = ['jpg', 'png','jpeg'];
  const name = event.target.files[0].name;
  const lastDot = name.lastIndexOf('.');

  const ext = name.substring(lastDot + 1);

   if (imgExtensions.includes(ext)) {
   $("#vImage_preview").show().attr("src", fileUrl);
  }else{
    $('#vImage_type_error').show();
  }

}

$(document).on('change', '#vImage', function() 
{
       var filesize = this.files[0].size
       var filetype = this.files[0].type;

       var maxfilesize = parseInt(filesize / 1024);
       if (maxfilesize > 10240) {
           $('#vImage').val('');
           $("#vImage_error_max").show();
           $("#save").removeClass("submit");
       }else if(maxfilesize < 10){
           $('#vImage').val('');
           $("#vImage_error_max").hide();
           $("#vImage_error_min").show();
           $("#save").removeClass("submit");
       } else {
           $("#save").addClass("submit");
           $("#vImage_error_max").hide();
           $("#vImage_error_min").hide();
       }
});

$(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var vSurvey     = $("#vSurvey").val();
       var eStatus     = $("#eStatus").val();
       var eFeature    = $("#eFeature").val();
       tDescription    = tinyMCE.get('tDescription').getContent();
       var error = false;


        if($("#vImage_type_error").is(":visible"))
        {   
            $('#vImage_type_error').show();
            error = true;
        }else{
            $('#vImage_type_error').hide();
        }

       if (vSurvey.length == 0) {
           $("#vSurvey_error").show();
           error = true;
       } else {
           $("#vSurvey_error").hide();
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