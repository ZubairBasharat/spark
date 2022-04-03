<link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/bootstrap/bootstrap.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}" />
<script type="text/javascript" src="{{asset('assets/libraries/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/libraries/bootstrap/bootstrap.bundle.js')}}"></script>
<section class="main-wrap-auth" style="background: url({{asset('/assets/images/login-layer.png')}});background-repeat: no-repeat;
      background-position: top right;">
    <nav class="px-custom auth-nav">
        <a href="{{url('/')}}" class="d-inline-block">
            <img src="{{asset('/assets/images/logo.png')}}" width="290px" alt="Logo" />
        </a>
    </nav>
    <div class="auth-content px-custom col-lg-8 col-xl-7">
        <h3>Welcome!</h3>
        <h6>This Platform is for YOU.</h6>
        <p>
            It has been designed to ensure you have access to your personalized
            results in a secure environment. The site also provides you with
            direct access to valuable resources.
        </p>
        <h2>Sign-in to your personal dashboard</h2>
        <form class="auth-form" method="POST" action="{{url('submit_login')}}">
            @csrf
            <div class="dataset-field">
                <label>User-ID</label>
                <input type="text" class="d-block" name="user_id"
                    placeholder="Please enter your alphanumeric User-ID" />
                    @if($errors->first('user_id'))
                    <div class="alert-danger">{{$errors->first('user_id')}}</div>
                     @endif
            </div>
            <div class="dataset-field mb-3">
                <label>Password</label>
                <input type="password" class="d-block" name="password"
                    placeholder="Please enter your alphanumeric User-ID" />
                    @if($errors->first('password'))
                    <div class="alert-danger">{{$errors->first('password')}}</div>
                     @endif
            </div>
            <a href="d-inline-block mb-3" class="text-decoration-none">
                Forgot your password?
            </a>
            @if(session('error_message'))
            <br>
            <div id="alert_message" class="alert alert-danger alert-dismissible d-inline-block mt-2">
              <strong>{{session('error_message')}}</strong>
            </div>
          @endif
            <div class="dataset-field">
                <button type="submit" class="w-100 border-0">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</section>
<div class="px-custom text-center developer-info bg-white">
   Powered By: <a href="theappguys.com" class="text-decoration-none">TheAppGuys.com</a>
</div>