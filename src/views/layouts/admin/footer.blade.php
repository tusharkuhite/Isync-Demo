@php
    $setting_info = \App\Libraries\General::setting_info('Company');
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <strong>{{ isset($setting_info['COPYRIGHTED_TEXT']['vValue']) ? $setting_info['COPYRIGHTED_TEXT']['vValue'] : null }}</strong>
        </div>
    </div>
</footer>
<!-- / Footer -->
