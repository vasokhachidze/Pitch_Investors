<script>
    @php $user = session('username'); @endphp
    @if (session('toastwelcome'))
        toastr.success('Welcome, <?php echo "$user"; ?>', 'Login Successfully!', {"showMethod": "fadeIn", "hideMethod": "fadeOut", timeOut: 4000});
    @endif

    @if($message = session('success'))
        toastr.success('<?php echo "$message"; ?>', '', {"hideDuration": 3000});
    @endif

    @if($message = session('error'))
        toastr.error('<?php echo "$message"; ?>', '', {"hideDuration": 3000});
    @endif

    @if($message = session('message'))
        toastr.error('<?php echo "$message"; ?>', '', {"hideDuration": 3000});
    @endif

    @if($message = session('info'))
        toastr.info('<?php echo "$message"; ?>', '', {"hideDuration": 3000});
    @endif

    function successMsg(msg) {
        toastr.success(msg, '', {"hideDuration": 3000});
    }

    function errorMsg(msg) {
        toastr.error(msg, '', {"hideDuration": 3000});
    }
</script>