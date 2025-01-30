@extends('layouts.admin.index')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($metas) ? 'Edit' : 'Add' }} Meta</h5>
            </div>
         </div>

         <form action="{{route('admin.meta.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
            <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($metas)){{$metas->vUniqueCode}}@endif">
                     <input type="hidden" id="iMetaId" name="iMetaId"
                     value="@if(isset($metas)){{$metas->iMetaId}}@endif">
                     <input type="hidden" id="selected_vMethod" name="selected_vMethod"
                     value="@if(isset($metas)){{$metas->vMethod}}@endif">
                    <div class="row g-3"> 
                       

                       <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Panel</label>
                            <select name="ePanel" id="ePanel" class="form-select">
                               <option value="">Select Panel</option>
                               <option value="Admin" @if(isset($metas)) @if($metas->ePanel ==
                               'Admin') selected @endif @endif>Admin</option>
                               <option value="Front" @if(isset($metas)) @if($metas->ePanel ==
                               'Front') selected @endif @endif>Front</option>
                            </select>
                            <div id="ePanel_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Panel
                            </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Title</label>
                            <input type="text" name="vTitle" id="vTitle" class="form-control" placeholder="Enter Title" value="@if(isset($metas)){{$metas->vTitle}}@endif">
                            <div id="vTitle_error" class="error mt-1" style="color:red;display: none;">
                               Please Enter Title
                            </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6 adminside" style="display:none;">
                           <label>Controller</label>
                           <select id="vController" name="vController" class="form-select">
                               <option value="">Select Controller</option>
                               @if(isset($controllers))
                               @foreach($controllers as $keyController=>$value)
                               <option value="{{$keyController}}" @if(isset($metas)) @if($metas->vController == $keyController) selected @endif @endif>{{$keyController}}</option>
                               @endforeach
                               @endif
                           </select>
                           <div id="vController_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Controller
                           </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6 adminside"  style="display:none;">
                           <label>Method</label>
                           <select id="vMethod" name="vMethod" class="form-select">
                               <option value="">Select Method</option>
                           </select>
                           <div id="vMethod_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Method
                           </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6 frontside"  style="display:none;">
                            <label>Slug</label>
                            <input type="text" name="vSlug" id="vSlug" class="form-control" placeholder="Enter Slug ex.survey-id" value="@if(isset($metas)){{$metas->vSlug}}@endif">
                            <div id="vSlug_error" class="error mt-1" style="color:red;display: none;">
                               Please Enter Slug
                            </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Keyword </label>
                            <textarea class="form-control" name="tKeyword" id="tKeyword" class="form-control"
                               placeholder="Enter Keyword" rows="2">@if(isset($metas->tKeyword)){{$metas->tKeyword}}@endif</textarea>
                            <div id="tKeyword_error" class="error mt-1" style="color:red;display: none;">
                               Please Enter Keyword
                            </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Status</label>
                            <select name="eStatus" id="eStatus" class="form-select">
                               <option value="">Select Status</option>
                               <option value="Active" @if(isset($metas)) @if($metas->eStatus == 'Active')
                               selected @endif @endif>Active</option>
                               <option value="Inactive" @if(isset($metas)) @if($metas->eStatus ==
                               'Inactive') selected @endif @endif>Inactive</option>
                            </select>
                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Status
                            </div>
                        </div>

                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                            <label>Description </label>
                            <textarea class="form-control" name="tDescription" id="tDescription" class="form-control"
                               placeholder="Enter Decription" rows="2">@if(isset($metas->tDescription)){{$metas->tDescription}}@endif</textarea>
                            <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">
                               Please Enter Decription
                            </div>
                        </div>
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{route('admin.meta.listing')}}" class="btn-info btn">Back</a>
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

<script type="text/javascript">

 $('#vController').select2();
 $('#vMethod').select2();
 $(document).ready(function() {
    @if(isset($metas))
    var panal = "{{$metas->ePanel}}"
    if ( panal === 'Front') {
        $('.adminside').hide();
        $('.frontside').show();
    } else {
        $('.adminside').show();
        $('.frontside').hide();
    }
    @endif

    $('#ePanel').change(function() {
        if ($(this).val() === 'Front') {
            $('.adminside').hide();
            $('.frontside').show();
        } else {
            $('.adminside').show();
            $('.frontside').hide();
        }
    });
});
    $(document).ready(function() 
   { 
        var vController                = $("#vController").val(); 
        var selected_vMethod           = $("#selected_vMethod").val();
       

        if(vController.length != 0){
            $("#vMethod").html('');
            $.ajax({
                url:"{{route('get-method-by-controller')}}",
                type: "POST",
                data: {
                    vController: vController,
                    _token: '{{csrf_token()}}' 
                },

                dataType : 'json',
                success: function(result){
                    $('#vMethod').html('<option value="">Select Method</option>'); 
                    
                    $.each(result,function(key,value){
                        if (selected_vMethod == value) {
                            
                            $('select[name="vMethod"]').append('<option selected value="'+value+'">'+value+'</option>');
                        }else{
                            $("#vMethod").append('<option value="'+value+'">'+value+'</option>');
                        }
                    });
                }
            });
        }else{
         $('#vMethod').html('<option value="">Select Method</option>');
        }

    });

    $('#vController').on('change', function() {
        var vController = $("#vController").val();
         //alert(vController.length);

        if(vController.length != 0){
            $("#vMethod").html('');
            $.ajax({
                url:"{{route('get-method-by-controller')}}",
                type: "POST",
                data: {
                    vController: vController,
                    _token: '{{csrf_token()}}' 
                },

                dataType : 'json',
                success: function(result){
                   
                    $('#vMethod').html('<option value="">Select Method</option>'); 
                    $.each(result,function(key,value){
                        $("#vMethod").append('<option value="'+value+'">'+value+'</option>');
                    });
                }
            });
        }else{
           $('#vMethod').html('<option value="">Select Method</option>');
        }
    });
    $(document).on('click', '.submit', function() {
       var vUniqueCode        = $("#vUniqueCode").val();
       var eStatus            = $("#eStatus").val();
       var vController        = $("#vController").val();
       var vMethod            = $("#vMethod").val();
       var ePanel             = $("#ePanel").val();
       var tKeyword           = $("#tKeyword").val();
       var vSlug              = $("#vSlug").val();
       var vTitle             = $("#vTitle").val();
       var tDescription       = $("#tDescription").val();
       var error              = false;

    
        if(ePanel == "Admin")
        {
           if (vController.length == 0) {
               $("#vController_error").show();
               error = true;
           } else {
               $("#vController_error").hide();
           }

           if (vMethod.length == 0) {
               $("#vMethod_error").show();
               error = true;
           } else {
               $("#vMethod_error").hide();
           }
        }

        if(ePanel == "Front")
        {
            if (vSlug.length == 0) {
               $("#vSlug_error").show();
               error = true;
            } else {
               $("#vSlug_error").hide();
            }
        }

       if (ePanel.length == 0) {
           $("#ePanel_error").show();
           error = true;
       } else {
           $("#ePanel_error").hide();
       }

       if (vTitle.length == 0) {
           $("#vTitle_error").show();
           error = true;
       } else {
           $("#vTitle_error").hide();
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