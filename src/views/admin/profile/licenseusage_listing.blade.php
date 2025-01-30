@extends('layouts.admin.index')
@php
$setting_info = \App\Libraries\General::setting_info('Company');
@endphp
@if(isset($MetaTitle) && $MetaTitle->vTitle != null)
    @section('title', $MetaTitle->vTitle .' - '.$setting_info['COMPANY_NAME']['vValue'])
@else
    @section('title', 'License Used Listing- '.$setting_info['COMPANY_NAME']['vValue'])
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
                        <a class="nav-link active @if(!isset($vUniqueCode))  @endif " href="{{route('profile.licenseusage_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> License Used</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link  @if(!isset($vUniqueCode))  @endif " href="{{route('profile.participant_listing',$vUniqueCode)}}"><i class='bx bx-user-circle' ></i> Participant</a
                      >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(!isset($vUniqueCode))  @endif " href="{{route('profile.survey_listing',$vUniqueCode)}}"><i class='bx bx-file-find' ></i> Survey</a>
                    </li>
                    
                @endif
            </ul>
        </div>
    
    <div class="d-flex flex-wrap right-side-top justify-content-between mb-3">
        <div class="count space ms-4">
          License Used <span class="total"></span>
        </div>
        <div class="count space me-4">
          Remaining License <span class="remaining_total"></span>
        </div>
    </div>

   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body table-responsive">
               <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>
                        <select class="form-select" name="iSurveyId" id="iSurveyId">
                          <option value="">Survey</option>
                          @if(isset($survey) && $survey != null)
                          @foreach($survey as $values)
                          <option value="{{$values->iSurveyId}}">{{$values->vSurvey}}</option>
                          @endforeach
                          @endif
                        </select>
                      </th>
                      <th>
                        <select class="form-select" name="iParticipantId" id="iParticipantId">
                          <option value="">Participant</option>
                          @if(isset($participant) && $participant != null)
                          @foreach($participant as $values)
                          <option value="{{$values->iParticipantId}}">{{$values->vFirstName}} {{ $values->vLastName}}</option>
                          @endforeach
                          @endif
                        </select>
                      </th>
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

    $('#iSurveyId').select2();
    $('#iParticipantId').select2();

    function filter(vUniqueCode, vAction, vPages)
    {
        var vAction          = vAction;
        var vUniqueCode      = vUniqueCode;
        var pages            = vPages;
        var iUserId          = $("#iUserId").val();
        var iSurveyId        = $("#iSurveyId").val();
        var iParticipantId   = $("#iParticipantId").val();
      
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function() {
        $.ajax({
           url: "{{url('admin/profile/licenseusage_ajax_listing', $vUniqueCode)}}",
           type: "POST",
           headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
           data: {vUniqueCode:vUniqueCode,vAction:vAction,pages:pages, iUserId:iUserId, iSurveyId:iSurveyId,iParticipantId:iParticipantId},
           success: function(response) {
               $("#table_record").html(response);
               var updatedCount = $("#table_record").find('.count').val();
               $('.total').text('(' + updatedCount + ')');
               var remaining_total = $("#table_record").find('.remaining_total').val();
               $('.remaining_total').text('(' + remaining_total + ')');
               $('#selectall').prop('checked', false);
               $("#ajax-loader").hide();
           }
       });
       }, 500);
    }

    $(document).ready(function() {
        filter("", "search", "");
    });

    $(document).on("change", "#iSurveyId", function() {
        filter("", "search", "");
    });

    $(document).on("change", "#iParticipantId", function() {
        filter("", "search", "");
    });

    $(document).on('click', '.ajax_page', function() {
        var vPages = $(this).data("pages");
        filter("", "search", vPages);
    });
</script>
@endsection
