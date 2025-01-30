@extends('layouts.admin.index')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-md-12">
         <div class="row mb-2">
            <div class="col-sm-6 mt-2">
                <h5>{{ isset($paginations) ? 'Edit' : 'Add' }} Pagination</h5>
            </div>
         </div>
  
         <form action="{{route('admin.pagination.store')}}" name="frm" id="frm" method="post"
               enctype="multipart/form-data">
               @csrf
             <div class="card mb-4">
                <div class="card-body">
                  <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                     value="@if(isset($paginations)){{$paginations->vUniqueCode}}@endif">
                  <div class="row g-3">
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Controller</label>
                        <select id="vController" name="vController" class="form-select">
                            <option value="">Select Controller</option>
                         
                            @foreach($listofcontrollers as $value)
                            <option value="{{$value}}" @if(isset($paginations)) @if($paginations->vController == $value) selected @endif @endif>@php echo strstr($value, 'Controller', true);@endphp</option>
                            @endforeach

                        </select>
                        <div id="vController_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Controller
                        </div>
                    </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Size</label>
                        <input type="text" name="vSize" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" min="1" id="vSize" class="form-control"
                           placeholder="Enter Size Per Page"
                           value="@if(isset($paginations)){{$paginations->vSize}}@endif">
                        <div id="vSize_error" class="error mt-1" style="color:red;display: none;">
                           Please Enter Size
                        </div>
                     </div>
                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Status</label>
                        <select name="eStatus" id="eStatus" class="form-select">
                           <option value="">Select Status</option>
                           <option value="Active" @if(isset($paginations)) @if($paginations->eStatus == 'Active')
                           selected @endif @endif>Active</option>
                           <option value="Inactive" @if(isset($paginations)) @if($paginations->eStatus ==
                           'Inactive') selected @endif @endif>Inactive</option>
                        </select>
                        <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                           Please Select Status
                        </div>
                     </div>

                  </div>
               </div>
               <div class="card-footer col-12 align-self-end d-inline-block mt-0 text-left">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{route('admin.pagination.listing')}}" class="btn-info btn">Back</a>
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

@if(isset($paginations))
$('#vController ').attr("disabled", true);
@endif
   $(document).on('click', '.submit', function() {
       var vUniqueCode = $("#vUniqueCode").val();
       var vController = $("#vController").val();
       var vSize       = $("#vSize").val();
       var eStatus     = $("#eStatus").val();

       var error = false;
   
       if (vController.length == 0) {
           $("#vController_error").show();
           error = true;
       } else {
           $("#vController_error").hide();
       }
       if (vSize.length == 0) {
           error = true;
           $("#vSize_error").show();
       } else {
           $("#vSize_error").hide();
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