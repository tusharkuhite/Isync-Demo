@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @if(isset($systemEmail))
    @section('title', 'System Email Edit- '.$setting_info['COMPANY_NAME']['vValue'])
    @else
    @section('title', 'System Email Add- '.$setting_info['COMPANY_NAME']['vValue'])
    @endif
@endif
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($systemEmail) ? 'Edit' : 'Add' }} System Email</h5>
            </div>
        </div>
    
        <form action="{{route('admin.systemEmail.store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
            <div class="card mb-4">
              <div class="card-body">

                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($systemEmail)) {{$systemEmail->vUniqueCode}} @endif">

                <div class="row g-3">
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Email Code</label>
                    <input type="text" name="vEmailCode" id="vEmailCode" class="form-control" placeholder="Enter Email code" value="@if(isset($systemEmail)) {{$systemEmail->vEmailCode}} @endif">
                    <div id="vEmailCode_error" class="error mt-1" style="color:red;display: none;">Please Enter Email code
                    </div>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>From Name</label>
                    <input type="text" name="vFromName" id="vFromName" class="form-control" placeholder="Enter From Name" value="@if(isset($systemEmail)) {{$systemEmail->vFromName}} @endif">
                    <div id="vFromName_error" class="error mt-1" style="color:red;display: none;">Please Enter From Name
                    </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>From Email</label>
                    <input type="email" name="vFromEmail" id="vFromEmail" class="form-control" placeholder="Enter From Email" value="@if(isset($systemEmail)) {{$systemEmail->vFromEmail}} @endif">
                    <div id="vFromEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter From Email
                    <div id="vFromEmail_valid_error" class="error mt-1" style="color:red;display: none;">Please Enter Valid Email</div>
                    </div>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Email Subject</label>
                    <input type="text" class="form-control" id="vEmailSubject" name="vEmailSubject" placeholder="Enter Email Subject" value="@if(!empty($systemEmail->vEmailSubject)){{$systemEmail->vEmailSubject}}@endif">
                    <div id="vEmailSubject_error" class="error mt-1" style="color:red;display: none;">Please Enter Email Subject
                    </div>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Status</label>
                    <select name="eStatus" id="eStatus" class="form-control">
                      <option value="">Select Status</option>
                      <option value="Active" @if(isset($systemEmail)) @if($systemEmail->eStatus == 'Active') selected @endif @endif>Active</option>
                      <option value="Inactive" @if(isset($systemEmail)) @if($systemEmail->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                    </select>
                    <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                  </div>
                  
                  <div class="form-group col-lg-12">
                    <label>Email Message</label>
                    <textarea class="form-control" id="tEmailMessage" name="tEmailMessage" placeholder="Enter Email Message">@if(!empty($systemEmail->tEmailMessage)) {{$systemEmail->tEmailMessage}} @endif</textarea>
                    <div id="tEmailMessage_error" class="error mt-1" style="color:red;display: none;">Please Enter Email Message
                    </div>
                  </div>
                </div>
              </div>
            
            <div class="card-footer col-12 align-self-end d-inline-block mt-0">
              <a href="javascript:;" class="btn btn-primary submit">Submit</a>
              <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
              </a>
              <a href="{{route('admin.systemEmail.listing')}}" class="btn-info btn">Back</a>
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
</script>

<script>
  $(document).on('click','.submit',function(){
    vUniqueCode         = $("#vUniqueCode").val().trim();
    vEmailCode          = $("#vEmailCode").val().trim();
    vFromName           = $("#vFromName").val().trim();
    vFromEmail          = $("#vFromEmail").val().trim();
    vEmailSubject       = $("#vEmailSubject").val().trim();
    eStatus             = $("#eStatus").val().trim();
    tEmailMessage       = tinyMCE.get('tEmailMessage').getContent();
    error = false;

    if(vEmailCode.length == ""){
        error = true;
        $("#vEmailCode_error").show();
    }
    else{
        $("#vEmailCode_error").hide();
    }
    if(vFromName.length == ""){
        error = true;
        $("#vFromName_error").show();
    }
    else{
        $("#vFromName_error").hide();
    }
    
    if(vFromEmail.length == 0)
    {
        error = true;
        $("#vFromEmail_error").show();
    }
    else
    {
      $("#vFromEmail_error").hide();
    }
  
    if(vEmailSubject.length == '')
    {
      $("#vEmailSubject_error").show();
      error = true;
    }
    else
    {
      $("#vEmailSubject_error").hide();
    }
  
    if(eStatus.length == '')
    {
      $("#eStatus_error").show();
      error = true;
    }
    else
    {
      $("#eStatus_error").hide();
    }
    if(tEmailMessage.length == 0)
    {
        $("#tEmailMessage_error").show();
        error = true;
    }
    else
    {
        $("#tEmailMessage_error").hide();
    }
    setTimeout(function(){
      if(error == true){
        return false;
      } else {
        $("#frm").submit();
        $('.submit').hide();
        $('.loading').show();
        return true;
      }
    }, 1000);

});
function validateEmail(Email) {
  var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
  if (filter.test(Email)) {
    return true;
  }
  else {
    return false;
  }
}

</script>
@endsection
