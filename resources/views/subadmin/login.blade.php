<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('admin_files/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin_files/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('admin_files/plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Admin</b>Login</a>
  </div>
  <!-- /.login-logo -->
  @if (Session::has('error_message'))
          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Warning !!</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {{ Session::get('error_message') }}
            </div>
            <!-- /.box-body -->
          </div>
  @endif
  @if (Session::has('success_message'))
          <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Success !!</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {{ Session::get('success_message') }}
            </div>
            <!-- /.box-body -->
          </div>
  @endif
  <div class="login-box-body">

    
    <p class="login-box-msg">
    <img src="{{ url('/').'/admin_files/dist/img/app_icon.png' }}" style="height:100px;width:100px;"  class="user-image" alt="User Image">
    </p>
    <!-- <div class="login-logo">
      <a href=""><b>Admin</b>Login</a>
    </div> -->

    <form action="{{ URL::to('/admin/login') }}" method="post" id="admin-login">
        
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" placeholder="password" value="{{ old('password') }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" form="admin-login">Log In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ url('admin_files/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('admin_files/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ url('admin_files/plugins/iCheck/icheck.min.js') }}"></script>
<!-- box alerts -->
<!-- AdminLTE App -->
<script src="{{ url('admin_files/dist/js/app.min.js') }}"></script>

</body>
</html>
