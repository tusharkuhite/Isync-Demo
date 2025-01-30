@extends('layouts.admin.index')
@section('content')

<!-- Main content -->
<div class="container-xxl flex-grow-1 container-p-y">
<div class="d-flex gap-3 top-input-space">
        <h5 class="space">
           Meta <span class="total"></span>
        </h5> 

        <div class="d-flex flex-wrap right-side-top">
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
                    @endif  
                </select>
            </div>
            @endif
            
            @if(isset($permission) && $permission != null && $permission->eWrite == "Yes")
            <div class="space">
                   <a href="{{route('admin.meta.add')}}" class="btn btn-primary">+ Add</a>
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
                        
                        <th class="space-w"> <select class="form-select" name="ePanel" id="ePanal_search">
                              <option value="">Panel</option>
                              <option value="Admin">Admin</option>
                              <option value="Front">Front</option>
                           </select>
                        </th>
                        <th><input placeholder="Title" id="vTitle" type="text" name="vTitle" class="search form-control"></th>
                        <th class="space-w text-center">Controller</th>
                        <th class="space-w text-center">Method</th>
                        <th><input placeholder="Slug" id="vSlug" type="text" name="vSlug" class="search form-control"></th>
                        
                        <!-- <th class="space-w"> <select class="form-select" name="eStatus" id="eStatus_search">
                              <option value="">Status</option>
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                           </select>
                        </th> -->
                        
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
    $("#ePanal_search").select2();
    function filter(vUniqueCode, vAction, vPages)
    {   
        var vUniqueCode      = vUniqueCode;
        var vAction          = vAction;
        var pages            = vPages;
        var vController      = $('#vController :selected').val();
        var ePanal_search    = $('#ePanal_search :selected').val();
        var vTitle           = $("#vTitle").val();
        var vSlug            = $("#vSlug").val();
        var eStatus          = $('#eStatus :selected').val();
        // var eStatus_search   = $('#eStatus_search :selected').val();
        var eFeature_search  = $('#eFeature_search :selected').val();
        var eDeleted         = $("#eDeleted").val();
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function() {
        $.ajax({
           url: "{{route('admin.meta.ajax_listing')}}",
           type: "POST",
           headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
           data: {vUniqueCode:vUniqueCode, vAction:vAction, pages:pages, vController:vController, vTitle:vTitle,eStatus:eStatus,eDeleted:eDeleted, ePanal_search:ePanal_search, eFeature_search:eFeature_search,vSlug:vSlug,},
           success: function(response) {
               $("#table_record").html(response);
               var updatedCount = $("#table_record").find('.count').val();
               $('.total').text('(' + updatedCount + ')');
               $('#selectall').prop('checked', false); 
               $("#ajax-loader").hide();
           }
       });
       }, 1000);
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

    $(document).on("change", "#vController", function() {
       
        filter("", "search", "");
    });

    $(document).on("change", "#ePanal_search", function() {
       
        filter("", "search", "");
    });

    // $(document).on("change", "#eStatus_search", function() {
       
    //     filter("", "search", "");
    // });

    $(document).on("change", "#eFeature_search", function() {
       
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

    $(document).on('click', '.recover', function() {
        if (confirm('Are you sure recover this data?')) {
            vUniqueCode = $(this).data("id");
           
            setTimeout(function() {
                filter(vUniqueCode, "recover", "");
            }, 500);
        }
    });

    $(document).on('change', '#eStatus', function() {
        if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) {
            var eStatus   = $("#eStatus").val();

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
        } else {
            var eStatus   = $("#eStatus").val();
            if(eStatus.length != 0){
            alert('Please Select Data');
            }
        }
    });

</script>
@endsection