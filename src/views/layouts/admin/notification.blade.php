
@php
$roles  =\App\Libraries\General::get_role();
use App\Libraries\General;
$awsLink = General::getAmazonS3Link();
@endphp
 
@if(($data->count()))
@foreach($data as $key => $notification)
<li class="list-group-item list-group-item-action dropdown-notifications-item remove_{{$notification->ID}}">
  <div class="d-flex">
    <div class="flex-shrink-0 me-3">
      <div class="avatar">
        @if($notification->eSendto == "Admin")
          @if (!empty($notification->vOrganizationImage) && General::amazonS3FileExist('uploads/user/user_small/'.$notification->vOrganizationImage))
              <img src="{{$awsLink.'uploads/user/user_small/'.$notification->vOrganizationImage}}" alt class="w-px-40 h-auto rounded-circle" />
          @else
              <span class="avatar-initial rounded-circle bg-label-danger">{{$firstCharacter = substr($notification->vCompanyName, 0, 1)}}</span>
          @endif
        @elseif($notification->eSendto == "Company")
          @if (!empty($notification->vAdminImage) && General::amazonS3FileExist('uploads/user/user_small/'.$notification->vAdminImage))
              <img src="{{$awsLink.'uploads/user/user_small/'.$notification->vAdminImage}}" alt class="w-px-40 h-auto rounded-circle" />
          @else
              <span class="avatar-initial rounded-circle bg-label-danger">{{$firstCharacter = substr($notification->vCompanyName, 0, 1)}}</span>
          @endif
        @endif
      </div>
    </div>
    <div class="flex-grow-1">
      <h6 class="mb-1">{{$notification->eModule}}{{' '}}{{$notification->eSendType}}</h6> 
      <p class="mb-0"><strong>@if($roles->vRole != "Company"){{$notification->vCompanyName}}{{' '}}@endif</strong>{{$notification->vNotification}}</p>
      <?php
          $date = new DateTime($notification->dtDateTime);
          $formattedDate = $date->format("M d, Y h:i A");
      ?>
      <small class="text-muted">{{$formattedDate }}</small>
    </div>
    <div class="flex-shrink-0 dropdown-notifications-actions">
      <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
      <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x removeclick_{{$notification->ID}} remove-icon"></span></a>
    </div>
  </div>
</li>
@endforeach
@else
<li>
   <li align="center" class="mb-4 mt-2"><i class='bx bxs-bell-off'></i>  Notification Not Found</li>
</li>
@endif

<script type="text/javascript">
@if($data->count() != 0)
@foreach($data  as $notification)
  $('.removeclick_{{$notification->ID}}').on('click', function() {

      $('.remove_{{$notification->ID}}').hide();
  });
@endforeach
@endif
</script>