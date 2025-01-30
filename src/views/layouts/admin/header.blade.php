@php
use App\Libraries\General;
$setting_info = General::setting_info('Company');
$userName  = session('username');
$userImage = session('vWebpImage');
$userUniqueCode = session('vUniqueCode');
$roles  = General::get_role();
@endphp
 <!-- Navbar -->
<?php
       $controllers = [];
       foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
            if (array_key_exists('controller', $action))
            {
                $controllers[]  = $action['controller'];
                $result = preg_grep('/^App/', $controllers);
            }
        }
        $i = 0;
        foreach ($result as $key => $val)
        {
            $find = array("\\");
            $replace = array("-");
            $arry[] = str_replace($find,$replace,$val);
            $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
            $i++;
        }

        $j = 0;
        foreach ($results as $key => $vals)
        {
                $tests[]  = explode("-",$vals);
                $lastElementResult = end($tests[$j]);
                $arrry1[] = explode("@",$lastElementResult);
                $ControllerName[] = $arrry1[$j][0];
                $j++;
        }
        sort($ControllerName);
        $clength = count($ControllerName);
        for($x = 0; $x < $clength; $x++) {
          $ControllerName[$x];

        }

        $listofcontrollers = array_unique($ControllerName);

        if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
            //dd($key);
           unset($listofcontrollers[$key]);
        }
         if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
            //dd($key);
           unset($listofcontrollers[$key]);
        }

        if (($key = array_search('DashboardController', $listofcontrollers)) !== false) {
            //dd($key);
           unset($listofcontrollers[$key]);
        }

        $data['listofcontrollers'] = $listofcontrollers;
        foreach( $data['listofcontrollers'] as $controllers){
          $modelss [] = strtolower(strstr($controllers, 'Controller', true));
        }

 ?>

 <style type="text/css">
   .layout-navbar .navbar-dropdown.dropdown-notifications .dropdown-notifications-list {
        max-height: 30rem !important;
        overflow-y: auto;
    }
  .layout-navbar .navbar-dropdown .badge-notifications {
      padding: 0.2rem 0.4rem;
      top: 0.5rem;
  }

  .badge.badge-notifications {
      display: inline-block;
      margin: 0;
      position: absolute;
      top: auto;
      -webkit-transform: translate(-50%,-30%);
      transform: translate(-93%,-30%);
  }
  .badge.badge-notifications:not(.badge-dot) {
      font-size: .682rem;
      line-height: .85rem;
      padding: 0.07rem 0.3rem;
  }
    
  .notification-icon {
      display: flex;
      align-items: center;
      position: relative;
  }

  .badge-notifications {
      position: absolute;
      top: 0;
      right: -20px;
      transform: translateY(-50%);
      z-index: 1;
      font-size: 12px;
  }


  @media (max-width: 767.98px)
  .layout-navbar .navbar-nav .nav-item.dropdown .badge-notifications {
      top: auto;
  }
  .layout-navbar .navbar-dropdown .badge-notifications {
      padding: 0.2rem 0.4rem;
      top: 0.5rem;
  }
}

 </style>

    <nav
      class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
      id="layout-navbar"
    >
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input
              type="text"
              list="datalist"
              id="module_search"
              class="form-control border-0 shadow-none inputBarcodeField"
              placeholder="Search..."
              aria-label="Search..."
            />
          </div>
          <div id="modules"></div>
        </div>

        <button style="display: none;" class="submit_search" type="button" onclick="myFunction()">search</button>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Place this tag where you want the button to render. -->

            <!-- Notification -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
          <a class="nav-link dropdown-toggle hide-arrow viewclick" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <i id="bellid" class="bx bx-bell bx-sm"></i>
            <span class="badge bg-danger rounded-pill badge-notifications notificationcount" style="display:none;"></span>
          </a>
          @php  $uniqueid =  time();  @endphp
          <ul class="dropdown-menu dropdown-menu-end py-0 notification-popup_{{$uniqueid}}">
            <li class="dropdown-menu-header border-bottom">
              <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Notification</h5>
                <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a> 
              </div>
            </li>
            <li class="dropdown-notifications-list scrollable-container">
              <ul class="list-group list-group-flush" id="notification_record">

              </ul>
            </li>
            <li class="dropdown-menu-footer border-top p-3">
             {{-- <button class="btn btn-primary text-uppercase w-100" onclick="window.location.href = '{{ route('notification.listing') }}'">View All Notifications</button> --}}
            </li>
          </ul>
        </li>
        <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                  @if($userImage != null && file_exists(public_path("uploads/user/user_small/".$userImage)))
                      <img src="{{asset('uploads/user/user_small/'.$userImage)}}" class="w-px-40 h-auto rounded-circle" />
                  @else
                      <img alt="no-image" class="card-img-top" src="{{asset('admin/assets/img/avatars/male.jpg')}}">
                  @endif
              </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 15rem !important;">
              <li>
                <a class="dropdown-item" href="#">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        @if ($userImage != null && file_exists(public_path("uploads/user/user_small/" . $userImage)))
                            <img src="{{asset('uploads/user/user_small/'.$userImage)}}" alt class="w-px-40 h-auto rounded-circle" />
                        @else
                              <img alt="no-image" class="card-img-top" src="{{asset('admin/assets/img/avatars/male.jpg')}}">
                        @endif
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">@if(isset($userName) && $userName != null){{$userName}}@endif</span>
                      <small class="text-muted">@if(isset($roles) && $roles != null){{$roles->vRole}}@endif</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{url('admin/profile/'.$userUniqueCode)}}">
                  <i class="bx bx-user me-2"></i>
                  <span class="align-middle">My Profile</span>
                </a>
              </li>
    
              <li>
                <a class="dropdown-item" href="{{url('admin/profile/change_password',$userUniqueCode)}}">
                 <i class='bx bx-lock-open-alt'></i>
                  <span class="align-middle">Change Password</span>
                </a>
              </li>
          <!--     <li>
                <a class="dropdown-item" href="#">
                  <i class="bx bx-cog me-2"></i>
                  <span class="align-middle">Settings</span>
                </a>
              </li>

              <li>
                <a class="dropdown-item" href="#">
                  <span class="d-flex align-items-center align-middle">
                    <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                    <span class="flex-grow-1 align-middle">Billing</span>
                    <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                  </span>
                </a>
              </li> -->
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="{{route('admin.logout')}}">
                  <i class="bx bx-power-off me-2"></i>
                  <span class="align-middle">Log Out</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>
    </nav>

    <!-- / Navbar -->

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"></script>
<script>
  $(document).on('keyup', '#module_search', function() {
   let searchTimeout;
   let vModule = $(this).val().trim(); 
   clearTimeout(searchTimeout);
   searchTimeout = setTimeout(function() {
       search_module(vModule); 
   }, 500);
});

function search_module(vModule) {
   $.ajax({
       url: "{{route('admin.module.search_module')}}",
       type: "POST",
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       data: {
           vModule: vModule,
       },
       success: function(response) {
           $("#modules").html(response);
       }
   });
}

</script>