  <!DOCTYPE html>
<html>

	<head>
	  	<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
	    <title> TattooIs Join </title>	
	  
	    <link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'style.css');?>" />
	    <link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'bootstrap.min.css');?>" />
		
		<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'font-awesome/css/font-awesome.min.css');?>">
				
		<link rel="stylesheet" href="<?php echo base_url(ASSETS_CSS.'animate.css');?>" />
	</head>

	<body class="gray-bg">
		<div class="write_bt write_bt2">
	        <a href="/">
                <i class="fa fa-home fa-2x"></i>
            </a>
        </div> 	
		<div class="middle-box text-center loginscreen animated fadeInDown">
	        <div>
	            <div>
	                <h1 class="logo-name" style="font-size: 90px;">TATTOO IS</h1>
	            </div>
<!-- 	            <h3>타투이즈와 함께 하시겠습니까?</h3> -->
	            <p>타투이즈와 함께 하시겠습니까?</p>
				
	            <form class="m-t" role="form" method="post" action="/user/input" id="user_register">
	                <div class="form-group p_check">
	                    <input type="text" class="form-control" name="email" id="email" placeholder="Email Address" maxlength="60" required="" />
	                    <input type="hidden" name="email_checked" id="email_checked" />
	                    <span id="email_check_text" class="small">이메일을 입력하세요.</span>
	                    <input type="button" class="btn btn-default btn-sm bt_check" onclick="exist_check('email');" value="Check" />
<!-- 						<button type="button" name="email_check" class="pull-right" onclick="exist_check('email');">Check</button> -->
	                </div>
	                <div class="form-group p_check">
	                    <input type="text" class="form-control" name="nick" id="nick" class="nick" value="" placeholder="Nick Name" maxlength="15" required="" />
	                    <input type="hidden" name="nick_checked" id="nick_checked" />
	                    <span id="nick_check_text" class="small">닉네임을 입력하세요.</span>
						<input type="button" class="btn btn-default btn-sm bt_check" onclick="exist_check('nick');" value="Check" />
<!-- 	                    <button type="button" name="nick_check" class="pull-right" onclick="exist_check('nick');">Check</button> -->
	                </div>
	                <div class="form-group">
	                    <input type="password" class="form-control" name="login_pw" id="login_pw" value="" placeholder="Password" maxlength="30" required="" />
	                    <span class="small">영문자, 숫자, _만 입력 가능합니다. 최소 4자이상 입력하세요.</span>
	                </div>
	                <div class="form-group">
	                    <input type="password" class="form-control" name="login_pw_re" id="login_pw_re" placeholder="Password-check" maxlength="30" required="" />
	                    <span class="small">비밀번호를 다시한번 입력해 주세요.</span>
	                </div>
	                <div class="form-group">
                        <div class="checkbox i-checks">
	                        <label> <input type="checkbox" name="user_agree" /><i></i> 약관에 동의하시면 체크해주세요 </label>
                        </div>
                        <button type="button" class="btn btn-default btn-sm agree_bt">약관보기</button>
						<input type="submit" class="btn btn-primary block full-width m-b" value="Create an account" />
						<p class="text-muted text-center"><small>타투이즈 계정을 보유하고 계신가요?</small></p>
						<a class="btn btn-sm btn-white btn-block" href="/auth">Login</a>
	                </div>
	            </form>
	            <p class="m-t"> <small>Tattoo Is &copy; 2015</small> </p>
	        </div>
	    </div>

	</body>
</html>
