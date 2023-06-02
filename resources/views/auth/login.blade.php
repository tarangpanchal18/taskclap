@extends('layouts.app')

@section('content')
    <!-- <div class="container mt-5" style="max-width: 550px">
        <div class="alert alert-danger" id="error" style="display: none;"></div>
        <h3>Please Login to continue</h3>
        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
        <form>
            <label>Phone Number:</label>
            <input type="text" id="number" class="form-control" placeholder="+91 ********" value="+91 7383742776">
            <div id="recaptcha-container"></div>
            <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">Send OTP</button>
        </form>

        <div class="mb-5 mt-5">
            <h3>Add verification code</h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control" placeholder="Verification code" value="123456">
                <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
            </form>
        </div>
    </div> -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-back">
                            <a href="{{ route('homepage') }}"><img src="assets/img/icons/undo-icon.svg" class="me-2" alt="icon">Back To Home</a>
                        </div>
                        <div class="login-header">
                            <h3>Login</h3>
                            <p>We'll send a confirmation code to your Phone.</p>
                        </div>
                        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
                        <div class="alert alert-danger" id="error" style="display: none;"></div>
                        <!-- Login Screen -->
                        <div class="login-screen">
                            <div class="log-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="col-form-label">Phone Number</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg group_formcontrol" id="phone" name="phone" placeholder="Enter your Phone Number" value="7383742776" required>
                                        </div>
                                    </div>
                                    <div id="recaptcha-container"></div>
                                </div>
                            </div>
                            <button type="button" onclick="sendOTP();" class="btn btn-primary w-100 login-btn">Login</button>
                        </div>

                        <!-- OTP Screen -->
                        <div class="login-screen-otp" style="display: none;">
                            <div class="form-group">
                                <div class="passcode-wrap digit-group passcode-verified">
                                    <input type="text" id="digit-1" name="digit-1" data-next="digit-2" maxlength="1">
                                    <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1">
                                    <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1">
                                    <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1">
                                    <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1">
                                    <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" maxlength="1">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="time-expiry" style="display: none;">
                                    <i class="feather-clock me-1"></i><span class="expiry-time-block"></span>
                                </div>
                                <p class="no-acc no-otp-recieved"></p>
                            </div>
                            <button class="btn btn-primary w-100 login-btn mb-0" type="button"  onclick="verify()">Verify code</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyB8J5VxtjPFjjFB54QbQ0p8wLfMnZwdH0w",
            authDomain: "taskclap-2023.firebaseapp.com",
            databaseURL: "https://taskclap-2023.firebaseio.com",
            projectId: "taskclap-2023",
            storageBucket: "taskclap-2023.appspot.com",
            messagingSenderId: "380954429436",
            appId: "1:380954429436:web:fed0c4bb3e2215ef4d5479"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
    <script type="text/javascript">
        window.onload = function () {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function sendOTP() {
            var number = $("#phone").val();
            number = "+91" + number;
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                $(".login-screen").hide();
                $(".login-screen-otp").show();
                $("#successAuth").text("We've sent you a 6 digit OTP on " + $("#phone").val());
                $("#digit-1").focus();
                $("#successAuth").show();

                //Starting Timer
                $(".time-expiry").show();
                var timer2 = "1:01";
                var otpResent = setInterval(function() {
                    var timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    var minutes = parseInt(timer[0], 10);
                    var seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;
                    if (minutes < 0) clearInterval(interval);
                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    $('span.expiry-time-block').html(minutes + ':' + seconds);
                    if (minutes == "0" && seconds == "00") {
                        $(".time-expiry").hide();
                        $(".no-otp-recieved").html('<a href="#">Resend OTP</a>');
                        clearInterval(otpResent);
                    }
                    timer2 = minutes + ':' + seconds;
                }, 1000);


            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }

        function verify() {
            var code1 = $("#digit-1").val();
            var code2 = $("#digit-2").val();
            var code3 = $("#digit-3").val();
            var code4 = $("#digit-4").val();
            var code5 = $("#digit-5").val();
            var code6 = $("#digit-6").val();
            var code = code1 + code2 + code3 + code4 + code5 + code6;
            coderesult.confirm(code).then(function (result) {
                var user = result.user;
                $.ajax({
                    type : "POST",
                    url : "{{ route('login') }}",
                    data : {
                        '_token': "{{ csrf_token() }}",
                        'phone' : $("#phone").val()
                    },
                    success : function(response) {
                        window.location.href = '/';
                    }
                });
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script>
@endsection
