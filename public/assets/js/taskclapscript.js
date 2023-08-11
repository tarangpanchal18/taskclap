const cartItems = getCookie('cartDetail') ? JSON.parse(getCookie('cartDetail')) : [];
const cartTotals = getCookie('cartTotal') ? JSON.parse(getCookie('cartTotal')) : [];

function renderLoginScreen() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}

function sendSmsForVerify() {
    var number = $("#phone").val();
    number = "+91" + number;
    $("#signin-btn").attr("disabled", true).html("Logging you in");

    $.ajax({
        type : "POST",
        dataType: "json",
        url : "/validate-number",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : $("#login-form").serialize(),
        success : function(response) {
            if (response.success) {
                firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    coderesult = confirmationResult;
                    $(".login-screen").hide();
                    $(".login-screen-otp").show();
                    $("#dialogue-box").html("<div class='alert alert-success'>We've sent you a 6 digit OTP on " + $("#phone").val() +  "</div>");
                    $("#dialogue-box").show();
                    $("#digit-1").focus();

                    //Starting Timer
                    setLoginOtpTimeExpiry();
                }).catch(function (error) {
                    $("#dialogue-box").html("<div class='alert alert-danger'>Please enter valid mobile number !</div>");
                    $("#dialogue-box").show();
                });
            } else {
                $("#signin-btn").attr("disabled", false).html("Login");
                $(".login-screen-otp").hide();
                $("#dialogue-box").html("<div class='alert alert-danger'>" + response.msg + "</div>");
                $("#dialogue-box").show();
            }
        }
    });
}

function resendSmsForVerify() {
    $("#dialogue-box").html("<div class='alert alert-info'>Please Wait !</div>");

    $(".login-time-expiry").hide();
    $(".no-otp-recieved").html("");
    var number = $("#phone").val();
    number = "+91" + number;

    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        $(".login-screen").hide();
        $(".login-screen-otp").show();
        $("#dialogue-box").html("<div class='alert alert-success'>We've sent you a 6 digit OTP on " + $("#phone").val() +  "</div>");
        $("#dialogue-box").show();
        $("#digit-1").focus();

        //Starting Timer
        setLoginOtpTimeExpiry();
    }).catch(function (error) {
        $("#dialogue-box").html("<div class='alert alert-danger'>Whoops ! Something Went wrong.<br>Please try after sometime.</div>");
        $("#dialogue-box").show();
    });
}

function VerfySmsForAuth() {
    var code1 = $("#digit-1").val().trim();
    var code2 = $("#digit-2").val().trim();
    var code3 = $("#digit-3").val().trim();
    var code4 = $("#digit-4").val().trim();
    var code5 = $("#digit-5").val().trim();
    var code6 = $("#digit-6").val().trim();
    var code = code1 + code2 + code3 + code4 + code5 + code6;

    coderesult.confirm(code).then(function (result) {
        if (result.user) {
            $.ajax({
                type : "POST",
                dataType: "json",
                url : "/login",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data : {'phone' : $("#phone").val()},
                success : function(response) {
                    if (response && response.success) {
                        window.location.href = response.loginLink;
                    } else {
                        $(".login-screen-otp").hide();
                        $("#dialogue-box").html("<div class='alert alert-danger'>We're really Sorry !<br>But an unexpected error occurred. Please try after sometime.</div>");
                        $("#dialogue-box").show();
                    }
                }
            });
        }
    }).catch(function (error) {
        if (error.code == "auth/invalid-verification-code") {
            $("#dialogue-box").html("<div class='alert alert-danger'>Entered OTP is Invalid. Please try again by entering valid OTP.</div>");
        } else {
            $("#dialogue-box").html("<div class='alert alert-danger'>Please Enter Valid OTP.</div>");
        }

        $("#dialogue-box").show();
    });
}

function setLoginOtpTimeExpiry() {
    var timer2 = "01:00";
    var otpResent = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 5 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('span.expiry-time-block').html(minutes + ':' + seconds);
        if (minutes == "0" && seconds == "00") {
            $(".login-time-expiry").hide();
            $(".no-otp-recieved").html('<a class="btn btn-sm btn-default" onclick="resendSmsForVerify()">Resend OTP</a>');
            clearInterval(otpResent);
        }
        timer2 = minutes + ':' + seconds;
    }, 1000);

    $(".login-time-expiry").show();
}

