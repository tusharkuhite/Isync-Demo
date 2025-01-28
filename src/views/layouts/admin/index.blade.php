@php
    use App\Libraries\General;

    $url = url()->current();
    $controller = class_basename(Route::current()->controller);
    $method = Route::getCurrentRoute()->getActionMethod();
    $criteria = [];
    $criteria['ePanel'] = 'Admin';
    $criteria['vController'] = $controller;
    $criteria['vMethod'] = $method;
    $criteria['eStatus'] = 'Active';
    $meta_info = General::meta_info($criteria);

    $general_favicon = General::setting_info('Company');
    $favicon = isset($general_favicon['COMPANY_FAVICON']['vValue'])?$general_favicon['COMPANY_FAVICON']['vValue']:null;
    $logo = isset($general_favicon['COMPANY_LOGO']['vValue'])?$general_favicon['COMPANY_LOGO']['vValue']:null;
    $title = isset($general_favicon['COMPANY_NAME']['vValue'])?$general_favicon['COMPANY_NAME']['vValue']:null;
    $desc = isset($general_favicon['COMPANY_DESC']['vValue'])?$general_favicon['COMPANY_DESC']['vValue']:null;
    $general_info = General::setting_info('Appearance');
@endphp

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@if(isset($meta_info->tDescription)) {{ $meta_info->tDescription }}@else @if(isset($desc)){!!$desc!!}@else Johari 360 bespoke evaluation tool to provide a high performance leadership culture through our emotional intelligence feedback platform @endif @endif">
    <meta name="keywords" content="@if(isset($meta_info->tKeyword)){{$meta_info->tKeyword }}@endif">
    <meta name="author" content="">
    <meta property="og:title"
        content=" @if (isset($meta_info->vTitle)){{ $meta_info->vTitle }}@else Admin Panel @endif | @if (isset($title)){{ $title }} @else Johari360 @endif" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="@if (isset($url)) {{ $url }} @endif" />
    <meta property="og:image:url" content="{{ asset('uploads/logo/'.$logo) }}" />
    <meta property="og:description"
        content="@if(isset($meta_info->tDescription)) {!! $meta_info->tDescription !!}@else  @if(isset($desc)){!!$desc!!}@else Johari 360 bespoke evaluation tool to provide a high performance leadership culture through our emotional intelligence feedback platform @endif @endif" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logo/' . $favicon) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google tag (gtag.js) -->
   
    <title>
        @if (isset($meta_info->vTitle))
            {{ $meta_info->vTitle }}
        @else
            Admin Panel
            @endif | @if (isset($title))
                {{ $title }}
            @else
                {{ env('APP_NAME') }}
            @endif
    </title>

    @include('layouts.admin.css')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @if ($criteria['vController'] != 'LoginController')
                @include('layouts.admin.left')
            @endif
            <!-- / Menu -->

            <!-- Layout container -->
            @if ($criteria['vController'] != 'LoginController')
                <div class="layout-page">
                    @include('layouts.admin.header')
            @endif

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                @yield('content')
                <!-- / Content -->
                @include('layouts.admin.footer')
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-R0H0CJLSTC"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-R0H0CJLSTC');
    </script>
    @include('layouts.admin.js')
    @include('layouts.admin.toast')
    @yield('custom-js')
</body>

</html>
