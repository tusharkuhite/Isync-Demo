@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'Survey Listing- '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@section('content')

<!-- Main content -->
<div class="container-xxl flex-grow-1 container-p-y">

       <div class="d-flex justify-content-between flex-wrap gap-3 top-input-space">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    @if(isset($vUniqueCode))
                    <li class="nav-item">
                      <a class="nav-link " href="{{route('profile.edit',$vUniqueCode)}}"
                        ></i>Basic Information</a
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
                        <a class="nav-link active @if(!isset($vUniqueCode))  @endif " href="{{route('profile.survey_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> Survey</a>
                    </li>
                    @endif
                </ul>
                   
        </div>
    
    <div class="d-flex flex-wrap right-side-top mb-2">
        <div class="count space ms-4">
            Survey @if(isset($totalSurvey))({{$totalSurvey}})@endif
        </div>

       <div class="d-flex flex-wrap justify-content-end right-side-top flex-grow-1 mb-3">
            @if(isset($permission) && $permission != null && ($permission->eWrite == "Yes" || $permission->eDelete == "Yes"))
            <div class="space">
                <select name="eStatus" id="eStatus" class="form-select">
                    <option value="">Action</option>
                    @if($permission->eWrite == "Yes")
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                   
                    @endif
                    @if($permission->eDelete == "Yes")
                    <option value="delete">Delete</option>
                    <option value="Recover">Recover</option>
                    @endif
                </select>
            </div>
            @endif
            @if(isset($permission) && $permission != null && $permission->eDelete == "Yes")
            <div class="space">
                <select name="eDeleted" id="eDeleted" class="form-select">
                    <option value="">Deleted</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            @endif
            @if(isset($permission) && $permission != null && $permission->eWrite == "Yes")
            <div class="space">
                     <a href="{{url('admin/profile/survey_add', $vUniqueCode)}}" class="btn btn-primary">+ Add</a>
            </div>
            @endif
        </div>
    </div>

   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        @if(isset($permission) && $permission != null && ($permission->eWrite == "Yes" || $permission->eDelete == "Yes"))
                        <th style="width: 10px">
                           <div class="checkbox adcheck mt-2">
                              <input id="selectall" type="checkbox" name="selectall" class="css-checkbox form-check-input">
                              <label for="selectall">&nbsp;</label>
                           </div>
                        </th>
                        @endif
                        <th class="text-center search-input">Image</th>
                        <th ><input placeholder="Title" id="vSurvey" type="text" name="vSurvey" class="search form-control"></th>
                        @if(isset($permission) && ($permission->vRole == "Admin" || $permission->vRole == "Sub Admin"))
                            <th class="space-w"><select class="form-select" name="eStatus" id="eStatus_search">
                                  <option value="">Status</option>
                                  <option value="Active">Active</option>
                                  <option value="Inactive">Inactive</option>
                                  <option value="Pending">Pending</option>
                               </select>
                            </th>
                        @endif
                        @if(isset($permission) && $permission != null && $permission->eWrite == "Yes")
                        <th class="text-center space-w">Action</th>
                        @endif
                     </tr>
                  </thead>
                  <tbody id="table_record" class="table-border-bottom-0">
                  </tbody>
               </table>
               <div class="text-center">
                  <div class="spinner-border m-5 text-warning" role="status" class="text-center" id="ajax-loader" style="display:none;">
                     <span class="visually-hidden">Loading...</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('custom-css')
<style></style>
@endsection
@section('custom-js')
<script type="text/javascript">


    function filter(vUniqueCode, vAction, vPages)
    {
        var vUniqueCode      = vUniqueCode;
        var vAction          = vAction;
        var pages            = vPages;
        var vSurvey          = $("#vSurvey").val();
        var eStatus          = $('#eStatus :selected').val();
        var eStatus_search   = $('#eStatus_search :selected').val();
        var eFeature_search  = $('#eFeature_search :selected').val();
        var eDeleted         = $("#eDeleted").val();
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function() {
        $.ajax({
           url: "{{url('admin/profile/survey_ajax_listing', $vUniqueCode)}}",
           type: "POST",
           headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
           data: {vUniqueCode:vUniqueCode,vAction:vAction,pages:pages, vSurvey:vSurvey, eStatus_search:eStatus_search,eStatus:eStatus,eDeleted:eDeleted,eFeature_search:eFeature_search},
           success: function(response) {
               $("#table_record").html(response);
               $('#selectall').prop('checked', false);
               $("#ajax-loader").hide();
           }
       });
       }, 500);
    }

    $(document).ready(function() {
         filter("", "search", "");
    });

    var delayTimer;
    $(document).on("keyup", ".search", function() {
        var value = $(this).val();
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function()
        {
           filter("", "search", "");
        }, 500);
    });

    $(document).on("change", "#eFeature_search", function() {
        filter("", "search", "");
    });

     $(document).on("change", "#eStatus_search", function() {
        filter("", "search", "");
    });

     $(document).on("change", "#iOrder_search", function() {
        filter("", "search", "");
    });

    $(document).on("change", "#eDeleted", function() {
        filter("", "delete", "");
    });

     $(document).on('click', '.ajax_page', function() {
        var vPages           = $(this).data("pages");
        filter("", "search", vPages);

    });


     $(document).on('click', '#selectall', function() {
        if (this.checked) {
            $('.checkboxall').each(function() {
                $(".checkboxall").prop('checked', true);
            });
        } else {
            $('.checkboxall').each(function() {
                $(".checkboxall").prop('checked', false);
            });
        }
    });



   $(document).on('click', '.delete', function() {
        if (confirm('Are you sure delete this data?')) {

            var vUniqueCode = $(this).data("id");
            setTimeout(function() {
                filter(vUniqueCode, "delete", "");
            }, 500);
        }
      });

      $(document).on('change', '#eStatus', function() {
        if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) {
            var eStatus   = $("#eStatus").val();

            if(eStatus != ""){
            if (eStatus == "delete") {

                if (confirm('Are you sure you want to delete?')) {

                        vUniqueCode = [];
                        $("input[name='vUniqueCode[]']:checked").each(function() {
                            vUniqueCode.push($(this).val());
                        });

                        var vUniqueCode = vUniqueCode.join(",");
                        $("#table_record").html('');
                        filter(vUniqueCode, "status", "");
                }
            }
            else if(eStatus == "recover")
            {
                if(confirm('Are you sure recover data?')) {
                        vUniqueCode = [];
                        $("input[name='vUniqueCode[]']:checked").each(function() {
                            vUniqueCode.push($(this).val());
                        });

                        var vUniqueCode = vUniqueCode.join(",");
                        $("#table_record").html('');
                        filter(vUniqueCode, "status", "");
                }
            }
            else {

                if (confirm('Are you sure changes this status?')) {
                        vUniqueCode = [];
                        $("input[name='vUniqueCode[]']:checked").each(function() {
                            vUniqueCode.push($(this).val());
                        });

                        var vUniqueCode = vUniqueCode.join(",");
                        $("#table_record").html('');
                        filter(vUniqueCode, "status", "");
                }
            }
          }
        } else {
            var eStatus   = $("#eStatus").val();
            if(eStatus.length != 0){
            alert('Please Select Data');
            }
        }
    });

</script>
@endsection
