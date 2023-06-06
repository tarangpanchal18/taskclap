<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.linkcss')
</head>

<body class="mt-0">
	<div class="main-wrapper">

		<div class="page-wrapper">
			<div class="content">
				<div class="container">
					<div class="row">
                        <div class="col-md-12 col-lg-10 mx-auto">
						<div class="col-md-12 col-lg-10 mx-auto">

							<div class="login-back">
								<a href="{{ url()->previous() }}"><i class="feather-arrow-left"></i> Back</a>
							</div>

							<div class="row">
								<div class="col-lg-12 mx-auto">
                                <div class="container">
                                    <div class="row">

                                        <!-- Service Profile -->
                                        <div class="col-md-8">
                                            <div class="serv-profile">
                                                <h2>{{ $category->name }}</h2>
                                                <ul>
                                                    <li class="service-map"><i class="fa fa-star"></i> 3.5 Rating (100 Bookings Made)</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Like Share Section -->
                                        </div>
                                        <div class="col-md-12">
                                            <div class="service-gal">
                                                <div class="row gx-2">
                                                    <div class="col-md-9">
                                                        <div class="service-images big-gallery">
                                                            <img src="assets/img/services/service-ban-01.jpg" class="img-fluid" alt="img">
                                                            <a href="assets/img/services/service-ban-01.jpg" data-fancybox="gallery" class="btn btn-show"><i class="feather-image me-2"></i>Show all photos</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="service-images small-gallery">
                                                            <a  href="assets/img/services/service-ban-02.jpg" data-fancybox="gallery">
                                                                <img src="assets/img/services/service-ban-02.jpg" class="img-fluid" alt="img">
                                                                <span class="circle-icon"><i class="feather-plus"></i></span>
                                                            </a>
                                                        </div>
                                                        <div class="service-images small-gallery">
                                                            <a  href="assets/img/services/service-ban-03.jpg" data-fancybox="gallery">
                                                                <img src="assets/img/services/service-ban-03.jpg" class="img-fluid" alt="img">
                                                                <span class="circle-icon"><i class="feather-plus"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Service Profile -->
                                    </div>

                                    <div class="row">

                                        <!-- Service Details -->
                                        <div class="col-lg-7">
                                            <div class="service-wrap">
                                                <div>{!! $category->description  !!}</div>
                                            </div>
                                            <hr>
                                            <div class="service-wrap provide-service" style="margin-bottom: 0;">
                                                <div class="row">
                                                    @forelse($service_type as $serviceType)
                                                    <div class="col-md-4" style="cursor: pointer;">
                                                        <img class="img-fluid mb-2 img-thumbnail" alt="{{ $serviceType }}" src="https://www.vijayhomeservices.com/assets/img/ac-repair-large.jpg">
                                                        <div style="text-align: center;" class="provide-info">
                                                            <h6>{{ $serviceType }}</h6>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="product-section">
                                                <h2 class="my-5">Service</h2>
                                                @for($i=0; $i<= 2; $i++)
                                                <div class="product-inner-section row pb-5">
                                                    <div class="col-9">
                                                        <small class="dash-value">30 Days Warranty</small>
                                                        <p style="margin-bottom:0px;color:black;"><b>Deep Clean Ac Service</b></p>
                                                        <small class="text-body"><i class="fa fa-star"></i> 4.83 (1.54M reviews)</small>
                                                        <p style="color:black;"><small><strong>₹ 599</strong>&nbsp;&nbsp;&nbsp;<strike>₹ 699</strike></small></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <img style="border-radius: 5px;" src="https://dummyimage.com/110x110/000/fff" alt="">
                                                    </div>
                                                    <div class="col-12">
                                                        <ul>
                                                            <li>asdasdakjsfd askdfkjsd fkjsdghf jashdkflhaskdhdhsf dfkjsd fkjsdghf jashdkflhaskdhdhsf</li>
                                                            <li>asdasdakjsfd askdfkjsd fkjsdghf jashdkflhaskdhdhsf dfkjsd fkjsdghf jashdkflhaskdhdhsf</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>
                                                @endfor
                                            </div>
                                            <div class="product-section">
                                                <h2 class="my-5">Installation / Uninstallation</h2>
                                                @for($i=0; $i< 1; $i++)
                                                <div class="product-inner-section row pb-5">
                                                    <div class="col-9">
                                                        <small class="dash-value">30 Days Warranty</small>
                                                        <p style="margin-bottom:0px;color:black;"><b>Deep Clean Ac Service</b></p>
                                                        <small class="text-body"><i class="fa fa-star"></i> 4.83 (1.54M reviews)</small>
                                                        <p style="color:black;"><small><strong>₹ 599</strong>&nbsp;&nbsp;&nbsp;<strike>₹ 699</strike></small></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <img style="border-radius: 5px;" src="https://dummyimage.com/110x110/000/fff" alt="">
                                                    </div>
                                                    <div class="col-12">
                                                        <ul>
                                                            <li>asdasdakjsfd askdfkjsd fkjsdghf jashdkflhaskdhdhsf dfkjsd fkjsdghf jashdkflhaskdhdhsf</li>
                                                            <li>asdasdakjsfd askdfkjsd fkjsdghf jashdkflhaskdhdhsf dfkjsd fkjsdghf jashdkflhaskdhdhsf</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr>
                                                @endfor
                                            </div>
                                            <!-- <div class="service-wrap">
                                                <h5>Reviews</h5>
                                                <ul>
                                                    <li class="review-box">
                                                        <div class="review-profile">
                                                            <div class="review-img">
                                                                <img src="assets/img/profiles/avatar-05.jpg" class="img-fluid" alt="img">
                                                                <div class="review-name">
                                                                    <h6>Bradley</h6>
                                                                    <p>1 month ago  |  17:35PM </p>
                                                                </div>
                                                            </div>
                                                            <div class="rating">
                                                                <i class="fas fa-star filled"></i>
                                                                <i class="fas fa-star filled"></i>
                                                                <i class="fas fa-star filled"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </div>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipicing elit</p>
                                                    </li>
                                                </ul>
                                            </div> -->
                                        </div>
                                        <div class="col-lg-5 theiaStickySidebar">
                                            <div class="card card-provide mb-0">
                                                <div class="card-body">
                                                    <div class="package-widget">
                                                        <h5>Available Service Packages</h5>
                                                        <ul>
                                                            <li>Full car wash and clean</li>
                                                            <li>Auto Electrical</li>
                                                            <li>Pre Purchase Inspection</li>
                                                            <li>Pre Purchase Inspection</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
