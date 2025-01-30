<script>
$(document).ready(function() {
    @php $user = session('username'); @endphp
    @if (session('toastwelcome'))
        toastr.success('Welcome, <?php echo "$user"; ?>', 'Login Successfully!', {"showMethod": "fadeIn", "hideMethod": "fadeOut", timeOut: 2000});
    @endif

    @if($message = session('success'))
        toastr.success('<?php echo "$message"; ?>', '', {"hideDuration": 1000});
    @endif

    @if($message = session('warning'))
        toastr.warning('<?php echo "$message"; ?>', '', {"hideDuration": 1000});
    @endif

    @if($message = session('error'))
        toastr.error('<?php echo "$message"; ?>', '', {"hideDuration": 1000});
    @endif

    @if($message = session('message'))
        toastr.error('<?php echo "$message"; ?>', '', {"hideDuration": 1000});
    @endif

    @if($message = session('info'))
        toastr.info('<?php echo "$message"; ?>', '', {"hideDuration": 1000});
    @endif

    function successMsg(msg) {
        toastr.success(msg, '', {"hideDuration": 1000});
    }

    function errorMsg(msg) {
        toastr.error(msg, '', {"hideDuration": 1000});
    }
});
</script>
