@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @if(isset($permissions))
    @section('title', 'Permission Edit- '.$setting_info['COMPANY_NAME']['vValue'])
    @else
    @section('title', 'Permission Add- '.$setting_info['COMPANY_NAME']['vValue'])
    @endif
@endif
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($permissions) ? 'Edit' : 'Add' }} Permission</h5>
            </div>
         </div>
         <form action="{{route('admin.permission.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
             <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($permissions)){{$permissions->vUniqueCode}}@endif">
                  <input type="hidden" id="iModuleIds" name="iModuleIds"
                     value="@if(isset($permissions)){{$permissions->iModuleId}}@endif">

                  <div class="row g-3">
                   
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                           <label>Role</label>
                           <select id="iRoleId" name="iRoleId" class="form-select">
                               <option value="">Select Role</option>
                               @foreach($roles as $value)
                               <option value="{{$value->iRoleId}}" @if(isset($permissions->iRoleId)) @if($permissions->iRoleId == $value->iRoleId) selected @endif @endif>{{$value->vRole}}</option>
                               @endforeach
                           </select>
                           <div id="iRoleId_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Role</div>
                     </div>

                     
                     <div class="form-group col-xl-6 col-lg-12 col-md-6 selecttwo-input">
                           <label>Module</label> 
                           <select id="iModuleId" name="iModuleId"  data-live-search="true" class="form-select selectedmodule">
                               @foreach ($modules as $key => $value) 
                               @if(isset($permissions))
                                @if($permissions->iModuleId == $value->iModuleId) 
                                <option value="{{$value->iModuleId}}" selected>{{$value->vModule}}</option>
                                @endif
                                @endif
                               @endforeach
                           </select>
                           <div id="iModuleId_error" class="error mt-1" style="color:red;display: none;">
                               Please Select Module</div>
                     </div>
                    
                    <div  class="form-group col-xl-6 col-lg-12 col-md-6">
                        
                     <div class="form-check form-check-inline col-xl-2 col-lg-12 col-md-2 ps-0">
                           <div class="form-check">
                            <input style="width: 18px;height: 18px;" class="form-check-input check" type="checkbox" value="Yes" @if(isset($permissions)) @if($permissions->eRead =='Yes') checked @endif @endif  id="eRead" name="eRead">
                            <label class="form-check-label" for="eRead"> Read </label>
                          </div>
                     </div>
                     <div class="form-check form-check-inline col-xl-2 col-lg-12 col-md-2">
                          <div class="form-check">
                            <input style="width: 18px;height: 18px;" class="form-check-input check" type="checkbox" value="Yes" @if(isset($permissions)) @if($permissions->eWrite =='Yes') checked @endif @endif  id="eWrite" name="eWrite">
                            <label class="form-check-label" for="eWrite"> Write </label>
                          </div>
                     </div>
                     <div class="form-check form-check-inline col-xl-2 col-lg-12 col-md-2">
                          <div class="form-check">
                            <input style="width: 18px;height: 18px;" class="form-check-input check" type="checkbox" value="Yes" @if(isset($permissions)) @if($permissions->eDelete =='Yes') checked @endif @endif  id="eDelete" name="eDelete">
                            <label class="form-check-label" for="eDelete"> Delete </label>
                          </div>
                     </div>
                     <div id="eCheck_error" class="error mt-1" style="color:red;display: none;">Please Select At least one permission.
                     </div>
                    </div>
                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/permission')}}" class="btn-info btn">Back</a>
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
$(".selectedmodule").select2({             
 placeholder: "Select Module"            
});



var iRoleId = $("#iRoleId").val();
if(iRoleId != ''){
    $('#iModuleId option').each(function() {
       $(this).attr('disabled',false);
    })
    $.ajax({
        url:"{{route('admin.permission.get_module_by_role')}}",
        type: "POST",
        data: {
            iRoleId: iRoleId,
            _token: '{{csrf_token()}}'
        },

        dataType : 'json',
        success: function(result){
           
            if(result.modules != null){ 
                // $('#iModuleId').html('<option value="">Select Menu</option>');
                $.each(result.modules,function(key,value){
                    $("#iModuleId").append('<option value="'+value.iModuleId+'" >'+value.vModule+'</option>');
                });
            }else {
                 $('#iModuleId').html('<option value="">Select Module</option>');
            }
        }
    });
}

 $(document).on('change','#iRoleId',function()
 {
    var iRoleId = $(this).val();
    if(iRoleId != ''){
        $('#iModuleId option').each(function() {
           $(this).attr('disabled',false);
        })
        $.ajax({
            url:"{{route('admin.permission.get_module_by_role')}}",
            type: "POST",
            data: {
                iRoleId: iRoleId,
                _token: '{{csrf_token()}}'
            },

            dataType : 'json',
            success: function(result){
                if(result.modules != null){ 
                    // $('#iModuleId').html('<option value="">Select Module</option>');
                    $.each(result.modules,function(key,value){
                        
                        $("#iModuleId").append('<option value="'+value.iModuleId+'">'+value.vModule+'</option>');
                    });
                }else {
                     $('#iModuleId').html('<option value="">Select Module</option>');
                }
            }
        });
    }
});




   $(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var iRoleId     = $('#iRoleId').find(":selected").val();
       var iModuleId   = $('#iModuleId').find(":selected").val();
       var error = false;
       
       if($("#eRead").is(':checked') || $("#eWrite").is(':checked') || $("#eDelete").is(':checked'))
        {
          $("#eCheck_error").hide(); 
        }else
        {
          $("#eCheck_error").show();
          error = true;
        }

       if (iRoleId.length == 0) {
           $("#iRoleId_error").show();
           error = true;
       } else {
           $("#iRoleId_error").hide();
       }

       if (iModuleId.length == 0) {
           $("#iModuleId_error").show();
           error = true;
       } else {
           $("#iModuleId_error").hide();
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