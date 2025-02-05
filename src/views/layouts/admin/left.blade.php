@php 
  $setting_info = \App\Libraries\General::setting_info('Company');
  $url   = Request::segment(2);
  $url1  = Request::segment(1);
  $url2  = Request::segment(3);
  $dashPermission  = \App\Libraries\General::dash_permission();
  $menu_module     = \App\Libraries\General::menu_module();
  
  $setting = array('Company','Email','Social','Config');
  $requests = array('Competency','Statement','Option');
  $settings = $setting;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
   <div class="app-brand demo">
      <a href="{{route('admin.dashboard')}}" class="app-brand-link">
       <span class="app-brand-logo demo">
          <div class="logo">
             <!-- Brand Logo -->
             <img  src="{{asset('uploads/logo/'.$setting_info['COMPANY_LOGO']['vValue'])}}" alt="Logo" srcset="">
          </div>
       </span>
      </a>
     
    
      <a href="" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
   </div>
   <div class="menu-inner-shadow"></div>
   <ul class="menu-inner py-1">
      <?php $allpermisssion = []; ?>
      @foreach($menu_module as $menuskey=>$menues)
            @foreach($menues as $menuvalkey=>$menuval)
               @if(!empty($menuval->permissionData)) 

                  @if(isset($menuval->permissionData) && $menuval->permissionData[0] == "Yes")
                     @if(isset($menuval->controllers) && $menuval->controllers != null && strtolower($menuval->controllers[0]) != strtolower($menuval->vMenu))
                        <li class="menu-item @if(in_array($url ,$menuval->controllers)) active open @endif ">
                           <a href="javascript:void(0);" class="menu-link menu-toggle">
                              <i class="menu-icon tf-icons {{$menuval->vCode}}"></i>
                              <div data-i18n="Layouts">{{$menuval->vMenu}}</div>
                           </a>
                     @else
                        <li class="menu-item @if($url == $menuval->controllers[0]) active @endif">
                           <a href="{{url('admin',$menuval->controllers[0])}}" class="menu-link ">
                              <i class="menu-icon tf-icons {{$menuval->vCode}}"></i>
                              <div data-i18n="Layouts">{{$menuval->vMenu}}</div>
                           </a>
                        </li>
                     @endif
                     @foreach($menuval->iModuleId as $key=>$modelval)
                        @if($modelval->iModuleId != null)
                        <?php $module = strtolower(strstr($modelval->vController,'Controller', true)); 
                           ?>
                           
                           @if($modelval->permissionData != null)
                           
                              @if($modelval->permissionData->eRead == "Yes")
                                 @if(($modelval->vController != "SettingController") && ($modelval->vController != "RequestController"))
                                    <ul class="menu-sub">
                                       <li class="menu-item @if($url == $module) active @endif ">
                                          <a href="{{url('admin',$module)}}" class="menu-link">
                                             <div data-i18n="{{$modelval->vModule}}">{{$modelval->vModule}}</div>
                                          </a>
                                       </li>
                                    </ul>
                                    
                                 @elseif($modelval->vController == "RequestController")
                                 @foreach($requests as $req)
                                       <ul class="menu-sub">
                                          <li class="menu-item @if($url2 == $req) active @endif ">
                                             <a href="{{url('admin/request',$req)}}" class="menu-link">
                                                <div data-i18n="{{$modelval->vModule}}">{{$req}}</div>
                                             </a>
                                          </li>
                                       </ul>
                                    @endforeach
                                 @else
                                    @foreach($settings as $setting)
                                       <ul class="menu-sub">
                                          <li class="menu-item @if($url2 == $setting) active @endif ">
                                             <a href="{{url('admin/setting',$setting)}}" class="menu-link">
                                                <div data-i18n="{{$modelval->vModule}}">{{$setting}}</div>
                                             </a>
                                          </li>
                                       </ul>
                                    @endforeach
                                 @endif
                              @endif
                           @endif
                        @endif
                     @endforeach 
                     </li> 
                  @endif
                  <?php $allpermisssion[] = $menuval->permissionData; ?>
               @endif
            @endforeach
      @endforeach
      @if(count($allpermisssion) == null) 
          <ul>
             <li class="menu-item">
                <div>No Menu</div>
             </li>
          </ul>
      @endif
   </ul>
</aside>
        <!-- / Menu -->
<script src="{{asset('admin/assets/libs/jquery/jquery.js')}}"></script>