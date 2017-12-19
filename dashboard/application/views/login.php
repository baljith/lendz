<?php get_header(); ?>
<style>
#masthead {
	background: #000;
}
.form-control
{
	color: black !important;
}
.loader {
  	border: 3px solid #f3f3f3;
    border-radius: 50%;
    border-top: 3px solid #ef1616;
    border-bottom: 3px solid #ef1616;
    width: 30px;
    height: 30px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}
</style>
    <div class="custom_page">
		<div class="container">
			<div class="row form-controler_space">
				<div class="form-controler">
				    <div class="form_desc_text mainHeading underlineCenter">
				    	<h1>Login to ToolTruckApp</h1>
				    </div>
				   
			    		<div class="alert alert-danger fade in m-b-15" id="error_messages" style="display: none">
							<strong>Error!</strong>
							<span id="msh_dddd"></span>
							<span class="close" data-dismiss="alert">×</span>
						</div>
				    	
					<form class="form-horizontal custom_form_style" method="post" id="login_form" action="">
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" name="User_Email"  placeholder="Email Address or Username*" id="User_Email" value="<?php echo set_value('User_Email') ?>"/>
									<span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<label class="error" for="User_Email"><?php echo form_error('User_Email'); ?></label>
							</div>
						</div>
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="password" class="form-control" id="User_Password" name="User_Password"  placeholder="Password*"/>
									<span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
								</div>
								<label class="error" for="User_Password"><?php echo form_error('User_Password'); ?></label>
							</div>
						</div>
						<div class="form-group ">
	                        <div class="checkbox">
							<label>
								<input type="checkbox">Remember Me
							</label>
							</div> <!-- /.checkbox -->
							<div class="forgate_password pull-right"><a href="<?php echo base_url('forgot'); ?>"><span class="red_font">Forgot Password?</span></a></div>
						</div>
						<div class="form-group ">
							<button type="submit" class="btn  btn-lg btn-block form-submit-btn">Login</button>
							<div class="loader hide signup_loader"></div>
						</div>
					</form>
				</div>
				<div class="panel-heading_custom">
	               <div class="panel-title text-center">
	               		Dont't have an account? <a href="<?php echo base_url('register'); ?>"><span class="red_font">Sign Up </span></a>
	               	</div>
	            </div>
			</div>
		</div>
	</div>
<div class="modal fade" id="modal-alert">
	<div class="modal-dialog">
		<div class="modal-content">
		<form action="" id="verify_opt_code" method="post" class="form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Please verify your email to login</h4>
			</div>
			<div class="modal-body">
				<div class="form-group" style="margin-bottom: 7px;">
                  	<label class="col-lg-3 control-label text-right">Enter Code</label>
                  	<div class="col-lg-9">
                     	<input type="hidden" id="user_id" name="user_id" value="">
						<input type="text"  name="code" class="form-control" value="" name="term" placeholder="Search a user to chat">
						<label id="code-error" class="error" for="code" style="visibility: visible;"></label>
                  	</div>
              </div>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
				<button  type="submit" id="create_thread_btn_submit" class="btn btn-sm btn-success">Verify</button>
			</div>
		</form>
		</div>
	</div>
</div>

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- <script src="<?php// echo base_url('assets/js/custom/common.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/additional-methods.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>  
<script>
	$( "#login_form" ).validate(
	{
		focusInvalid: false,
		invalidHandler: function(form, validator)
		{
        	if (!validator.numberOfInvalids())
            return;
        	var top_to_list = parseFloat($(validator.errorList[0].element).offset().top)-150;
       		$('html, body').animate({
            	scrollTop:top_to_list
        	}, 1000);
        
    	},
		rules:
        {
        	User_Password:
        	{
        		required:true,
        		minlength: 6,
			},
            User_Email:
            {
            	minlength: 6,
                required: true,
            }
        },
        messages:
        {
        	User_Email:
            {
            	minlength:"Username should be minimum 6 character long",
            	required:"Please enter your Username and try again",
            },
            User_Password:
            {
            	required:"Please enter your password to proceed further",
            	minlength:"Password should be minimum 6 character long"
            }
        },
        submitHandler: function(form){
        	$(".loader").removeClass("hide");
			var formData = new FormData(form);
			$.ajax({
				url: '<?php echo base_url('login/check'); ?>',
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData:false,
				contentType: false,
				cache :false,
				success:function(data)
				{	
					if(data['flash_status'])
					{	
						if(data['verify_status'])
						{
							window.location.href="<?php echo base_url('register/otp?email='); ?>"+data['user'];
						}
						else
						{
							window.location.href="<?php echo base_url('dashboard'); ?>";
						}
					}
					else
					{
						$('#error_messages').show().find('#msh_dddd').text(data['flash_message']);
					}
				}
			})
			.done(function() {
				$(".loader").addClass("hide");
				console.log("success");
			})
			.fail(function() {
				$(".loader").addClass("hide");
				console.log("error");
			})
			.always(function() {
				$(".loader").addClass("hide");
				console.log("complete");
			}); 	
        }
	});

</script>
