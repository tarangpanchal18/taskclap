<!DOCTYPE html>
<html lang="en">
   <head>
      @include('layouts.linkcss')
   </head>
   <body class="mt-0">
      <div class="tc-loading-screen">
         <!-- <div id="tc-loader"></div> -->
      </div>
      <div class="main-wrapper" style="filter: blur(8px)">
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
                                       <div class="col-md-12 col-lg-12">
                                          <div class="breadcrumb-bar mb-5">
                                             <div class="container">
                                                <div class="row">
                                                   <div class="col-md-12 col-12">
                                                      <h2 class="breadcrumb-title">Booking Detail</h2>
                                                      <nav aria-label="breadcrumb" class="page-breadcrumb">
                                                         <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">Booking Detail</li>
                                                         </ol>
                                                      </nav>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="row">
                                            <p>Order Status @if($pageData->order_status == "Pending")<span class="float-right">: {{ generate_badge($pageData->order_status) }}</span>@endif</p>
                                            @if($pageData->order_status != "Pending")
                                            <ul id="progressbar">
                                                <li {{ ($pageData->order_status == "Completed") ? "Placed" : "" }}>
                                                    <div class="multi-step-info">
                                                        <h6>Order Placed</h6>
                                                    </div>
                                                    <div class="multi-step-icon">
                                                        <span><i class="fas fa-clipboard-check"></i></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="multi-step-info">
                                                        <h6>Provider Visit home</h6>
                                                    </div>
                                                    <div class="multi-step-icon">
                                                        <span><i class="fas fa-house-user"></i></span>
                                                    </div>
                                                </li>
                                                @if($pageData->order_status == "Failed" || $pageData->order_status == "Rejected")
                                                <li class="active">
                                                    <div class="multi-step-info">
                                                        <h6>Order {{ $pageData->order_status }}</h6>
                                                    </div>
                                                    <div class="multi-step-icon">
                                                        <span><i class="far fa-window-close"></i></span>
                                                    </div>
                                                </li>
                                                @else
                                                <li>
                                                    <div class="multi-step-info">
                                                        <h6>Work is in Progress</h6>
                                                    </div>
                                                    <div class="multi-step-icon">
                                                        <span><i class="fas fa-hammer"></i></span>
                                                    </div>
                                                </li>
                                                <li class="{{ ($pageData->order_status == "Completed") ? "active" : "" }}">
                                                    <div class="multi-step-info">
                                                        <h6>Completed</h6>
                                                    </div>
                                                    <div class="multi-step-icon">
                                                        <span><i class="far fa-thumbs-up"></i></span>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                            @endif
                                          </div>

                                          <!-- Order Detail -->
                                          <div class="row" style="transform: none;">
                                             <div class="col-lg-12">
                                                <div class="service-wrap">
                                                   <h5>Order Detail</h5>
                                                    <div class="row">
                                                        @foreach($pageData->orderDetail as $item)
                                                        <div class="booking-list">
                                                            <div class="booking-widget">
                                                                <div class="booking-img">
                                                                    <a><img src="{{ asset('storage/uploads/products/' .$item->product->image) }}" alt="User Image"></a>
                                                                </div>
                                                                <div class="booking-det-info">
                                                                    <h3>
                                                                        <a>{{ $item->product_title }}</a>
                                                                    </h3>
                                                                    <ul class="booking-details">
                                                                        <li>
                                                                            <span class="book-item">Type</span> : {{ $item->product->serviceCategory->name }}
                                                                        </li>
                                                                        <li>
                                                                            <span class="book-item">Amount</span> : <strike>{{ $item->product->strike_price }}</strike> <span class="badge-grey">{{ $item->product->price }}</span>
                                                                        </li>
                                                                        @if ($item->product->warranty > 0)
                                                                        <li>
                                                                            <span class="book-item">Warranty</span> : {{ $item->product->warranty }} Days
                                                                        </li>
                                                                        @endif
                                                                        @if ($item->product->approx_duration)
                                                                        <li>
                                                                            <span class="book-item">Duration*</span> : {{ $item->product->approx_duration }}
                                                                        </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <hr>

                                          <!-- Provider Detail
                                          <div class="row" style="transform: none;">
                                             <div class="col-lg-12">
                                                <div class="service-wrap provide-service">
                                                   <h5>Provider Details</h5>
                                                   <div class="row">
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <img src="assets/img/profiles/avatar-02.jpg" class="img-fluid" alt="img">
                                                            <div class="provide-info">
                                                               <h6>Member Since</h6>
                                                               <div class="serv-review"><i class="fa-solid fa-star"></i> <span>4.9 </span>(255 reviews)</div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-user"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Member Since</h6>
                                                               <p>Apr 2020</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-map-pin"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Address</h6>
                                                               <p>Hanover, Maryland</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-mail"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Email</h6>
                                                               <p>thomash@example.com</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-phone"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Phone</h6>
                                                               <p>+1 888 888 8888</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="social-icon provide-social">
                                                            <ul>
                                                               <li>
                                                                  <a href="#" target="_blank"><i class="feather-instagram"></i> </a>
                                                               </li>
                                                               <li>
                                                                  <a href="#" target="_blank"><i class="feather-twitter"></i> </a>
                                                               </li>
                                                               <li>
                                                                  <a href="#" target="_blank"><i class="feather-youtube"></i></a>
                                                               </li>
                                                               <li>
                                                                  <a href="#" target="_blank"><i class="feather-linkedin"></i></a>
                                                               </li>
                                                            </ul>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <hr> -->

                                          <!-- User Detail -->
                                          <div class="row" style="transform: none;">
                                             <div class="col-lg-12">
                                                <div class="service-wrap provide-service">
                                                   <h5>User Details</h5>
                                                   <div class="row">
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-user"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Name</h6>
                                                               <p>{{ $pageData->name }}</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-phone"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Phone</h6>
                                                               <p>{{ $pageData->phone }}</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                         <div class="provide-box">
                                                            <span><i class="feather-map-pin"></i></span>
                                                            <div class="provide-info">
                                                               <h6>Address</h6>
                                                               <p>{{ $pageData->house_no . ' ' . $pageData->landmark . ' ' . $pageData->address_local }}</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                          <hr>

                                          <div class="row" style="transform: none;">
                                             <div class="col-lg-12">
                                                <div class="card card-available">
                                                    <div class="card-body">
                                                        <div class="available-widget">
                                                            <div class="available-info">
                                                                <h5>Billing Detail
                                                                    @if($pageData->order_status == "Completed")
                                                                    <a href="{{ route('downloadInvoice', $pageData->order_id) }}" style="float: right;padding: 7px;" class="btn btn-sm btn-primary"><i class="fas fa-cloud-download-alt"></i> Invoice</a>
                                                                    @endif
                                                                </h5>
                                                               <div class="summary-box" style="background: #f4f5f7">
                                                                  <div class="booking-summary">
                                                                     <ul class="booking-date">
                                                                        <li>Booking Id <span>#{{ $pageData->order_id }}</span></li>
                                                                        <li>Date <span> {{ formatDate($pageData->created_at, 'd-m-Y (H:i)') }}</span></li>
                                                                        <li>Provider <span>{{ ($pageData->provider->name) ? $pageData->provider->name : 'Not Assigned Yet' }}</span></li>
                                                                     </ul>
                                                                     <ul class="booking-date">
                                                                        <li>Subtotal <span>₹ {{ $pageData->subtotal }}</span></li>
                                                                        @if($order->order_status == "Completed")
                                                                        <li>Material Charge <span>₹ {{ $pageData->material_charge_amount_total }}</span></li>
                                                                        <li>Additional Charge <span>₹ {{ $pageData->additional_charge_amount_total }}</span></li>
                                                                        @endif
                                                                        <li>Coupoun Discount <span>₹ {{ $pageData->discount }}</span></li>
                                                                        <li>Tax <span>₹ {{ $pageData->tax }}</span></li>
                                                                     </ul>
                                                                     <div class="booking-total">
                                                                        <ul class="booking-total-list">
                                                                           <li>
                                                                              Total
                                                                              <span class="total-cost">₹ {{ formatNumber($pageData->total) }}</span>
                                                                           </li>
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
      </div>
      @include('layouts.scripts')
      <script>
         $(document).ready(function() {
             setInterval(function () {
                 finishTcLoading();
             }, 1000);
         });
      </script>
   </body>
</html>
