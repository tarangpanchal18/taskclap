<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.linkcss')
</head>

<body class="mt-0">

	<div class="main-wrapper">
		<div class="bg-img">
			<img src="/assets/img/bg/work-bg-03.png" alt="img" class="bgimg1">
			<img src="/assets/img/bg/work-bg-03.png" alt="img" class="bgimg2">
			<img src="/assets/img/bg/feature-bg-03.png" alt="img" class="bgimg3">
		</div>

		<div class="content">
			<div class="container">
				<div class="row">

					<!-- Booking -->
					<div class="col-md-12">

						<div class="login-back">
							<a href="{{ url()->previous() }}"><i class="text-dark feather-arrow-left"></i>&nbsp;&nbsp;<span class="ms-3 text-dark h4">Summary</span></a>
						</div>

						<!-- Booking Step -->
						<ul class="step-register row">
							<li class="active col-md-4">
								<div class="multi-step-icon">
									<img src="/assets/img/icons/calendar-icon.svg" alt="img">
								</div>
								<div class="multi-step-info">
									<h6>Appointment</h6>
									<p>Choose time & date for the service</p>
								</div>
							</li>
							<li class="col-md-4">
								<div class="multi-step-icon">
									<img src="/assets/img/icons/wallet-icon.svg" alt="img">
								</div>
								<div class="multi-step-info">
									<h6>Appointment time date</h6>
									<p>Select Payment Gateway</p>
								</div>
							</li>
							<li class="col-md-4">
								<div class="multi-step-icon">
									<img src="/assets/img/icons/book-done.svg" alt="img">
								</div>
								<div class="multi-step-info">
									<h6>Done </h6>
									<p>Completion of Booking</p>
								</div>
							</li>
						</ul>

						<!-- /Booking Step -->

						<!-- Appointment -->
						<div class="booking-service">
							<div class="row align-items-center">
								<div class="col-lg-8">

                                    <div class="service-book col-md-12">
                                        <div class="serv-profile">
                                            <span class="badge">{{ $cartArray[0]->category->name }}</span>
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                            <span class="badge">{{ $cartArray[0]->subCategory->name }}</span>
                                        </div>
                                    </div>

                                    @foreach($cartArray as $item)
									<div class="service-book col-md-12">
										<div class="service-book-img">
                                            @if($item->image)
											<img src="{{ asset('storage/uploads/products/' . $item->image) }}" alt="img">
                                            @else
                                            <img src="{{ asset('assets/img/services/service-01.jpg') }}" alt="img">
                                            @endif
										</div>
										<div class="serv-profile">
											<h2>{{ $item->title }}</h2>
											<p class="text-dark"><strong>$ 499</strong></p>
										</div>
									</div>
                                    @endforeach

								</div>
								<div class="col-lg-4">
									<div class="row align-items-center">
                                        <h4>Payment Summary</h4>
                                        <p class="text-dark">Item Total<strong style="float: right;">$ 1997</strong></p>
                                        <p class="text-dark">Item Discount<strong style="float: right;">$ 240</strong></p>
                                        <p class="text-dark">Taxes & Fee<strong style="float: right;">$89</strong></p>
                                        <hr>
                                        <p class="text-dark">Total<strong style="float: right;">$ 1564</strong></p>
                                        <div class="alert alert-success">
                                            <strong>You saved $100 on final bill</strong>
                                        </div>
										<!-- <div class="col-md-7 col-sm-6">
											<div class="provide-box">
												<span><i class="feather-phone"></i></span>
												<div class="provide-info">
													<h6>Phone</h6>
													<p>+1 888 888 8888</p>
												</div>
											</div>
											<div class="provide-box">
												<span><i class="feather-mail"></i></span>
												<div class="provide-info">
													<h6>Email</h6>
													<p>thomasherzberg@example.com</p>
												</div>
											</div>
										</div>
										<div class="col-md-5 col-sm-6">
											<div class="provide-box">
												<span><i class="feather-map-pin"></i></span>
												<div class="provide-info">
													<h6>Address</h6>
													<p>Hanover, Maryland</p>
												</div>
											</div>
											<div class="provide-box">
												<span><img src="/assets/img/icons/service-icon.svg" alt="img"></span>
												<div class="provide-info">
													<h6>Service Amount</h6>
													<h5>$150.00 </h5>
												</div>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>

                        <hr>

						<div class="row">
							<div class="col-lg-12">
								<div class="text-end">
									<a href="booking-payment.html" class="btn btn-primary">Book Appointment</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

	</div>

	@include('layouts.scripts')

</body>
</html>
