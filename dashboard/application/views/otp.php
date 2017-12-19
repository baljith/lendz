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
				    	<h1>Verify Your Email Address</h1>
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
					<form class="form-horizontal custom_form_style" method="post" id="verify_opt_code" action="">
						<div class="form-group" style="margin-bottom: 0px;">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="hidden" class="form-control" name="user_id"  placeholder="Email verification code" id="user_id" value="<?php echo $email; ?>"/>
									<input type="text" class="form-control" name="code"  placeholder="Email verification code" id="code" value=""/>
									<span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<p>Enter the verification code above which is sent on your registered email address.</p>
								<label class="error" id="code-error" for="code"><?php echo form_error('code'); ?></label>
							</div>
						</div>
						<div class="form-group ">
							<div class="pull-right">
								<a type="button" style="cursor: pointer; border: 1px solid red;
    padding: 8px 5px;
    border-radius: 4px;" class="resend_code">
									<span class="red_font">Resend verification code</span>
								</a>
							</div>
							<p class="error-code-send error" style="color: red;clear: both; float: right; margin-top: 8px;"></p> <p class="success-code-send success" style="color: green;clear: both; float: right; margin-top: 8px;"></p> </div>
						<div class="form-group ">
							<button type="submit" class="btn btn-lg btn-block form-submit-btn">Verify</button>
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

<?php get_footer(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- <script src="<?php// echo base_url('assets/js/custom/common.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/additional-methods.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>  
<script>
$( "#verify_opt_code" ).validate(
	{
		rules:
        {
        	code:
        	{
        		required:true,
        		minlength: 5,
        		maxlength:5,
        		number:true
			}
        },
        messages:
        {
        	code:
            {
            	minlength:"Code should be 5 character long",
            	maxlength:"Code should be 5 character long",
            	required:"Please enter your code and try again",
            	number:"Please enter a valid code",
            },
        },
        submitHandler: function(form){
        	$(".loader").removeClass("hide");
			var formData = new FormData(form);
			$.ajax({
				url: '<?php echo base_url('login/verify_code'); ?>',
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
						window.location.href="<?php echo base_url('register/success?'); ?>";
					}
					else
					{
						$('#code-error').text(data['flash_message']).css('visibility','visible');
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

	$('.resend_code').on('click',function(){
		$obj = $(this);
		$obj.css('cursor','none');
		email = $('#user_id').val();
		$.ajax({
				url: '<?php echo base_url('login/send_code'); ?>',
				type: 'POST',
				dataType: 'json',
				data: { 'email':email },
				success:function(data)
				{	
					$obj.css('cursor','pointer');
					if(data['flash_status'])
					{	
						$('.error-code-send').css('visibility','hidden');
						$('.success-code-send').text('Sent successfully');
					}
					else
					{
						$('.success-code-send').css('visibility','hidden');
						$('.error-code-send').text(data['flash_message']).css('visibility','visible');
					}
				}
			})
	});
</script>
