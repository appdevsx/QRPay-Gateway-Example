<!-- notify js -->
<script src='{{ asset('public/qrpay/js/bootstrap-notify.min.js') }}'></script>

<script>
    // Show Laravel Error Messages----------------------------------------------
    $(function () {
        $(document).ready(function(){
            @if (session('error'))
                @if (is_array(session('error')))
                    @foreach (session('error') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "danger",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('success'))
                @if (is_array(session('success')))
                    @foreach (session('success') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-check-circle',
                            },
                            {
                                type: "success",
                                allow_dismiss: true,
                                delay: 5000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif (session('warning'))
                @if (is_array(session('warning')))
                    @foreach (session('warning') as $item)
                        $.notify(
                            {
                                title: "",
                                message: "{{ __($item) }}",
                                icon: 'las la-exclamation-triangle',
                            },
                            {
                                type: "warning",
                                allow_dismiss: true,
                                delay: 500000000,
                                placement: {
                                from: "top",
                                align: "right"
                                },
                            }
                        );
                    @endforeach
                @endif
            @elseif ($errors->any())
                @foreach ($errors->all() as $item)
                    $.notify(
                        {
                            title: "",
                            message: "{{ __($item) }}",
                            icon: 'las la-exclamation-triangle',
                        },
                        {
                            type: "danger",
                            allow_dismiss: true,
                            delay: 5000,
                            placement: {
                            from: "top",
                            align: "right"
                            },
                        }
                    );
                @endforeach
            @endif
        });
    });


</script>
