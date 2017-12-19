<?php get_header();?>
<style>
.custom_form {
    height: 70px !important;
}
.form-control
{
	color: black !important;
}
#tags_input_validd
{
	color: black !important;
}
#masthead {
	background: #000;
}
.error::first-letter
{
	text-transform: capitalize;
}
input[type="number"] {
    -moz-appearance: textfield;
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

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>">    
<div class="custom_page">
		<div class="container">
			<div class="row form-controler_space">
				<div class="form-controler">
					<div class="alert alert-success hide" id="successMsg">
					  
					</div>
					<div class="alert alert-danger hide" id="errorMsg">
					  	
					</div>
				    <div class="form_desc_text mainHeading underlineCenter">
				    	<h1>Sign Up as a <br>Tool Truck Driver</h1>
				    </div>
					<form class="form-horizontal custom_form_style" method="post" action="#" id="register_validate_form">
						<div id="first_steps">
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required" name="User_First_Name" id="User_First_Name"  placeholder="First Name*"/>
										<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_First_Name"></label>
								</div>
							</div>
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required" name="User_Last_Name" id="User_Last_Name"  placeholder="Last Name*"/>
										<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Last_Name"></label>
								</div>
							</div>
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control" name="User_Franchise_Name" id="User_Franchise_Name"  placeholder="Franchise Name"/>
										<span class="input-group-addon"><i class="fa fa-building-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Franchise_Name"></label>
								</div>
							</div>
							<div class="form-group custom_form">

								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required" name="User_Buisness_Address" id="User_Buisness_Address" placeholder="Business Address*"/>
										<span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Buisness_Address"></label>
								</div>
							</div>

							<div class="form-group custom_form">
								<div class="cols-sm-10">
								<div class="input-group">
										<input type="text" name="Time_Period_Franchise" id="Time_Period_Franchise" class="form-control " placeholder="Time Period Of Franchise Ownership">
										<span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="Time_Period_Franchise"></label>
								</div>
							</div>

							<div class="form-group custom_form">

								<div class="cols-sm-10">
								<div class="input-group">
										<input type="text" name="User_Zip_Code" id="User_Zip_Code" class="form-control required" placeholder="Zip Codes You Service*">
										<span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Zip_Code" id="User_Zip_Code-error"></label>
								</div>
							</div>
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="number" class="form-control required check_numeric no-spin" id="User_Phone" name="User_Phone"  placeholder="Phone Number*"/>
										<span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Phone"></label>
								</div>
							</div>
							<div class="form-group custom_form">

								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required" name="User_Email" id="User_Email"  placeholder="Email Address*"/>
										<span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Email"></label>
								</div>
							</div>
							<div class="form-group custom_form">

								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required" name="Username" id="Username"  placeholder="Username*"/>
										<span class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="Username"></label>
								</div>
							</div>
							<div class="form-group custom_form">

								<div class="cols-sm-10">
									<div class="input-group">

										<input type="password" class="form-control required" name="User_Password" id="User_Password" placeholder="Password*"/>
										<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Password"></label>
								</div>
								<input type="hidden" name="User_Role" value="3">
							</div>
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="password" class="form-control required" name="User_Password_Confirm" id="User_Password_Confirm" placeholder="Confirm  Password*"/>
										<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									</div>
									<label class="error" for="User_Password_Confirm"></label>
								</div>
							</div>
							<div class="form-group custom_form ">
		                        <div class="checkbox">
									<label>
											<input style="" type="checkbox" class="required" name="terms">By signing up , I agree to ToolTruckApp <span class="red_font">Terms of Service</span> and <span class="red_font">Privacy Policy</span>
									</label>
								</div> <!-- /.checkbox -->
									<label style="visibility:visible;margin: 0px;padding: 0px;margin-top:3px;" class="error" for="terms"></label> 
							</div>
							<div class="form-group custom_form ">
								<button type="button" onclick="setp_2()" class="btn  btn-lg btn-block form-submit-btn">Proceed To Payment</button>

								
							</div>
						</div>
						<div id="second_step" style="display: none;">
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group chevron-down">
									   <select class="form-control dropdown-img required" name="Monthly_Subscription" id="Monthly_Subscription">
									        <option  hidden  value="">Select monthly subscription</option>
									        <?php 
									        if(!empty($subscriptions))
									        {
									        	if(isset($_GET['pack']) && !empty($_GET['pack'])){
									        		$sel_pack = $_GET['pack'];
									        	}
									        	else{
									        		$sel_pack = 1;
									        	}
									        	foreach($subscriptions as $subs)
									        	{
									        		?>
									        		<option value="<?php echo $subs['Package_Id']; ?>" <?php echo ($subs['Package_Id']==$sel_pack)?'selected':''; ?>><?php echo $subs['Package_Name']." ( $ ".$subs['Package_Price'].")"; ?></option>
									        		<?php
									        	}
									        }
									        ?>
									    </select>

									</div>
									<label class="error" for="Monthly_Subscription"></label>
								</div>
							</div>
							<div class="form-group custom_form">
								<div class="cols-sm-10">									
									<h3 class="cr-h">Enter Your Credit Card Information</h3>
									<img class="cr-img" src="<?php echo base_url('assets/img/credit-cards-img.png');?>" />
								</div>
							</div>

							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required card-number" id="Credit_Card_Number" data-stripe="number"  name="Credit_Card_Number"  placeholder="Credit Card number"/>
										<span class="input-group-addon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
									</div>
									<label class="error" id="Credit_Card_Number-error" for="Credit_Card_Number"></label>
								</div>
							</div>
							
							<div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="row">
										<div class="col-sm-6">
											<div class="input-group">
												<select class="selectpicker form-control  card-expiry-month"  style="width:100%!important;" data-width="100%" data-size="12">
													<option value="">Select Month</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
												</select>
											</div>
											<label id="UserMonth-error" class="error" for="UserMonth"></label>
										</div>
										<div class="col-sm-6">
											<div class="input-group">
												<select class="selectpicker form-control  card-expiry-year" style="width:100%!important;" data-size="12" data-width="100%">
													<option value="">Select Year</option>
													<option value="<?php echo date('y'); ?>">
														<?php echo date('Y'); ?>
													</option>
													<?php 
													for($i=1;$i<=10;$i++) {
													?>
													<option value="<?php echo date('y', strtotime('+'.$i.' year')); ?>"><?php echo date('y', strtotime('+'.$i.' year')); ?></option>
													<?php } ?>
												</select>
												<label id="UserYear-error" class="error" for="UserYear"></label>
											</div>
										</div>
									</div>
								</div>
							</div>
							
                            <div class="form-group custom_form">
								<div class="cols-sm-10">
									<div class="input-group">
										<input type="text" class="form-control required card-cvc" data-stripe="cvc" id="Cvv_Number" name="Cvv_Number"  placeholder="CVV Number"/>
										 <span class="input-group-addon"><i class="fa fa-cc" aria-hidden="true"></i></span> 
									</div>
									<input type='hidden' name='stripeToken' id="stripeToken" value='' />
									<label class="error" id="Cvv_Number-error" for="Cvv_Number"></label>
								</div>
							</div>
							
							<div class="form-group custom_form ">
							    <div class="cols-sm-10">
									<div class="input-group">
								<button type="button" onclick="setp_1()" class="btn  btn-lg btn-block form-submit-btn submit-button">Pay and Confirm Order</button>
								<div class="loader hide signup_loader"></div>
								</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="panel-heading_custom">
	               <div class="panel-title text-center">
	               		Already have an account? <a href="<?php echo base_url('login'); ?>"><span class="red_font">Login </span></a>
	               	</div>
	            </div>
			</div>
		</div>
	</div>
<?php get_footer();?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- <script src="<?php// echo base_url('assets/js/custom/common.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/additional-methods.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>"></script>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script>
	 Stripe.setPublishableKey('<?php echo $this->config->item('PUBLISHABLE_KEY'); ?>');
	function stripeResponseHandler(status, response)
 	{
        if (response.error) {
        	if(response.error.param=='number'){
        		$('#Credit_Card_Number-error').text(response.error.message).css('visibility','visible');
        	}
        	else{
        		$('#Credit_Card_Number-error').text('').css('visibility','hidden');
        	}
        	if(response.error.param=='exp_year'){
        		$('#UserYear-error').text(response.error.message).css('visibility','visible');
        	}
        	else{
        		$('#UserYear-error').text('').css('visibility','hidden');
        	}
        	if(response.error.param=='exp_month'){
        		$('#UserMonth-error').text(response.error.message).css('visibility','visible');
        	}
        	else{
        		$('#UserMonth-error').text('').css('visibility','hidden');
        	}
        	if(response.error.param=='cvc'){
        		$('#Cvv_Number-error').text(response.error.message).css('visibility','visible');
        	}
        	else{
        		$('#Cvv_Number-error').text('').css('visibility','hidden');
        	}
        	if(response.error.param!='number' && response.error.param!='cvc' && response.error.param!='exp_month' && response.error.param!='exp_year')
        	{
        		alert(response.error.message);
        	}
            // re-enable the submit button
            $('.submit-button').removeAttr("disabled");
            $(".loader").addClass("hide");
            // show the errors on the form
            $(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#register_validate_form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $('#stripeToken').val(token);
            // and submit
        	var forms = $('#register_validate_form')[0]; // You need to use standard javascript object here
			var formData = new FormData(forms);
            $.ajax({
				url: '<?php echo base_url('register/save'); ?>',
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData:false,
				contentType: false,
				cache :false,
				success:function(data)
				{	
					$("html, body").animate({ scrollTop: 0 }, "slow");
					if(data['status'])
					{	
						window.location.href="<?php echo base_url('register/otp?email='); ?>"+data['user_email'];
					}
					else
					{
						$('#second_step').hide(500);	
						$('#first_steps').show(500);	
						$("#successMsg").addClass("hide");
						$("#errorMsg").removeClass("hide").html(data['msg']);
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
				$('.submit-button').removeAttr("disabled");
				$(".loader").addClass("hide");
				console.log("complete");
			});
        }
    }
	 
	$.validator.addMethod(
        "expiry_date",
        function (value, element) {
		    var today = new Date();
		    var thisYear = today.getFullYear();
		    var expMonth = +value.substr(0, 2);
		    var expYear = +value.substr(3, 4);

		    return (expMonth >= 1 
		            && expMonth <= 12
		            && (expYear >= thisYear && expYear < thisYear + 20)
		            && (expYear == thisYear ? expMonth >= (today.getMonth() + 1) : true))
		},
        "Must be a valid Expiry Date"
        );
	var form = $( "#register_validate_form" );
	form.validate(
	{
		focusInvalid: false,
		invalidHandler: function(form, validator) {
        
        if (!validator.numberOfInvalids())
            return;
        var top_to_list = parseFloat($(validator.errorList[0].element).offset().top)-150;
        $('html, body').animate({
            scrollTop:top_to_list
        }, 1000);
        
    },
		rules:
        {
        	User_First_Name:"required",
        	User_Last_Name:"required",
        	// User_Franchise_Name:"required",
        	User_Buisness_Address:"required",
        	// Time_Period_Franchise:"required",
        	User_Phone: {
        		required: true,
        	    number: true,
        	},
        	User_Password:
        	{
        		required:true,
        		minlength: 6,
			},
		    User_Password_Confirm: {
		    	minlength: 6,
		      equalTo: "#User_Password"
		    },
            User_Email:
            {
                required: true,
        	    email: true,
                remote:
                {
                    url: '<?php echo base_url('login/email_check'); ?>',
                    type: "post",
                    data:
                    {
                        User_Email: function()
                        {
                            return $('#register_validate_form :input[name="User_Email"]').val();
                        }
                    }
                }
            },
            Username:
            {
            	minlength: 6,
                required: true,
                remote:
                {
                    url: '<?php echo base_url('login/username_check'); ?>',
                    type: "post",
                    data:
                    {
                        Username: function()
                        {
                            return $('#register_validate_form :input[name="Username"]').val();
                        }
                    }
                }
            },
            Monthly_Subscription:"required",
            Credit_Card_Number:
        	{
        		required:true,
        		//creditcard: true
        	},
        	// Expiry_Date:
        	// {
        	// 	required:true,
        	// 	expiry_date:true,
        	// },
        },
        messages:
        {
        	User_First_Name:
        	{
        		required: "Please enter your first name and try again"
        	},
        	User_Last_Name:
        	{
        		required: "Please enter your last name and try again"
        	},
        	// User_Franchise_Name:
        	// {
        	// 	required: "Please enter your email franchise to proceed further"
        	// },
        	User_Buisness_Address:
        	{
        		required: "Please enter your business address and try again"
        	},
        	// Time_Period_Franchise:
        	// {
        	// 	required: "Please enter your time period of Franchise Ownership and try again"
        	// },
        	User_Phone:
        	{
        		required: "Please enter your Phone Number and try again",
        		number: "Your Phone Number is invalid , Please try again"
        	},
        	Username:
            {
            	minlength:"Username should be minimum 6 character long",
            	required:"Please enter your Username and try again",
                remote: jQuery.validator.format("The username {0} is already taken.")
            },
            User_Email:
            {
            	required:"Please enter your Email Address and try again",
            	email :"Your Email Address is invalid , Please try again",
                remote: jQuery.validator.format("The email {0} is already taken.")
            },
            User_Password:
            {
            	required:"Please enter your password to proceed further",
            	minlength:"Password should be minimum 6 character long"
            },
            User_Password_Confirm:
            {
            	required:"Please enter your password to proceed further",
            	equalTo: "It seems your confirm password does not relate to the password you entered before , Please try again",
            	minlength:"Confirm password should be minimum 6 character long"
            },
            Monthly_Subscription:
            {
            	required:"Please select your Package to proceed further"
            },
             Credit_Card_Number:
        	{
        		required:"Please enter your Credit Card number.",
        	},
        	// Expiry_Date:
        	// {
        	// 	required:"Please enter your Credit Card expiry date.",
        	// 	expiry_date:"Please enter a valid expiry date"
        	// },
        	Cvv_Number:
        	{
        		required:"Please enter your Credit Card CVV number.",
        	},
        	terms:
        	{
        		required:"Please accept terms and conditions to continue.",
        	}
        }
	});
	function setp_2(){
		if(form.valid())
		{
			if($('#User_Zip_Code').val()=='')
			{
				$('#User_Zip_Code-error').text('Please enter your Zip Codes You Service and try again').css('visibility','visible');
			}	
			else
			{
				$('#User_Zip_Code-error').text('').css('visibility','hidden');
				$('#second_step').show('fast',function(){
					$('#first_steps').hide('fast',function(){
						var top_lo =  parseFloat($("#second_step").offset().top)-400;
						$('html, body').animate({
						        scrollTop:top_lo
						    }, 100);
					});	
				});
			}
		}
		else
		{
			if($('#User_Zip_Code').val()=='')
			{
				$('#User_Zip_Code-error').text('Please enter your Zip Codes You Service and try again').css('visibility','visible');
			}	
			else
			{
				$('#User_Zip_Code-error').text('').css('visibility','hidden');
			}
		}
	}
	function setp_1(){
		if(form.valid()){
			$(".loader").removeClass("hide");
			$('.submit-button').attr("disabled", "disabled");
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month option:selected').val(),
                exp_year: $('.card-expiry-year option:selected').val()
            }, stripeResponseHandler);
            return false; // submit from callback
		}
	}
	$('#User_Zip_Code').tagsinput({
		confirmKeys: [13, 32, 44],cancelConfirmKeysOnEmpty: false, trimValue: true,
		onTagExists: function(item, $tag) {
			console.log("adsfaf");
		    $tag.hide().fadeIn();
		}
	});
	 if ($('#User_Zip_Code').length > 0)
    {
        $('#User_Zip_Code').tagsinput('input').attr('id', 'tags_input_validd');
    }
    // called when key is pressed in textbox
	$('#tags_input_validd').blur(function(){
	 	$('#User_Zip_Code').tagsinput('add',$(this).val());
	 	$(this).val('');
	});
</script>