function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function eraseCookie(key) {
    var keyValue = getCookie(key);
    setCookie(key, keyValue, '-1');
}

function incrementCartBtnValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var parentElement = parent.find('input[name=' + fieldName + ']');
    var currentVal = parseInt(parentElement.val(), 10);

    if (currentVal >= 10) {
        alert("You cannot add more than 10 items !");
        return;
    }

    if (! isNaN(currentVal)) {
        parentElement.val(currentVal + 1);
        updateCartItem(
            'plus',
            parentElement.attr("data-price"),
            parentElement.attr("data-strikeprice"),
            parentElement.attr("data-subCategoryId"),
            parentElement.attr("data-productId"),
            parentElement.val()
        );
    } else {
        parent.find('input[name=' + fieldName + ']').val(0);
    }
}
function decrementCartBtnValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var parentElement = parent.find('input[name=' + fieldName + ']');
    var currentVal = parseInt(parentElement.val(), 10);

    if (! isNaN(currentVal) && currentVal > 0) {
        parentElement.val(currentVal - 1);
        updateCartItem(
            'minus',
            parentElement.attr("data-price"),
            parentElement.attr("data-strikeprice"),
            parentElement.attr("data-subCategoryId"),
            parentElement.attr("data-productId"),
            parentElement.val()
        );
    } else {
        parentElement.val(0);
    }
}

function updateCartItem(type, sellingPrice, currentPrice, subCategoryId, productId, qty) {
    if (cartTotals[subCategoryId] !== undefined) {
        if (type == "plus") {
            if (cartTotals[subCategoryId]) {
                sellingPrice = parseInt(cartTotals[subCategoryId]['cartSellingTotal']) + parseInt(sellingPrice);
                currentPrice = parseInt(cartTotals[subCategoryId]['cartCurrentTotal']) + parseInt(currentPrice);
            } else {
                sellingPrice = parseInt(sellingPrice);
                currentPrice = parseInt(currentPrice);
            }
        } else {
            if (cartTotals[subCategoryId]) {
                sellingPrice = parseInt(cartTotals[subCategoryId]['cartSellingTotal']) - parseInt(sellingPrice);
                currentPrice = parseInt(cartTotals[subCategoryId]['cartCurrentTotal']) - parseInt(currentPrice);
            } else {
                sellingPrice = parseInt(sellingPrice);
                currentPrice = parseInt(currentPrice);
            }
        }
    }

    cartItems[productId] = {
        "productId" : productId,
        "qty" : qty
    };
    cartTotals[subCategoryId] = {
        "cartSellingTotal" : sellingPrice,
        "cartCurrentTotal" : currentPrice
    };

    setCookie('cartDetail', JSON.stringify(cartItems), 1);
    setCookie('cartTotal', JSON.stringify(cartTotals), 1);

    if (sellingPrice != 0 && currentPrice != 0) {
        $(".cart-total").html("₹ " + sellingPrice + " &nbsp;<small><strike>₹ " + currentPrice + "</strike></small>");
        $(".cart-widget").slideDown();
        return;
    }

    $(".cart-widget").slideUp();
}

function loadCartItems(subCategoryId) {
    if (cartTotals.length > 0 && cartTotals[subCategoryId]) {
        var sellingPrice = cartTotals[subCategoryId]['cartSellingTotal'];
        var currentPrice = cartTotals[subCategoryId]['cartCurrentTotal'];
    }

    if (sellingPrice !== undefined && sellingPrice !== undefined && sellingPrice != 0) {
        $(".cart-total").html("₹ " + sellingPrice + " &nbsp;<small><strike>₹ " + currentPrice + "</strike></small>");
        $(".cart-widget").slideDown();
        return;
    }

    $(".cart-widget").slideUp();
}

function finishTcLoading() {
    $(".main-wrapper").removeAttr('style');
    jQuery('.tc-loading-screen').fadeOut(500, function () {
        // document.getElementById("tc-loader").style.display = "none";
    });
}

function confirmOrder() {
    $("#submit-tc-payment").submit();
}

