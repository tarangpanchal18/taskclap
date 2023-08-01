<style>
.animate-bottom {
    position: relative;
    animation: animatebottom 0.5s;
}

@keyframes animatebottom {
    from {
        bottom: -160px;
        opacity: 0;
    }

    to {
        bottom: 0;
        opacity: 1;
    }
}
</style>
<div id="tc-address-modal" class="modal fade" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate-bottom">
            <div class="modal-header border-bottom-0 justify-content-between">
                <h5 class="modal-title">Enter Your Details</h5>
                {{-- <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button> --}}
            </div>
            <div class="modal-body pt-0">
                <div class="write-review">
                    <form id="submit-tc-address">
                        <div class="form-group row mb-0">
                            <div class="pass-group col-md-6">
                                <label style="font-size:14px;" class="col-form-label">Your Name</label>
                                <input type="text" id="tc-name" name="name" class="form-control" placeholder="Your Name" value="{{ (auth()->user()->name == "Verified User") ? "" : auth()->user()->name }}">
                                <p id="tc-name-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-6">
                                <label style="font-size:14px;" class="col-form-label">Your Email</label>
                                <input type="text" id="tc-email" name="email" class="form-control" placeholder="Email Address (Optional)" value="{{ auth()->user()->email }}">
                                <p id="tc-email-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-4">
                                <label style="font-size:14px;" class="col-form-label">House/Flat Number</label>
                                <input type="text" id="tc-house_no" name="house_no" class="form-control" placeholder="House/Flat Number">
                                <p id="tc-house_no-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-8">
                                <label style="font-size:14px;" class="col-form-label">Landmark</label>
                                <input type="text" id="tc-landmark" name="landmark" class="form-control" placeholder="Start Typing Landmark">
                                <p id="tc-landmark-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-12">
                                <label style="font-size:14px;" class="col-form-label">Address</label>
                                <input type="text" id="tc-address" name="address" class="form-control" placeholder="Start typing Address">
                                <p id="tc-address-error" class="text-danger"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="tc-select-address" style="display: none">
                    <p class="text-center text-dark"><strong>Or Select From Existing One</strong></p>
                    <div class="d-flex">
                        <div class="contact-info flex-fill" role="button">
                            <span style="width: 40px;height:40px;"><i class="feather-map-pin"></i></span>
                            <div class="contact-data">
                                <h6>Your Added Address</h6>
                                <p id="tc-existing-address-text"></p>
                                <input type="hidden" id="tc-existing-address" value="">
                                <input type="hidden" id="tc-existing-house_no" value="">
                                <input type="hidden" id="tc-existing-landmark" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-submit text-end">
                    <a class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
                    <button id="submit-address" type="submit" class="btn btn-tc">Confirm & Procced to Pay</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tc-payment-modal" class="modal fade" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate-bottom">
            <div class="modal-header border-bottom-0 justify-content-between">
                <h5 class="modal-title">How you would like to pay ?</h5>
                {{-- <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button> --}}
            </div>
            <hr>
            <div class="modal-body pt-0">
                <div class="write-review">
                    <form id="submit-tc-payment" method="POST" action="{{ route('placeOrder') }}">
                        @csrf
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                        <input type="hidden" name="category" value="{{ $cartArray[0]->category->id }}">
                        <input type="hidden" name="subCategory" value="{{ $cartArray[0]->subCategory->id }}">
                        <input type="hidden" name="cartArray" value="{{ base64_encode(json_encode($cartArray)) }}">
                        <div class="form-group row mb-0">
                            <div class="alert alert-danger payment-error" style="display: none;">
                                <strong>Please Choose any of one method</strong>
                            </div>
                            <div class="linked-item">
                                <div class="linked-wrap">
                                    <div class="linked-acc">
                                        <span class="link-icon">
                                            <img style="width: 100%;" src="https://cdn.pixabay.com/photo/2021/01/25/12/21/money-5948190_1280.png" alt="cash">
                                        </span>
                                        <div class="linked-info">
                                            <h6>Cash/UPI Payment</h6>
                                            <p>Cash/UPI Payment after service is completed</p>
                                        </div>
                                    </div>
                                    <div class="linked-action">
                                        <a id="tc-cash-payment" class="paymentBtn btn btn-sm btn-secondary btn-set">Select</a>
                                    </div>
                                </div>
                                <!-- <div class="linked-wrap">
                                    <div class="linked-acc">
                                        <span class="link-icon">
                                            <img style="width: 100%;" src="https://cdn.iconscout.com/icon/free/png-256/free-upi-2085056-1747946.png" alt="UPI">
                                        </span>
                                        <div class="linked-info">
                                            <h6>UPI Payment</h6>
                                            <p>Pay right now using any UPI Application.</span></p>
                                        </div>
                                    </div>
                                    <div class="linked-action">
                                        <a id="tc-upi-payment" class="paymentBtn btn btn-sm btn-secondary btn-set">Select</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="modal-submit text-end">
                    <a class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
                    <button id="submit-payment" type="submit" class="btn btn-tc">Confirmed & Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tc-service-modal" class="modal fade" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate-bottom" style="max-height:768px;overflow-y: auto;">
            <button type="button" class="close-btn btn btn-sm btn-default" data-bs-dismiss="modal" aria-label="Close">Close</button>
            <div class="modal-header border-bottom-0 justify-content-between" style="padding: 0;">
                <img src="https://res.cloudinary.com/urbanclap/image/upload/t_high_res_template,q_auto:low,f_auto/w_520,dpr_2,fl_progressive:steep,q_auto:low,f_auto,c_limit/images/supply/customer-app-supply/1679671398045-1a079e.jpeg" alt="TaskClap Image" style="width: 100%;">
            </div>
            <div class="modal-body pt-0">
                <div class="write-review">
                    <div class="mt-4">
                        <h4 class="tc-service-title"></h4>
                        <span><i class="fa fa-star"></i> 4.77 (255)</span>
                    </div>

                    <div class="tc-service-body"></div>
                    {{-- <hr>
                    <div class="product-inner-section row">
                        <div class="col-9">
                            <small class="dash-value">30 Days Warranty</small>
                            <p class="mb-0 text-dark"><b>AC Repair (Split/Window)</b></p>
                            <small class="text-body"><i class="fa fa-solid fa-star rating-star"></i> 4.83 (1.54M reviews)</small>
                            <p class="text-dark"><small><strong>2 Service</strong></small></p>
                        </div>
                        <div class="col-3">
                            <img class="img-thumbnail p-0" src="https://dummyimage.com/200x200/000/fff" alt="AC Repair (Split/Window)">
                            <div>
                                <div class="quantity-cart input-group w-auto justify-content-center align-items-center">
                                    <input type="button" value="-" class="cart-btn button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                                    <input
                                        data-subCategoryId="{{ $product->sub_category_id }}"
                                        data-productId="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        data-strikeprice="{{ $product->strike_price }}"
                                        type="text"
                                        step="1"
                                        max="10"
                                        value="{{ $cartArray[$product->id] ? $cartArray[$product->id] : 0 }}"
                                        name="quantity"
                                        class="cart-btn quantity-field text-center"
                                        readonly
                                    >
                                    <input type="button" value="+" class="cart-btn button-plus border rounded-circle icon-shape icon-sm mx-1"
                                        data-field="quantity">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="product-description">
                                AC Repair (Split/Window)AC Repair (Split/Window)AC Repair (Split/Window)AC Repair (Split/Window)
                            </div>
                            <p style="cursor: pointer;font-size: 14px;color: #4c40ed">View More</p>
                        </div>
                    </div> --}}

                    <hr style="border: 1px solid #2f4f4f2e;margin:1.5em 0;">

                    <div class="description tc-service-description"></div>

                </div>
            </div>
        </div>
    </div>
</div>
