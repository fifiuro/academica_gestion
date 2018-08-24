<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gestión Académica - COGNOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn t work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page" style="background-image: url({{ asset('assets/img/17.jpg') }}); background-position: center center; background-repeat: no-repeat; background-attachment:fixed; background-size:cover;">

<div class="login-box">
    <div class="row justify-content-center">
        <div style="background-color: #d2d6de; padding:15px; text-align:center;">
            <img src="{{ asset('assets/img/cognos-color.png') }}">
        </div>
        <div class="login-box-body">
                <p class="login-box-msg">{{ __('Iniciar sesion para ingresar') }}</p>
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" id="form">
                    @csrf
                    <div class="form-group has-feedback">
                        <input id="login" type="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login" value="{{ old('login') }}" placeholder="Email o Usuario" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('login'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('login') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group has-feedback">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <!-- <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div> -->
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Ingresar') }}
                            </button>
                        </div>
                    </div>

                    <!-- <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Ingresar') }}
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div> -->
                </form>
        </div>
    </div>
</div>
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#form input[type=login]').on('change invalid', function() {
            var campotexto = $(this).get(0);

            campotexto.setCustomValidity('');

            if (!campotexto.validity.valid) {
            campotexto.setCustomValidity('Esta información es requerida');  
            }
        });
        $('#form input[type=password]').on('change invalid', function() {
            var campotexto = $(this).get(0);

            campotexto.setCustomValidity('');

            if (!campotexto.validity.valid) {
            campotexto.setCustomValidity('Esta información es requerida');  
            }
        });
    });
</script>