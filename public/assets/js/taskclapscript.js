function renderLoginScreen() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}

function sendSmsForVerify() {
    var number = $("#phone").val();
    number = "+91" + number;

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
        var user = result.user;
        if (user) {
            $.ajax({
                type : "POST",
                url : "/login",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    'phone' : $("#phone").val()
                },
                success : function(response) {
                    if (response) {
                        window.location.href = '/';
                    } else {
                        $(".login-screen-otp").hide();
                        $("#dialogue-box").html("<div class='alert alert-danger'>We're really Sorry !<br>But an unexpected error occurred. Please try after sometime.</div>");
                        $("#dialogue-box").show();
                    }
                }
            });
        }
    }).catch(function (error) {
        $("#dialogue-box").html("<div class='alert alert-danger'>" + error.message + "</div>");
        $("#dialogue-box").show();
    });
}

function setLoginOtpTimeExpiry() {
    var timer2 = "0:05";
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
            $(".login-time-expiry").hide();
            $(".no-otp-recieved").html('<a onclick="resendSmsForVerify()">Resend OTP</a>');
            clearInterval(otpResent);
        }
        timer2 = minutes + ':' + seconds;
    }, 1000);

    $(".login-time-expiry").show();
}
