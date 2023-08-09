<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __("QRPay - Money Transfer with QR Code") }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('public/qrpay/fav.png') }}" type="image/x-icon">
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        .alert {
        font-size: 15px;
        letter-spacing: 0.3px;
        padding: 20px 24px;
        }
        [data-notify=icon] {
        color: #fff;
        margin-right: 5px;
        }
        .alert.alert-success {
        background: #39DA8A !important;
        color: #FFF !important;
        -webkit-box-shadow: 0 3px 8px 0 rgba(57, 218, 138, 0.4);
            box-shadow: 0 3px 8px 0 rgba(57, 218, 138, 0.4);
        border: none;
        }
        .alert.alert-danger {
        background: #EA5455!important;
        color: #FFF!important;
        box-shadow: 0 3px 8px 0 rgba(234, 84, 85,0.4);
        border: none;
        }
        .alert.alert-warning {
        background: #FF9F43!important;
        color: #FFF!important;
        box-shadow: 0 3px 8px 0 rgba(255, 159, 67,0.4);
        border: none;
        }

        .alert--custom{
        color: #664d03;
        background-color: #fff3cd;
        border-color: #ffecb5;
        position: relative;
        padding: 1rem 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        }
        .alert strong {
        display: block;
        }
        .alert span {
        line-height: 1em;
        }
        .alert .close {
        position: absolute;
        background-color: transparent;
        color: #FFF;
        opacity: 1;
        top: -4px;
        text-shadow: none;
        border: none;
        font-weight: 400;
        font-size: 24px;
        }
    </style>
</head>
<body class="bg-light">
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start pay page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="pay-page">
    <div class="container">
        <div class="form-wrapper h- d-flex flex-column justify-content-center vh-100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form class="p-5 border border-1 rounded-3 bg-white shadow-lg" method="POST" action="{{ route('pay.initiate.payment') }}">
                        @csrf
                        <div class="img-wrapper overflow-hidden text-center mb-3">
                            <img style="max-width: 180px; height: auto; object-fit: cover;" src="{{ asset('public/qrpay/logo.png') }}" alt="img">
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="form-label">{{ __("Pay Amount") }} <span class="text-danger">*</span></label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter Amount...">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __("Pay") }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End pay page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!-- bootstrap js -->
<!-- jquery -->
<script src="{{ asset('public/qrpay/') }}/js/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
@include('partials.notify')

</body>
</html>
