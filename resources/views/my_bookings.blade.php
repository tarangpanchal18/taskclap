<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.linkcss')
</head>

<body class="mt-0">
    <div class="tc-loading-screen">
        <!-- <div id="tc-loader"></div> -->
    </div>
    <div class="main-wrapper" style="filter: blur(8px);">
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
                                                <!-- Service Details -->
                                                <div class="col-md-12 col-lg-12">

                                                    <div class="row align-items-center">
                                                        <div class="col-md-4">
                                                            <div class="widget-title">
                                                                <h4>Booking List</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @forelse ($pageData as $booking)
                                                    @foreach ($booking->orderDetail as $order)
                                                    <div class="booking-list">
                                                        <div class="booking-widget">
                                                            <div class="booking-img">
                                                                <a>
                                                                    <img src="{{ asset('/uploads/category/'. $order->subCategory->image .'') }}" alt="{{ $order->subCategory->name }}">
                                                                </a>
                                                                <div class="fav-item">
                                                                    <a href="javascript:void(0)" class="fav-icon">
                                                                        <i class="feather-heart"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="booking-det-info">
                                                                <h3>
                                                                    <a>{{ $order->subCategory->name }} {{ $order->product_title }}</a>
                                                                    {{ generate_badge($booking->order_status) }}
                                                                </h3>
                                                                <ul class="booking-details">
                                                                    <li>
                                                                        <span class="book-item">Booking Date</span> : {{ formatDt($booking->created_at, 'd M Y h:ia') }}
                                                                    </li>
                                                                    <li><span class="book-item">Phone</span> : {{ $booking->phone }}</li>
                                                                    <li>
                                                                        <span class="book-item">Amount</span> : ₹ {{ formatNumber($booking->total) }}
                                                                        <span class="badge-grey">{{ $booking->payment_type }}</span>
                                                                    </li>
                                                                    <li><span class="book-item">Location</span> : {{ $booking->address }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="booking-action">
                                                            <a href="booking.html" class="btn btn-primary">Rebook</a>
                                                            <a href="javascript:void(0);" class="btn btn-secondary" data-bs-toggle="modal"
                                                                data-bs-target="#add-review"><i class="feather-plus-circle"></i> Add Review</a>
                                                            <div class="view-action">
                                                                <div class="rating">
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                </div>
                                                                <a href="service-details.html" class="view-btn">View Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @empty
                                                    <div class="text-center">
                                                        <h2>No bookings found !</h2>
                                                    </div>
                                                    @endforelse

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="review-pagination">
                                                                {{ $pageData->links() }}
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
        <script>
            $(document).ready(function() {
        loadCartItems({{ $product->sub_category_id }});
        @foreach($service_type as $serviceType)
            $("#{{ createSlug($serviceType)}}").click(function() {
                $('html,body').animate({
                    scrollTop: $("#service_{{ createSlug($serviceType)}}").offset().top
                },'slow');
            });
        @endforeach

        setInterval(function () {
            finishTcLoading();
        }, 1000);
    });
        </script>
</body>

</html>
