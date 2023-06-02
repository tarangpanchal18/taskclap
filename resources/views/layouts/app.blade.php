<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/img/favicon-01.png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<!-- Fearther CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">
	<!-- select CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
	<!-- Owl carousel CSS -->
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
	<!-- Aos CSS -->
	<link rel="stylesheet" href="assets/plugins/aos/aos.css">
	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="home-page-three">
	<div class="main-wrapper">

		<!-- Header -->
		@include('layouts.header')
		<!-- /Header -->

        @yield('content')

        <!-- Footer -->
        @include('layouts.footer')
        <!-- /Footer -->

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

		<!-- Delete Account -->
		<div class="modal fade custom-modal" id="del-account">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header border-bottom-0 justify-content-between">
						<h5 class="modal-title">Delete Account</h5>
						<button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button>
					</div>
					<div class="modal-body pt-0">
						<div class="write-review">
							<form action="login.html">
								<p>Are you sureyou want to delete This Account? To delete your account, Type your password.</p>
								<div class="form-group">
									<label class="col-form-label">Password</label>
									<div class="pass-group">
										<input type="password" class="form-control pass-input" placeholder="*************">
										<span class="toggle-password feather-eye"></span>
									</div>
								</div>
								<div class="modal-submit text-end">
									<a href="#" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
									<button type="submit" class="btn btn-danger">Delete Account</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete Account -->

	</div>


	<!-- scrollToTop start -->
	<div class="progress-wrap active-progress progress-wrap-three">
		<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
		<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919px, 307.919px; stroke-dashoffset: 228.265px;"></path>
		</svg>
	</div>
	<!-- scrollToTop end -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.6.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- Fearther JS -->
	<script src="assets/js/feather.min.js"></script>

	<!-- Owl Carousel JS -->
	<script src="assets/js/owl.carousel.min.js"></script>

	<!-- select JS -->
	<script src="assets/plugins/select2/js/select2.min.js"></script>

	<!-- Datepicker Core JS -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Aos -->
	<script src="assets/plugins/aos/aos.js"></script>

	<!-- Slick JS -->
	<script src="assets/js/slick.js"></script>

	<!-- Top JS -->
	<script src="assets/js/backToTop.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

</body>
</html>
