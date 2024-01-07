<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon">
    <title>Form Login :: Administrator</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }

        .container-contact100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: #3AD1D2;
            background: linear-gradient(45deg, #00dbde, #277fdd, #26a65b, #D79F43);
            background-size: 500% 500%;
            -webkit-animation: container-contact100 12s ease infinite;
            -moz-animation: container-contact100 12s ease infinite;
            animation: container-contact100 20s ease infinite;
        }

        .wrap-contact100 {
            width: 500px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            padding: 42px 55px 45px 55px;
        }
    </style>
</head>

<body class="light">
    <!-- Pre loader -->
    <div id="loader" class="loader">
        <div class="plane-container">
            <div class="preloader-wrapper small active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="primary" class="container-contact100">
        <div class="wrap-contact100">

            <div class="text-center">
                <img src="assets/img/dummy/u4.png" alt="">
                <h3 class="mt-2">Welcome Back</h3>
                <p class="p-t-b-20">Hey Admin Network Service Enginering </p>
            </div>


            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                    <input type="text"
                        class="form-control form-control-lg @if ($errors->has('username')) is-invalid @endif"
                        placeholder="Username" name="username" autocomplete="off" value="{{ old('username') }}" required
                        autofocus>
                    @if ($errors->has('username'))
                        <div class="invalid-feedback text-white" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group has-icon"><i class="icon-user-secret"></i>
                    <input type="password"
                        class="form-control form-control-lg @if ($errors->has('password')) is-invalid @endif "
                        placeholder="Password" name="password" autocomplete="off" value="{{ old('password') }}"
                        required>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback text-white" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>
                <input type="submit" class="btn btn-success btn-lg btn-block" value="Log In">
            </form>
        </div>
    </div>
    <script type="text/javascript">
        var APP_URL = "{!! json_encode(url('/') . '/') !!}";
    </script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
