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

                        @if($cartArray->count())
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
									<div class="service-book col-md-6">
										<div class="service-book-img">
                                            @if($item->image)
											<img src="{{ asset('storage/uploads/products/' . $item->image) }}" alt="img">
                                            @else
                                            <img src="{{ asset('assets/img/services/service-01.jpg') }}" alt="img">
                                            @endif
										</div>
										<div class="serv-profile">
											<h2>{{ $item->title }}</h2>
                                            <p class="text-dark">Quantity x {{ $cartItemsArr[$item->id] }}</p>
											<p class="text-dark"><strong>₹ {{ $item->price }} <small><strike>{{ $item->strike_price }}</strike></small></strong></p>
										</div>
									</div>
                                    @endforeach
								</div>

								<div class="col-lg-4">
									<div class="row align-items-center billing summary">
                                        <h4 class="my-4">Payment Summary</h4>
                                        <table class="table table-bordered billing-summary">
                                            <tr>
                                                <th><p class="text-dark">Item Total</p></th>
                                                <td><p style="float: right;" class="text-dark">₹ {{ $total }}</p></td>
                                            </tr>
                                            <tr>
                                                <th><p class="text-dark">Item Discount</p></th>
                                                <td><p style="float: right;" class="text-dark">₹ 0</p></td>
                                            </tr>
                                            <tr>
                                                <th><p class="text-dark">Taxes & Fee</p></th>
                                                <td><p style="float: right;" class="text-dark">₹ 0</p></td>
                                            </tr>
                                        </table>
                                        <p class="text-dark">Total<strong style="float: right;">₹ <span class="billing-total">{{ formatNumber($total) }}</span></strong></p>
                                        <hr>
                                        <div class="booking-coupon">
											<div class="form-group w-100">
												<div class="coupon-icon">
                                                    <form id="apply-discount-form">
                                                        <input type="hidden" name="total" value="<?= $total ?>">
                                                        <input type="text" name="promocode" class="form-control promocode-input" placeholder="Coupon Code" style="text-transform:uppercase">
                                                        <span><img src="assets/img/icons/coupon-icon.svg" alt=""></span>
                                                    </form>
												</div>
											</div>
											<div class="form-group">
												<button class="btn btn-primary apply-btn promocode-btn">Apply</button>
											</div>
										</div>
                                        <div class="save-offer">
											<p><i class="fa-solid fa-circle-check"></i> <strong>Voila! You saved ₹<span class="billing-discount">{{ $totalSaving - $total }}</span> on final bill</strong></p>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <hr>
						<div class="row">
							<div class="col-lg-12">
								<div class="text-center">
                                    @auth
                                    <button id="book-tc-service" class="btn btn-primary"><i class="fa-solid fa-business-time"></i> Book Service</button>
                                    @else
									<button id="login-from-cart" class="btn btn-primary"><i class="fa-solid fa-business-time"></i> Login/Sign up to proceed</button>
                                    @endauth
								</div>
							</div>
						</div>
                        @else
                        <div class="booking-service">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="container">

                                        <div class="row">
                                            <div class="col-lg-6 mx-auto">
                                                <div class="error-wrap text-center">
                                                    <div class="error-img">
                                                        <img class="img-fluid" src="https://cdni.iconscout.com/illustration/premium/thumb/confusing-woman-due-to-empty-cart-4558760-3780056.png" alt="img">
                                                    </div>
                                                    <h2>Whoops ! <br> Your Cart is empty</h2>
                                                    <p>Sorry, the page you're looking is empty because you haven't added an item in cart.</p>
                                                    <div class="text-center">
                                                        <a href="{{ route('homepage') }}" class="btn btn-primary"><i class="feather-arrow-left-circle me-2"></i>Back to
                                                        Home</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

					</div>

				</div>
			</div>
		</div>

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

	</div>

    @include('layouts.front_model')
	@include('layouts.scripts')

</body>
</html>
