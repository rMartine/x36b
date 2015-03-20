<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet"s href="css/login.css">
<div class="site-login">
	<div id="wrapper">
		<div id="login-body">

			<form id="login-form" class="show" method="get" action="dash.html">

				<div id="login">

					<div id="login-user">
						<div class="icon-user"><span class="arrow">"</span></div>
						<input type="text" id="username" class="login-input required" placeholder="Username" value="novalex" autocomplete="off">
						<div id="user-select">
							<ul class="grad2">
								<li class="sel">
									<img src="img/avatars/alex.jpg" alt="User avatar">
									<div class="av-login-overlay"></div><span>novalex</span></li>
								<li><img src="img/avatars/michael.jpg" alt="User avatar">
									<div class="av-login-overlay"></div><span>m1chael</span></li>
								<li><img src="img/avatars/johnny.jpg" alt="User avatar">
									<div class="av-login-overlay"></div><span>Johnny 1337</span></li>
							</ul>
						</div>

						<div id="register">
							<p>Username not found.</p>
							<button type="button" id="reg-btn" class="green btn-s">Register</button>
						</div>

					</div>

					<div id="login-pass">
						<span class="icon-securityalt-shieldalt"></span>
                        <span id="forgot-psw" style="display: none">Forgot?</span>
						<input type="password" id="password" class="login-input required passwf" placeholder="Password">
					</div>

				</div>

				<div id="login-avatar"><img src="img/avatars/alex.jpg" alt="Selected user avatar"><div id="av-login-overlay"></div></div>

				<button id="login-btn" type="submit" class="button submit">Log in</button>

			</form>

            <form id="register-form" action="dash.html">
                <div id="register-inner">
                    <input type="text" id="reg-user" class="login-input required" placeholder="Username" autocomplete="off">
                    <input type="password" id="reg-pass" class="login-input required" placeholder="Password">
                    <input type="text" id="reg-email" class="login-input required email" placeholder="E-mail">
                </div>
                <button id="register-btn" type="submit" class="button submit">Register</button>
            </form>

			<div id="login-action">
				<div id="logo"></div>
				<div id="rb-check-cont">
					<label for="rb-check">Remember me</label>
					<input type="checkbox" name="remember" id="rb-check" checked>
				</div>
			</div>
		</div>
		<div class="site-login">
			<div class="col-lg-offset-1" style="color:#999;">
				You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
				To modify the username/password, please check out the code <code>app\models\User::$users</code>.
			</div>
		</div>
	</div><!--END WRAPPER-->
</div>
	<script type='text/javascript'>
    $('#login-body').hide();
    $(window).bind('load', function() {
        $('#load').fadeOut(600, function() {
            $('#login-body').fadeIn(10, function() {
                $(this).addClass('show');
                $('#password').focus();
                if ($(window).width() <= 480) $('#password').blur();
            });
        });
    });

    var browserSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
    if (browserSafari) $('#wrapper').addClass('safari-fix');

    if ($.storage() == true) {
        localStorage.removeItem('user-name');
        localStorage.removeItem('user-avatar');
    } else {
        function lsnotif() {
            $('#wrapper').append('<div class="notif orange full slideUp">LocalStorage is disabled. Your settings will not be saved!<span class="icon icon-resistor"></span><p class="nt-det">Upgrade your browser or enable local data storage.</p></div>');
        };
        setTimeout(lsnotif, 2000);
        $.fn.notif();
    }

    $('#login-user .icon-user').click( function() {
    	$('#login-user').toggleClass('showusr');
    });

    $('#user-select li').click( function() {
    	$('#login-user').removeClass('showreg showusr');
    	$(this).addClass('sel').siblings('.sel').removeClass('sel');
    	var name = $(this).children('span').text();
    	     img = $(this).children('img').attr('src');
    	$('#username').val(name).removeClass('error').addClass('valid');
    	$('#login-avatar img').attr('src', img).fadeIn(300);
    	$('#login-user').find('.input-error').remove();
    	$('#login-pass').find('.input-error').remove();
        $('#forgot-psw').fadeOut(200);
    	$('#password').removeClass('error').val('').focus();

        if ($.storage() == true) {
            localStorage.setItem('user-name',name);
            localStorage.setItem('user-avatar',img);
        };
    });

    var users = ["novalex","m1chael","Johnny 1337"];
    var username = $('#username');
    var typeDelay;
    $(username).keyup(function(){
        clearTimeout(typeDelay);
        $('#user-select').find('.sel').removeClass('sel');
        typeDelay = setTimeout(checkuser, 500);
    });
    function checkuser() {
    	var usrval = username.val();
    	    usrlen = usrval.length;
    	if ($.inArray(usrval, users) == -1 && usrlen > 0) {
    		$('#login-avatar img').fadeOut(300);
    		$('#login-user').addClass('showreg').removeClass('showusr');
    		$('#user-select').find('.sel').removeClass('sel');
    	} else if (usrlen == 0) {
    		$('#login-avatar img').fadeOut(200);
    		$('#login-user').removeClass('showreg');
    	} else {
    		$('#login-avatar img').fadeIn(300);
    		$('#login-user').removeClass('showreg showusr');
    		$('#user-select li').each( function() {
    			var name = $(this).find('span').text();
    			     img = $(this).children('img').attr('src');
    			if (name == usrval) {
    				$(this).addClass('sel');
					$('#login-avatar img').attr('src', img);
    			}
    		});
            $('#login-pass').find('.input-error').remove();
            $('#password').removeClass('error').focus();
    	};
    };

    $('.input-error').click( function() {
        var trigger = $(this).data('trigger');
        $(this).offsetParent().find('input').eq(trigger).focus();
    });

    $('#password').keyup( function() { 
        if ($(this).val()) $('#forgot-psw').fadeOut(200)
        else $('#forgot-psw').fadeIn(300);
    });

    $('#reg-btn').click( function() {
        $('#login-form').removeClass('show');
        $('#register-form').addClass('show');
        $('#reg-user').focus();
    });

    $('#rb-check').checkfn();

    $('#login-form, #register-form').validate();

    </script>