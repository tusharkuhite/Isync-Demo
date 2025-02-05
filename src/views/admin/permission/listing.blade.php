@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'Permission Listing- '.$setting_info['COMPANY_NAME']['vValue'])
@endif
@section('content')

<!-- Main content -->
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="d-flex justify-content-between flex-wrap gap-3 top-input-space"> 
        
    <h5 class="space">
       Permission <span class="total"></span>
    </h5> 
    <div class="d-flex flex-wrap right-side-top"> 
        @if(isset($permission) && $permission != null && ($permission->eWrite == "Yes" || $permission->eDelete == "Yes"))
        <div class="space">  
            <select name="eStatus"  id="eStatus" class="form-select">
                <option value="">Action</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        @endif
        <div class="space">
                 <a href="{{route('admin.permission.add')}}" class="btn btn-primary">+ Add</a>
        </div>
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
                        <th><select id="vModule" name="vModule"  data-live-search="true" class="form-select selectedmodule">
                               <option  value="">Modules</option>
                               @foreach($modules as $value)
                               <option value="{{$value->vModule}}" @if(isset($permissions)) @if($permissions->vModule == $value->vModule) selected @endif @endif>{{$value->vModule}}</option>
                               @endforeach
                            </select>
                         </th>
                         <th>
                            <select id="iRoleId" name="iRoleId" class="form-select selectedrole">
                               <option value="">Role</option>
                               @foreach($roles as $value)
                               <option value="{{$value->iRoleId}}" @if(isset($permissions)) @if($permissions->iRoleId == $value->iRoleId) selected @endif @endif>{{$value->vRole}}</option>
                               @endforeach
                            </select>
                         </th>
                         
                        <th class="text-center text-nowrap">
                            <div class="dropdown">Read
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="orederStatistics"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i  data-toggle="tooltip_view" title="Add / View" class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                  <a class="dropdown-item readpermission " data-value="Yes" href="javascript:void(0);">Yes</a>
                                  <a class="dropdown-item readpermission" data-value="No" href="javascript:void(0);">No</a>
                                </div>
                            </div>
                        </th>
                        <th class="text-center text-nowrap">
                            <div class="dropdown">Write
                                @if(isset($permission) && $permission != null && $permission->eWrite == "Yes")
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="orederStatistics"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i  data-toggle="tooltip_view" title="Add / View" class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                  <a class="dropdown-item writepermission " data-value="Yes" href="javascript:void(0);">Yes</a>
                                  <a class="dropdown-item writepermission" data-value="No" href="javascript:void(0);">No</a>
                                </div>
                                @endif
                            </div>
                        </th> 
                        <th class="text-center text-nowrap">
                            <div class="dropdown">Delete
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="orederStatistics"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i  data-toggle="tooltip_view" title="Add / View" class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item deletepermission " data-value="Yes" href="javascript:void(0);">Yes</a>
                                <a class="dropdown-item deletepermission" data-value="No" href="javascript:void(0);">No</a>
                                </div>
                            </div>
                        </th>
                       
                        <th class="text-center space-w">Action</th>
                       
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
    $("#vModule").select2();
    $("#iRoleId").select2();
    function filter(vUniqueCode, vAction, vPages , iRoleId ,vModule ,eRead ,eWrite ,eDelete)
    {   
        var vUniqueCode      = vUniqueCode;
        var vAction          = vAction;
        var pages            = vPages;
        var iRoleId          = iRoleId;
        var vModule        = vModule;
        var eRead            = eRead;
        var eWrite           = eWrite;
        var eDelete          = eDelete;
        var vKeyword         = $("#vKeyword").val();
        var vRole            = $("#vRole").val();
        var vModule          = $("#vModule").val();
        var eStatus          = $('#eStatus :selected').val();
        var eDeleted         = $("#eDeleted").val();
        var vCode            = $("#vCode").val();
        $("#eStatus").val('');
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function() {
        $.ajax({
           url: "{{url('admin/permission/ajax_listing')}}",
           type: "POST",
           headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
           data: {vUniqueCode:vUniqueCode,iRoleId:iRoleId,vModule:vModule,vAction:vAction, pages:pages,eStatus:eStatus,vModule:vModule,vKeyword:vKeyword,vRole:vRole,eStatus:eStatus,eRead:eRead,eWrite:eWrite,eDelete:eDelete,},
           success: function(response) {
               $("#table_record").html(response);
               var updatedCount = $("#table_record").find('.count').val();
               $('.total').text('(' + updatedCount + ')');
               $('#selectall').prop('checked', false); 
               $("#ajax-loader").hide();
           }
       });
       }, 500);
    }

    $(document).ready(function() {
        
         filter("", "search", "","","","","","");

    });

     $(document).on("change", ".selectedrole", function() {
        var iRoleId    = $(this).val();
        var vModule  = $('#vModule :selected').val();
         filter("", "search", "",iRoleId,vModule,"","","","");
    });

      $(document).on("change", ".selectedmodule", function() {
        var vModule   = $(this).val();
        var iRoleId     = $('#iRoleId :selected').val();  
         filter("", "search", "",iRoleId,vModule,"","","");
    });

    var delayTimer;
    $(document).on("keyup", ".search", function() {
        var vModule   = $('#vModule :selected').val();
        var iRoleId     = $('#iRoleId :selected').val();
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function()
        {
           filter("", "search", "",iRoleId,vModule,"","","");
        }, 500);
    });


    $(document).on('click', '.ajax_page', function() {
        var vPages      = $(this).data("pages");
        filter("", "search", vPages,"","","","","");
     
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
                filter(vUniqueCode, "delete", "","","","","","");
            }, 500);
        }
      });
      
      $(document).on('click', '.readpermission', function() {
           if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) 
           {
                    var eRead  = $(this).data("value");
                    if(eRead != "")
                    {
                        if (eRead == "Yes") 
                        {
                            if (confirm('Are you sure you want to give Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","",eRead,"","");
                            }
                        }
                        else if (eRead == "No") 
                        {
                            if (confirm('Are you sure you want to withdraw Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","",eRead,"","");
                            }
                        }
                    }
            }
            else
            {
                var eRead = $(this).data("value");
                if(eRead.length != 0){
                alert('Please Select Data');
                }
            }  
      });

      $(document).on('click', '.writepermission', function() {
           if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) 
           {
                    var eWrite  = $(this).data("value");
                    if(eWrite != "")
                    {
                        if (eWrite == "Yes") 
                        {
                            if (confirm('Are you sure you want to give Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","","",eWrite,"");
                            }
                        }
                        else if (eWrite == "No") 
                        {
                            if (confirm('Are you sure you want to withdraw Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","","",eWrite,"");
                            }
                        }
                    }
            }
            else
            {
                var eWrite = $(this).data("value");
                if(eWrite.length != 0){
                alert('Please Select Data');
                }
            }  
      });

      $(document).on('click', '.deletepermission', function() {
           if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) 
           {
                    var eDelete  = $(this).data("value");
                    if(eDelete != "")
                    {
                        if (eDelete == "Yes") 
                        {
                            if (confirm('Are you sure you want to give Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","","","",eDelete);
                            }
                        }
                        else if (eDelete == "No") 
                        {
                            if (confirm('Are you sure you want to withdraw Permission?')) 
                            {
                                vUniqueCode = [];
                                $("input[name='vUniqueCode[]']:checked").each(function() 
                                {
                                    vUniqueCode.push($(this).val());
                                });

                                var vUniqueCode = vUniqueCode.join(",");
                                $("#table_record").html('');
                                filter(vUniqueCode, "status", "","","","","",eDelete);
                            }
                        }
                    }
            }
            else
            {
                var eDelete = $(this).data("value");
                if(eDelete.length != 0){
                alert('Please Select Data');
                }
            }  
      });

      $(document).on('change', '#eStatus', function() {
            if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true)
            {
                var eStatus   = $("#eStatus").val();
                if(eStatus != ""){
                if (eStatus == "delete")
                {
                    if (confirm('Are you sure you want to delete?'))
                    {
                            vUniqueCode = [];
                            $("input[name='vUniqueCode[]']:checked").each(function() 
                            {
                                vUniqueCode.push($(this).val());
                            });

                            var vUniqueCode = vUniqueCode.join(",");
                            $("#table_record").html('');
                            filter(vUniqueCode, "status", "","","","","","");
                    }
                }
              }
            } 
            else
            {
                var eStatus   = $("#eStatus").val();
                if(eStatus.length != 0){
                alert('Please Select Data');
                }
            }
      });

</script>
@endsection