<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Lendzapp | Admin Login</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="<?php echo base_url('assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style2.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/theme/default.css'); ?>" rel="stylesheet" id="theme" />
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo/favicon.ico'); ?>"/>
	<style type="text/css">
	@font-face {
    font-family: "Averta Black";
    src: url("../assets/fonts/AVERTA-BLACK-5937CBE30AB39.OTF") format("opentype");
}
@font-face {
    font-family: "Averta Demo";
    src: url("../assets/fonts/AVERTADEMO-REGULAR.OTF") format("opentype");
}
@font-face {
    font-family: "Averta Light";
    src: url("../assets/fonts/AVERTA-LIGHT-5937CBA3908C3.OTF") format("opentype");
}
@font-face {
    font-family: "Averta Bold";
    src: url("../assets/fonts/AVERTA-BOLD-5937CBCA0E351.OTF") format("opentype");
}
@font-face {
    font-family: "Averta SemiBold";
    src: url("../assets/fonts/AVERTA-SEMIBOLD-5937CBC85D50B.OTF") format("opentype");
}
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
      color: rgba(0, 0, 0, 0.29) !important;
    font-size: 15px;
    font-weight: 100 !important;
}
::-moz-placeholder { /* Firefox 19+ */
      color: rgba(0, 0, 0, 0.29) !important;
    font-size: 15px;
    font-weight: 100 !important;
}
:-ms-input-placeholder { /* IE 10+ */
     color: rgba(0, 0, 0, 0.29) !important;
    font-size: 15px;
    font-weight: 100 !important;
}
:-moz-placeholder { /* Firefox 18- */
      color: rgba(0, 0, 0, 0.29) !important;
    font-size: 15px;
    font-weight: 100 !important;
}
		.login-v2 {
		    background: #fff;
		}
		.mainHeading h1{
			    color: #101010;
			    font-family: Averta Demo;
			    font-size: 40px;
			    margin: 0 0 36px;
			    padding-bottom: 15px;
			    position: relative;
			    text-align: center;
		}
		.mainHeading h1::after {
		    background: #11A2D9 none repeat scroll 0 0;
		    bottom: 0;
		    content: "";
		    height: 2px;
		    left: 0;
		    margin: auto;
		    position: absolute;
		    right: 0;
		    width: 55px;
		}
		.login .login-content{
			width:538px;
		}
		.login-v2 {
    background: #fff;
    top: 20%;
    position: absolute;
    /* bottom: 0; */
    left: 0;
    right: 0;
    margin: auto !important
}
.login-v2, .login.login-v2 label {
    /*color:#ef1616;*/
        font-family: Averta Demo;
}
.form-submit-btn:hover, .form-submit-btn:focus{
	color: #fff
}
		.login-v2 .form-control{
			    background: #fff;
    border: 1px solid;
    color: #000;
        font-family: Averta Demo;
		}
		.login-v2{
			width: 570px;
		}
		.custom_form_style .input-group input {
		    border-radius: 30px;
		    padding: 6px 25px;
		    border-color: #dcdcdc;
		        height: 50px;
		            font-family: Averta Demo;
		            font-size: 16px;
		}
		.custom_form_style .input-group-addon {
		    border-radius: 0 30px 30px 0;
		    padding: 6px 20px;
		    background: transparent;
		    border-color: #dcdcdc;
		        border: 1px solid #dcdcdc;
		}
		.input-group-addon i {
		    color: #B1B1B1;
		}
		.red_font {
		    color: #ef1616;
		    font-size: 15px;
		}
		.form-submit-btn {
		    background: #11A2D9;
		    color: #fff;
		    border-radius: 30px;
		    height: 55px;
		}
		.forgate_password {
			margin-top: 7px;
		}
	</style>
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top login_body" style="background: #f4f5f7">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	</div>
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
  
            <div class="login-content">
       	<div class="row form-controler_space">
				<div class="form-controler">
				    <div class="form_desc_text mainHeading underlineCenter">
				    	<h1>Login to LendzApp</h1>
				    </div>
				    <?php 
				    if(isset($status) && $status==false)
				    {
				    	?>
			    		<div class="alert alert-danger fade in m-b-15">
							<strong>Error!</strong>
							<?php echo $msg; ?>
							<span class="close" data-dismiss="alert">×</span>
						</div>
				    	<?php
				    }
				    ?>
				    <?php 
				        $remebUser = $this->input->cookie('username_cookie'); 
				        $remebPass = $this->input->cookie('userpassword_cookie');
				    ?>
					<form class="form-horizontal custom_form_style" method="post" action="">
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" name="User_Email"  placeholder="Email Address or Username*" id="User_Email" value="<?php echo set_value('User_Email') ?>" value="<?php if(isset($remebUser) && !empty($remebUser)) { echo $remebUser; } ?>"/>
									<span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<label class="error" for="User_Email"><?php echo form_error('User_Email'); ?></label>
							</div>
						</div>
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="password" class="form-control" id="User_Password" name="User_Password"  placeholder="Password*" value="<?php if(isset($remebPass) && !empty($remebPass)) { echo $remebPass; } ?>"/>
									<span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
								</div>
								<label class="error" for="User_Password"><?php echo form_error('User_Password'); ?></label>
							</div>
						</div>
						<div class="form-group ">
	                        <div class="checkbox" style="float: left;">
							<label style="font-size: 15px;">
								<input type="hidden" value="0" name="remember_me">
								<input type="checkbox" value="1" name="remember_me" <?php if(isset($remebPass) && !empty($remebPass) && isset($remebUser) && !empty($remebUser)) { echo 'checked'; }?>>Remember Me
							</label>
							</div> <!-- /.checkbox -->
							<div class="forgate_password pull-right"><a href="<?php echo base_url('login/forgot'); ?>"><span class="red_font">Forgot Password?</span></a></div>
						</div>
						<div class="form-group ">
							<button type="submit" class="btn  btn-lg btn-block form-submit-btn">Login</button>
						</div>
					</form>
				</div>
			</div>
            </div>
        </div>  
        <!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-1.9.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-migrate-1.1.0.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url('assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo base_url('assets/crossbrowserjs/respond.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-cookie/jquery.cookie.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url('assets/js/apps.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins\jquery-validation\dist\jquery.validate.min.js'); ?>"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function()
		{
			App.init();
				$("#login_form").validate({
			rules:
			{
				User_Email:
				{
					required: true,
					email: true
				},
				User_Password: 
				{
					required: true,
					minlength: 6,
				},
				Company_Id:
				{
					required: true
				},
				Year_Id:
				{
					required: true
				}
			},
			messages:
			{
				User_Email:
				{
					required:"Please enter Email",
					email:"Please enter valid Email",
				},
				User_Password: 
				{
					required:"Please enter valid Password",
					minlength:"Password must be 6 characters long",
				},
				Company_Id:
				{
					required: "Please select Company"
				},
				Year_Id:
				{
					required: "Please select financial year"
				}
				
			}
			});
				<?php 
			if($this->session->flashdata('flash_title'))
			{
				?>
				 $.gritter.add(
                {
                    title: "<?php echo $this->session->flashdata('flash_title'); ?>",
                    text: "<?php echo $this->session->flashdata('flash_message'); ?>",
                    <?php 
                    if($this->session->flashdata('flash_status')==true)
                    {
                    	?>
                    	class_name: 'gritter-info gritter-sucess'
                    	<?php
                    }
                    else
                    {
                    	?>
                    		class_name: 'gritter-info gritter-error'
                    	<?php
                    }
                    ?>
                    
                });
				<?php
			}
			?>
		});

	</script>
</body>
</html>
