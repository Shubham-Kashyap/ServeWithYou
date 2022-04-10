
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{ config('app.name', 'FarmerApp') }} - admin login</title>

	<!-- Global stylesheets -->
	<link href="{{ URL::to('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ URL::to('admin_files/global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

	<script src="{{ URL::to('admin_files/assets/js/app.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/demo_pages/login.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body class="bg-slate-800">

	<!-- Page content -->
	<div class="page-content login-cover">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">
				
				<!-- Login card -->
				<form class="login-form" action="{{ URL::to('admin/login') }}" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<!-- <div class="card mb-0"> -->
						<div class="card-body">
							@if(Session::has('error_message'))
							<div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal border-teal alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
								<span class="font-weight-semibold">Alert!</span> {{ Session::get('error_message') }} 
							</div>
							@endif
						</div>
					<!-- </div> -->
					<div class="card mb-0">
						<div class="card-body">
							
							<div class="text-center mb-3">
								<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Login to your account</h5>
								<span class="d-block text-muted">Your credentials</span>
							</div>
							<!-- custom alerts  -->
							@if(Session::has('error_message'))
							<!-- <div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal border-teal alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
								<span class="font-weight-semibold">Alert!</span> {{ Session::get('error_message') }} 
							</div> -->
							@endif
							<!-- /custom alerts  -->
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" class="form-control" name="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<!-- <div class="form-group d-flex align-items-center">
								<div class="form-check mb-0">
									<label class="form-check-label">
										<input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
										Remember
									</label>
								</div>

								<a href="login_password_recover.html" class="ml-auto">Forgot password?</a>
							</div> -->

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<!-- <div class="form-group text-center text-muted content-divider">
								<span class="px-2">or sign in with</span>
							</div>

							<div class="form-group text-center">
								<button type="button" class="btn btn-outline bg-indigo border-indigo text-indigo btn-icon rounded-round border-2"><i class="icon-facebook"></i></button>
								<button type="button" class="btn btn-outline bg-pink-300 border-pink-300 text-pink-300 btn-icon rounded-round border-2 ml-2"><i class="icon-dribbble3"></i></button>
								<button type="button" class="btn btn-outline bg-slate-600 border-slate-600 text-slate-600 btn-icon rounded-round border-2 ml-2"><i class="icon-github"></i></button>
								<button type="button" class="btn btn-outline bg-info border-info text-info btn-icon rounded-round border-2 ml-2"><i class="icon-twitter"></i></button>
							</div>

							<div class="form-group text-center text-muted content-divider">
								<span class="px-2">Don't have an account?</span>
							</div>

							<div class="form-group">
								<a href="#" class="btn btn-light btn-block">Sign up</a>
							</div>

							<span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span> -->
						</div>
					</div>
				</form>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
