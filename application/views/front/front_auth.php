<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>TattooIs Login</title>

	<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'auth.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'font-awesome/css/font-awesome.min.css');?>">
	<!-- toastr popup -->
	<link rel="stylesheet" href="/assets/emJs/lib/toastr/toastr.css">

	<!--[if lt IE 9]>
	    <script src="<?php echo base_url(ASSETS_JS.'respond.js');?>"></script>
	    <script src="<?php echo base_url(ASSETS_JS.'html5shiv.js');?>"></script>
	<![endif]-->
    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo base_url(ASSETS_JS.'jquery/jquery.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url(ASSETS_JS.'jquery/jquery-ui.min.js');?>"></script>
    
    <!-- toastr popup -->
	<script type="text/javascript" src="/assets/emJs/lib/toastr/toastr.min.js"></script>
</head>

<body>
	<div id="auth">
		<div class="auth-inner">
			<div class="container">
				<div class="top-bar"></div>
				<div class="login-wrap">
					<h1 class="title">로그인</h1>
					<form action="/Auth/login" method="POST">
						<input type="hidden" name="ERU" value="<?=$ERU?>">

						<div class="input-container">
							<input type="text" name="email" id="Username" required="required">
							<label for="Username">Email</label>
							<div class="bar"></div>
						</div>
						<div class="input-container">
							<input type="password" name="login_pw" id="Password" required="required">
							<label for="Password">비밀번호</label>
							<div class="bar"></div>
						</div>
						<div class="button-container">
							<button><span>로그인</span></button>
						</div>
						<div class="footer">
							<div class="social-container">
								<a class="btn-social btn-facebook"><span>Facebook</span></a>
								<a class="btn-social btn-google"><span>Google</span></a>
								<a class="btn-social btn-naver"><span>Naver</span></a>
							</div>
							<a href="#">Forgot your password?</a>
						</div>
					</form>
				</div>
				<div class="join">
					<div class="toggle"></div>
					<h1 class="title">회원가입
						<div class="close"></div>
					</h1>
					<div class="input-container">
						<input type="text" id="useremail" required="required" onblur="EMailAvailableCheck();">
						<label for="useremail">Email</label>
						<div class="bar"></div>
					</div>
					<div class="input-container">
						<input type="text" id="nickname" maxlength="20" required="required">
						<label for="nickname">별명</label>
						<div class="bar"></div>
					</div>
					<div class="input-container">
						<input type="password" id="password" required="required" maxlength="20" onblur="passwordAvailableCheck();">
						<label for="password">비밀번호</label>
						<div class="bar"></div>
					</div>
					<div class="input-container">
						<input type="password" id="repeat_password" required="required" maxlength="20" onblur="passwordRepeatCheck();">
						<label for="repeat_password">비밀번호 확인</label>
						<div class="bar"></div>
					</div>
					<div class="button-container">
						<button onclick="memberJoin();"><span>완료</span></button>
					</div>
				</div>
			</div>
			<!-- .// container -->
		</div>
		<!-- .// auth-inner -->

		<div class="write_bt">
	        <a href="/">
	            <i class="fa fa-home fa-2x"></i>
	        </a>
	    </div>
	</div>
	<!-- .// #auth -->
	
	
<script type="text/javascript">
	$('.toggle').on('click', function () {
		$('.container').stop().addClass('active');
	});
	$('.close').on('click', function () {
		$('.container').stop().removeClass('active');
	});

	function memberJoin(){
		var email = $("#useremail").val();
		var nickName = $("#nickname").val();
		var userPw = $("#password").val();
		var userPwRepeat = $("#repeat_password").val();

		if(!emptyCheck(email)){
			//alert("Email을 입력해주세요");
			showToast("ERROR", 'Email을 입력해 주세요.');
			$("#useremail").focus();
			return false;
		}

		if(!EMailAvailableCheck()){
			showToast("ERROR", '잘못된 형식의 이메일 주소입니다.');
			$("#useremail").focus();
            return false;
		}

		if(!emptyCheck(nickName)){
			showToast("ERROR", '별명을 입력해주세요');
			$("#nickname").focus();
			return false;
		}

		if(!emptyCheck(userPw)){
			showToast("ERROR", '비밀번호를 입력해주세요');
			$("#password").focus();
			return false;
		}
		
		if(!passwordAvailableCheck()){
			showToast("ERROR", '영문,숫자 혼합하여 최소 6자리 이상입니다.');
            $("#password").focus();
            return false;
		}

		if(!emptyCheck(userPwRepeat)){
			showToast("ERROR", '비밀번호 확인을 입력해주세요');
			$("#repeat_password").focus();
			return false;
		}
		
		if(!passwordRepeatCheck()){
			showToast("ERROR", '비밀번호가 일치하지 않습니다');
            $("#password").focus();
			return false;
		}
		
		var data = {'email':email, 'nick':nickName, 'login_pw':userPw, 'login_pw_repeat':userPwRepeat};

		$.post('/user/register', data, function (data){
            var result = data.result;
            var message = data.message;

            if(result){
            	showToast("SUCCESS", message);
            	var email = $("#useremail").val('');
				var nickName = $("#nickname").val('');
				var userPw = $("#password").val('');
				var userPwRepeat = $("#repeat_password").val('');
            	$('.container').stop().removeClass('active');
            }
            else {
            	showToast("ERROR", message);
            }
        });	

		
	}

	function EMailAvailableCheck(){
		var email = $("#useremail").val();
	 
        // 값을 입력안한경우는 아예 체크를 하지 않는다.
        if( email == '' || email == 'undefined') return true;
 		
		var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; 

        // 이메일 유효성 검사
        if(!regExp.test(email)) {
            //alert('잘못된 형식의 이메일 주소입니다.');
            showToast("ERROR", '잘못된 형식의 이메일 주소입니다.');
            return false;
        }

        return true;
	}
	
	function passwordAvailableCheck(){
		var userPw = $("#password").val();
		
        if( userPw == '' || userPw == 'undefined') return true;

        var reg_pwd = /^.*(?=.{6,20})(?=.*[0-9])(?=.*[a-zA-Z]).*$/;
        
        if( userPw.length < 6 || !reg_pwd.test(userPw)){
			showToast("ERROR", '영문,숫자 혼합하여 최소 6자리 이상입니다.');
            return false;
        }
        
		return true;

	}
	
	function passwordRepeatCheck(){
		var userPw = $("#password").val();
		var userPwRepeat = $("#repeat_password").val();

		// 값을 입력안한경우는 아예 체크를 하지 않는다.
        if( userPwRepeat == '' || userPwRepeat == 'undefined') return true;

		if(userPw != userPwRepeat){
			//alert("비밀번호가 일치하지 않습니다");
			showToast("ERROR", '비밀번호가 일치하지 않습니다');
			return false;
		}
		
		return true;
	}

	function emptyCheck(val){

		if(!val || val == "" || val == null){

			return false;

		}

		return true;
	}
	
	// toastr 
	function showToast(type, text) {
		toastr.options = {
			"closeButton": false,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-bottom-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "2000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
		
		if(type == "SUCCESS"){
			toastr.success('<p>' + text + '</p>', {});
		}
		
		if(type == "ERROR"){
			toastr.error('<p>' + text + '</p>', {
				showEasing : 'linear'
			});
		}
	}


</script>
</body>
</html>