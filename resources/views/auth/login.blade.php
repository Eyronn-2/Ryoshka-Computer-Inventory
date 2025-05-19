<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login | Ryoshka Computers Shop</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/favicon.png')}}">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        #wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('assets/img/BackgroundBLue.jpg') }}') no-repeat center center;
            background-size: cover;
            position: relative;
        }
        #wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(3px);
        }
        .auth-box {
            max-width: 1000px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
        }
    
        
        .left {
            padding: 40px;
            flex: 1;
        }
        .right {
            background-color: white;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .header {
            margin-bottom: 30px;
        }
        .header p.lead {
            font-size: 28px;
            color: #2a5298;
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        .header p.lead::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #2a5298;
            border-radius: 2px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 10px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 0 0.2rem rgba(42, 82, 152, 0.15);
            background: #fff;
        }
        .form-control::placeholder {
            color: #999;
        }
        .btn-primary {
            background: #2a5298;
            border: none;
            height: 50px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        .btn-primary:hover::before {
            left: 100%;
        }
        .btn-primary:hover {
            background: #1e3c72;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.3);
        }
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .alert-danger {
            background: #fff5f5;
            color: #e53e3e;
        }
        .alert i {
            margin-right: 10px;
        }
        .fancy-checkbox {
            margin-top: 10px;
        }
        .fancy-checkbox input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
        }
        .fancy-checkbox span {
            color: #666;
            font-size: 14px;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            transition: all 0.3s ease;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
        }
        .img-fluid:hover {
            transform: scale(1.02);
        }
        @media (max-width: 768px) {
            .auth-box {
                width: 90%;
                margin: 20px;
            }
            .right {
                display: none;
            }
            .left {
                padding: 30px;
            }
            .header p.lead {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="auth-box d-flex">
            <div class="left">
                <div class="content">
                    <div class="header">
                        <p class="lead"><b>Login to your account</b></p>
                    </div>
                    <form class="form-auth-small" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                id="signin-email" value="{{ old('email') }}" required placeholder="Email">
                            @if ($errors->has('email'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-exclamation-circle"></i> {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                name="password" id="signin-password" placeholder="Password">
                            @if ($errors->has('password'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-exclamation-circle"></i> {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>

                        <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span><b>Remember me</b></span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fa fa-sign-in"></i> LOGIN
                        </button>
                    </form>
                </div>
            </div>
            <div class="right">
                <img src="{{ asset('assets/img/Ryoshka Logo.svg') }}" alt="Ryoshka Logo" class="img-fluid" style="width: 550px; height: 350px;">
            </div>
        </div>
    </div>

    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/scripts/klorofil-common.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>

</html>