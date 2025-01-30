@php
use App\Libraries\General;

$settings = General::setting_info('Config');
$setting_info = General::setting_info('Company');
$social_info = General::setting_info('Social');
@endphp

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{$setting_info['COMPANY_NAME']['vValue']}}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <style>
            @font-face {
    font-family: "ITCAvantGardeGothicProMedium";
    src: url('./assets/fonts/ITCAvantGardeGothicProMedium/font.woff2') format('woff2'), url('./assets/fonts/webFonts/ITCAvantGardeGothicProMedium/font.woff') format('woff');
}
@font-face {
    font-family: "ITCAvantGardeGothicProBold";
    src: url('./assets/fonts/ITCAvantGardeGothicProBold/font.woff2') format('woff2'), url('./assets/fonts/ITCAvantGardeGothicProBold/font.woff') format('woff');
}
            table, td, div, h1, h5, h2, h3, h4 {
                font-family: "ITCAvantGardeGothicProMedium";
            }
        </style>
    </head>

    <body style="font-family: 'ITCAvantGardeGothicProMedium'; margin: 40px 0;">
        <table class="table-mobile" style="max-width: 500px; margin: auto; padding: 0; border: 1px solid #7070701f; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="padding: 0;">
                        <table style="width: 100%; background-color: #fff; padding: 20px 15px 15px; border-bottom: 1px solid #7070701f;">
                            <tr>
                                <td style="text-align: center; border-spacing: 0; padding: 0;">
                                    <img src="{{asset('uploads/logo/'.$setting_info['COMPANY_LOGO']['vValue'])}}" width="200" alt="logo" style="object-fit: contain;" />
                                </td>
                            </tr>
                        </table>
                        {{-- <table class="table-mobile" style="width: 100%; height: 150px; padding: 6% 6%; background-position: center; background-repeat: no-repeat; background-size: cover; text-align: center; padding-bottom: 0;">
                            <tr>
                                <td>
                                    <img src="{{ asset('uploads/logo/'.$setting_info['COMPANY_BANNER_LOGO']['vValue']) }}" alt="banner-img" style="width: 70%; object-fit: contain;" />
                                </td>
                            </tr>
                        </table> --}}

                        <table class="table-mobile" style="width: 100%; padding: 6% 3%; background-color: #fff; border-spacing: 0;">
                            <tr>
                                <td colspan="3">
                                    {!! $msg !!}
                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%; margin: 0 auto; padding: 5% 5%; border-spacing: 0; background-color: #062b49; color: #fff; text-align: center;">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 0px;">
                                        <img src="{{ asset('uploads/logo/'.$setting_info['COMPANY_FOOTER_LOGO']['vValue'] )}}" alt="logo" style="width: 200px; height: auto; object-fit: contain;" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; margin: 0 auto; padding: 2% 3%; border-spacing: 0; background-color: #073255; color: #fff; text-align: center;">
                            <tbody>
                                <tr>
                                    <td>
                                        <p style="padding-top: 0px; font-size: 13px; color: #ffffff; margin: 0; text-align: start;">
                                            © 2024 Johari360 All rights Reserved.
                                            <!-- {{$setting_info['COPYRIGHTED_TEXT']['vValue']}}. -->
                                        </p>
                                    </td>
                                    <td>
                                        <ul style="display: flex; list-style: none; padding-left: 0; margin: 0; justify-content: end;">
                                            {{-- <li style="height: 30px; width: 30px;">
                                                <a
                                                    href="{{$social_info['SOCIAL_FACEBOOK']['vValue']}}" 
                                                    target="_blank"
                                                    style="width: 32px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border: 1px solid #fff; border-radius: 50%; transition: all 0.5s;"
                                                >
                                                    <img src="{{ asset('admin/assets/img/fb.png') }}" alt="" height="30" width="30" style="color: #fff;">
                                                </a>
                                            </li> --}}

                                            <li style="height: 30px; width: 30px; margin-left: 5px;">
                                                <a
                                                    href="{{$social_info['SOCIAL_TWITTER']['vValue']}}" 
                                                    target="_blank"
                                                    style="width: 32px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border: 1px solid #fff; border-radius: 50%; transition: all 0.5s;"
                                                >
                                                    <img src="{{ asset('admin/assets/img/twitter.png') }}" alt="" height="30" width="30">
                                                </a>
                                            </li>
                                            {{-- <li style="height: 30px; width: 30px; margin-left: 5px;">
                                                <a
                                                    href="{{$social_info['SOCIAL_INSTAGRAM']['vValue']}}" 
                                                    target="_blank"
                                                    style="width: 32px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border: 1px solid #fff; border-radius: 50%; transition: all 0.5s;"
                                                >
                                                    <img src="{{ asset('admin/assets/img/insta.png') }}" alt="" height="30" width="30">
                                                </a>
                                            </li> --}}
                                            <li style="height: 30px; width: 30px; margin-left: 5px;">
                                                <a
                                                    href="{{$social_info['SOCIAL_LINKEDIN']['vValue']}}" 
                                                    target="_blank"
                                                    style="width: 32px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; border: 1px solid #fff; border-radius: 50%; transition: all 0.5s;"
                                                >
                                                    <img src="{{ asset('admin/assets/img/linkdin.png') }}" alt="" height="30" width="30">
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>