function loadServiceModal(productId) {
    $.ajax({
        type : "POST",
        dataType: "json",
        url : "/cart/fetchService",
        data: {productId: productId},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(response) {
            if (response.success) {
                var modalBody = loadServiceModalBody(response);
                $(".tc-service-title").html(response.product.title);
                $(".tc-service-description").html(response.product.long_description);
                $(".tc-service-body").html(modalBody);
            }
            $("#tc-service-modal").modal("show");
        },
    });
}

function loadServiceModalBody(response) {
    var html = "";
    response.services.forEach(function(service){
        html +=
        `<hr>
        <div class="product-inner-section row">
            <div class="col-9">
                <p class="mb-0 text-dark"><b>${service.title}</b></p>
                <small class="text-body"><i class="fa fa-solid fa-star rating-star"></i> 4.83 (1.54M reviews)</small>
                <p class="text-dark"><small><strong>₹ ${service.price}</strong>&nbsp;&nbsp;&nbsp;<strike>₹ ${service.strike_price}</strike></small></p>
            </div>
            <div class="col-3">
                <img class="img-thumbnail p-0" src="https://dummyimage.com/200x200/000/fff" alt="AC Repair (Split/Window)">
                <div>
                    <div class="quantity-cart input-group w-auto justify-content-center align-items-center">
                        <input type="button" value="-" class="cart-btn button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                        <input
                            data-subCategoryId="${service.sub_category_id}"
                            data-productId="${service.id}"
                            data-price="${service.price}"
                            data-strikeprice="${service.strike_price}"
                            type="text"
                            step="1"
                            max="10"
                            value="${response.cartArray[service.id] ? response.cartArray[service.id] : 0}"
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
                    ${service.description}
                </div>
            </div>
        </div>`;
    },undefined, response.cartArray);

    return html;
}

