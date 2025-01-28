@if (!empty($module))
    <div class="banner-blog-dashboard">
        <ul>
            @foreach ($module as $key => $val)
                @php
                    $module_name = str_replace(' ', '', trim(strtolower($val->vModule)));
                @endphp
                @if ($module_name == 'dashboard')
                    @php   $route = route('admin.'.$module_name); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @elseif(in_array($module_name, ['languages', 'report', 'new_report', 'notification', 'log', 'token']))
                    
                @elseif($module_name == 'staticpages')
                    @php    $route = route('admin.page.listing'); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @elseif($module_name == 'profile')
                    @php    $route = route('admin.profile.edit',session()->get('vUniqueCode')); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @elseif($module_name == 'systememail')
                    @php    $route = route('admin.systemEmail.listing'); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @elseif($module_name == 'contact')
                    @php    $route = route('admin.contactus.listing'); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @else
                    @php    $route = route('admin.'.$module_name.'.listing'); @endphp
                    <a href="{{ $route }}">
                        <li>{{ $val->vModule }}</li>
                    </a>
                @endif
            @endforeach
        </ul>
    </div>
@endif
