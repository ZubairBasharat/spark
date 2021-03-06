<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta author="Mian Roshan" content="Full Stack developer" />
    <title>Spark&nbsp;|&nbsp;Login</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}" />
    <link rel="icon" href="{{asset('assets/images/favicon-large.png')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset('assets/images/favicon.png')}}" />
    <script type="text/javascript" src="{{asset('assets/libraries/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/libraries/bootstrap/bootstrap.bundle.js')}}"></script>
</head>

<body>
    <section class="main-wrap-auth" style="background: url({{asset('/assets/images/login-layer.png')}});background-repeat: no-repeat;
      background-position: top right;background-size: 700px;">
        <nav class="px-custom auth-nav">
            <a href="{{url('/')}}" class="d-inline-block">
                <img src="{{asset('/assets/images/logo.png')}}" width="290px" alt="Logo" />
            </a>
        </nav>
        <div class="auth-content px-custom col-lg-8 col-xl-7">
            <h3 class="mb-0">Reset Password</h3>
            <h2 class="mt-5">Forget Password Don't Worry</h2>
            <p>
                Please enter your email address to verify your account.
            </p>
            <form class="auth-form" method="POST" action="{{url('submit_login')}}">
                @csrf
                <div class="dataset-field">
                    <label>Email address</label>
                    <input type="text" class="d-block" name="user_id"
                        placeholder="Please enter your alphanumeric User-ID" />
                    @if($errors->first('user_id'))
                    <div class="alert-danger">{{$errors->first('user_id')}}</div>
                    @endif
                </div>
                {{--<div class="dataset-field mb-3">
                    <label>Password</label>
                    <input type="password" class="d-block" name="password"
                        placeholder="Please enter your alphanumeric User-ID" />
                    @if($errors->first('password'))
                    <div class="alert-danger">{{$errors->first('password')}}</div>
                    @endif
                </div>--}}
                @if(session('error_message'))
                <br>
                <div id="alert_message" class="alert alert-danger alert-dismissible d-inline-block mt-2">
                    <strong>{{session('error_message')}}</strong>
                </div>
                @endif
                <div class="dataset-field">
                    <button type="submit" class="w-100 border-0">
                        Send Reset Link
                    </button>
                </div>
            </form>
        </div>
    </section>
    <div class="px-custom text-center developer-info bg-white">
        Powered By: <a href="theappguys.com" class="text-decoration-none">TheAppGuys.com</a>
    </div>
</body>
</html>