function rateOrderDetails(id, order, rating) {
    if (id === undefined || order === undefined || rating === undefined) {
        swal.fire('Whoops !', 'Something went wrong !', 'danger')
    }

    $.ajax({
        type : "POST",
        dataType: "json",
        url : "/cart/rating",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : {
            id: id,
            order: order,
            rating: rating,
        },
        success : function(response) {
            Swal.fire({
                title: 'Thank you ! Your rating are valuable to us',
                showCancelButton: false,
                confirmButtonText: 'Okay Got it',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
        },
    });
}

$(document).ready(function () {

    $(document).on('click', '.button-plus', function(e) {
        incrementCartBtnValue(e);
    });

    $(document).on('click', '.button-minus', function(e) {
        decrementCartBtnValue(e);
    });

    if(! navigator.cookieEnabled) {
        $(".mt-0").html("<h1 align='center'>Please Enable Cookies !</h1>");
    }

    $("#book-tc-service").click(function() {
        $.ajax({
            type : "POST",
            dataType: "json",
            url : "/cart/fetchAddress",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : $("#submit-tc-address").serialize(),
            success : function(response) {
                if (response.success) {
                    $("#tc-select-address").show();
                    $("#tc-existing-address-text").html(response.address);
                    $("#tc-existing-address").val(response.address);
                    $("#tc-existing-house_no").val(response.house_no);
                    $("#tc-existing-landmark").val(response.landmark);
                }

                $("#tc-address-modal").modal("show");
            },
        });
    });

    $("#login-from-cart").click(function() {
        window.location.href = "/login";
    });

    $("#submit-address").click(function() {
        $("form#submit-tc-address :input").each(function(){
            var input = $(this);
            var inputId = input.attr("id")
            input.removeClass("is-invalid");
            $("#" + inputId + "-error").html("");
        });

        $.ajax({
            type : "POST",
            dataType: "json",
            url : "/cart/addAddress",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : $("#submit-tc-address").serialize(),
            success : function(response) {
                if (response.success) {
                    $("#tc-address-modal").modal("hide");
                    $("#tc-payment-modal").modal("show");
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors.errors, function (key, value) {
                    var errorInputId = "tc-" + key;
                    var errorInpuErrtId = "tc-" + key + "-error";
                    $("#" + errorInputId).addClass("is-invalid");
                    $("#" + errorInpuErrtId).html(value);
                });
            }
        });
    });

    $(".contact-data").click(function() {
        $("#tc-house_no").val($("#tc-existing-house_no").val());
        $("#tc-landmark").val($("#tc-existing-landmark").val());
        $("#tc-address").val($("#tc-existing-address").val());
        $("#tc-select-address").slideUp();
    });

    $("#tc-cash-payment").click(function() {
        $("#payment_method").val("cash");
        $(this).removeClass("btn-secondary").addClass("btn-success").html("Selected");
        $('.paymentBtn').not('#tc-cash-payment').hide();
        $(".payment-error").hide();
    });

    $("#tc-upi-payment").click(function() {
        alert("Coming Soon");
    });

    $("#submit-payment").click(function() {
        var payment_method = $("#payment_method").val();
        $(".payment-error").hide();
        if (payment_method == "cash") {
            Swal.fire({
                icon: 'info',
                title: 'Confirm to Place Order ?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                denyButtonText: 'Cancel',
              }).then((result) => {
                if (result.isConfirmed) {
                  confirmOrder();
                }
              })
        } else {
            $(".payment-error").show();
        }
    });

    $(".tc-rating").click(function() {
        var id = $(this).attr("data-id");
        var order = $(this).attr("data-order");
        let wrap = document.createElement('div');

        wrap.setAttribute('class', 'text-muted');
        wrap.innerHTML = '<button onclick="rateOrderDetails(' + id +', ' + order + ', 1)" type="button" value="sad" class="btn feel"><i style="font-size: 24px;color:#FC252E;" class="far fa-frown-open"></i></button><button onclick="rateOrderDetails(' + id +', ' + order + ', 2)" type="button" value="sad" class="btn feel"><i style="font-size: 24px;color:#FE7C34;" class="far fa-frown"></i></button><button onclick="rateOrderDetails(' + id +', ' + order + ', 3)" type="button" value="sad" class="btn feel"><i style="font-size: 24px;color:#FCDD3D;" class="far fa-meh"></i></button><button onclick="rateOrderDetails(' + id +', ' + order + ', 4)" type="button" value="neutral" class="btn feel"><i style="font-size: 24px;color:#D3E736;" class="far fa-smile"></i></button><button onclick="rateOrderDetails(' + id +', ' + order + ', 5)" type="button" value="happy" class="btn feel"><i style="font-size: 24px;color:#5AD829;" class="far fa-laugh-squint"></i></button><hr>';

        swal.fire({
            title: "How was your our service experience ?",
            className: '',
            closeOnClickOutside: false,
            html: wrap,
            showCancelButton: false,
            showConfirmButton: false,
            buttons: {
                confirm: {
                    text: "Close",
                    value: '',
                    visible: true,
                    className: "btn btn-default",
                    closeModal: true,
                }
            },
        });
    });

    $(".promocode-btn").click(function () {
        var promocode = $(".promocode-input").val().trim();
        if (promocode != '') {
            $.ajax({
                type : "POST",
                dataType: "json",
                url : "/apply/promocode",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : $("#apply-discount-form").serialize(),
                success : function(response) {
                    if (response.success) {
                        var table = $(".billing-summary");
                        var billingTotal = (parseFloat($(".billing-total").html().trim()) - parseFloat(response.discount));
                        var billingDiscount = (parseFloat($(".billing-discount").html().trim()) + parseFloat(response.discount));
                        table.append('<tr style="background: #1b8b1b17;"><th><p class="text-dark">Promocode Discount</p></th><td><p style="float: right" class="text-dark">₹ '+ response.discount +'</p></td></tr>');
                        $(".billing-total").html(billingTotal);
                        $(".billing-discount").html(billingDiscount);
                        $(".promocode-input").prop('disabled', true);
                        $(".promocode-btn").html('Applied').attr('disabled', true);
                        $(".submit-tc-promocode").val(response.promo);
                        swal.fire(response.message, '', 'success');
                    } else {
                        swal.fire(response.message, '', 'warning');
                    }
                },
                error: function (data) {
                    Swal.fire('Something went really wrong!', '', 'error');
                }
            });
        } else {
            Swal.fire('Please Enter Promocode', '', 'warning');
        }
    })
});
