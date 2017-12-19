<link rel="stylesheet" href="../dashboard/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">  
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers">My Profile</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="">My Profile</li>
					<li class="active">Payment Info</li>
				</ol>
		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
		
		</div>
	</div>
	
</div>
<hr class="horizental_line">
<div class="clear-fix"></div>
<div id="content" class="content">
	<form class="custom_form_style" method="post" action="#" id="register_validate_form">
		<div class="row" id="usersList">
			<div class="panel">
				<div class="panel-start">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h3>Update Payment information</h3>
					</div><!-- col-xs-12 col-sm-12 col-md-12 col-lg-12 -->
					<div class="panel-form-start">
						
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Credit card number</label>
							 		<div class="input-group">
										<input type="text" class="form-control card-number" id="Credit_Card_Number" name="Credit_Card_Number" value="" required placeholder="0000 0000 0000 0000">
							 			<span class="custom-input-addon"><i class="fa fa-credit-card"></i></span>
							 		</div>
							 		<label class="error" style="    color: red;
    visibility: visible;
    display: block;
    bottom: 4px;
    left: 16px;"  id="Credit_Card_Number-error" for="card_number"></label>

							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>CVV</label>
									<div class="input-group">
							 		<input type="text" class="form-control required card-cvc" data-stripe="cvc" id="Cvv_Number" name="Cvv_Number"  placeholder="CVV Number"/>
							 		<span class="custom-input-addon"><i class="fa fa-credit-card"></i></span>
							 		<label class="error" style="    color: red;
    visibility: visible;
    display: block;
    bottom: 4px;
    left: 16px;" for="User_Buisness_Address"></label>
							 	</div>
							 	</div><!-- form-group -->
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Expiry Month</label>
							 		<div class="input-group">
										<select class="form-control required  card-expiry-month"  style="width:100%!important;height: 54px;" data-width="100%" data-size="12">
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
										<span class="custom-input-addon" style="z-index: 1000; background: white; height: 52px; "><i class="fa fa-angle-down"></i></span>
									</div>
									<label id="UserMonth-error" class="error" for="UserMonth"></label>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Expiry Year</label>
							 		<div class="input-group">
												<select class="form-control required card-expiry-year" style="width:100%!important;height: 54px;" data-size="12" data-width="100%">
													<option value="">Select Year</option>
													<option value="<?php echo date('y'); ?>">
														<?php echo date('y'); ?>
													</option>
													<?php 
													for($i=1;$i<=10;$i++) {
													?>
													<option value="<?php echo date('y', strtotime('+'.$i.' year')); ?>"><?php echo date('y', strtotime('+'.$i.' year')); ?></option>
													<?php } ?>
												</select>
												<span class="custom-input-addon" style="z-index: 1000; background: white; height: 52px; "><i class="fa fa-angle-down"></i></span>
												<label id="UserYear-error" class="error" for="UserYear"></label> </div>
							 	</div>
							</div>
							<input type="hidden" name="stripeToken" id="stripeToken">
						<div class="clearfix"></div>
					</div><!-- panel-form-start -->
				</div><!-- panel-start -->
			</div><!-- panel -->
	    </div>
    	<div class="col-md-12 text-center m-t-10 m-b-20">
	    	<div class="save-btn">
				<button type="submit" class="btn custom-btn">save changes</button>
			</div>
	    </div>
    </form>

<div class="clearfix"></div>


    <form class="custom_form_style" method="post" action="#" id="change_plan_form">
		<div class="row" id="usersList">
			<div class="panel">
				<div class="panel-start">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h3>Change Membership Plan</h3>
					</div><!-- col-xs-12 col-sm-12 col-md-12 col-lg-12 -->
					<div class="panel-form-start">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Current Package</label>
								<?php 
								if(!empty($plan))
								{
									?>
							 		<ol class="list-group">
							 			<li class="list-group-item"><span style="font-size: 13px; font-weight: 700; margin-right: 11px;">Package Name: </span><?php echo @$plan['package']['Package_Name']; ?></li> <li class="list-group-item"><span style="    font-size: 13px;font-weight: 700; margin-right: 11px;">Package Price ($): </span><?php echo @$plan['package']['Package_Price']; ?></li> <li class="list-group-item"><span style="font-size: 13px; font-weight: 700; margin-right: 11px;">Renewal Date: </span> <?php if($plan['Status']=='0') {
							 				if(!empty($plan['End_At'])){
							 				echo date('d,M Y',@$plan['End_At']); }else{ echo "-"; }
							 			}else{ echo "-"; } ?></li>
							 		</ol>
							 		<?php 
							 		if($plan['Status']=='0')
							 		{
							 			$susb = str_replace(' ', '_', '"Do you want to cancel membership plan"');
	               							echo '<button title="Cancel subscription" onclick=cancel_subs(' . $susb . ',"' . $plan['Subs_Id'] . '",this) style="margin-right: 10px;padding: 8px 12px;" type="button" class="btn btn-sm btn-danger">Cancel Membership plan
	                        					</button>';
							 		}
						 		}
						 		else
						 		{
						 			?>
						 			No Package 
						 			<?php
						 		}
						 		?>
							</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Select Package</label>
						 		<div class="input-group">
									<select class="form-control Plan_Id required" name="Plan_Id" id="Plan_Id"  style="width:100%!important;height: 54px;" data-width="100%" data-size="12">
										<option value="">Select Package</option>
										<?php 
										if(!empty($packages)){
											foreach($packages as $pack)
											{
												if($plan['Plan_Id']==$pack['Package_Id']){
													continue;
												}
												?>
												<option value="<?php echo $pack['Package_Id']; ?>"><?php echo $pack['Package_Name']." ($".$pack['Package_Price']." )"; ?></option>
												<?php
											}
										}
										?>
									</select>
									<span class="custom-input-addon" style="z-index: 1000; background: white; height: 52px; "><i class="fa fa-angle-down"></i></span>
								</div>
								<label id="Plan_Id-error" class="error" for="Plan_Id"></label>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
						<div class="clearfix"></div>
					</div><!-- >panel-form-start -->
				</div><!-- panel-start -->
			</div><!-- panel -->
	    </div>
	<div class="col-md-12 text-center m-t-10 m-b-20">
	    	<div class="save-btn">
				<button type="submit" class="btn custom-btn">Change Plan</button>
			</div>
	    </div>
</form>
</div>


 
<!-- Jquery validate plugins files -->
<script src="../dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../dashboard/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- TagsInput Plugins files -->
<script src="../dashboard/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
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
        		msg_div(false, response.error.message);
        	}


            // re-enable the submit button
            $('.submit-button').removeAttr("disabled");
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
				url: '<?php echo base_url('profile/update_payment'); ?>',
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData:false,
				contentType: false,
				cache :false,
				success:function(data)
				{	
					msg_div(data.status, data.msg);
					$("html, body").animate({ scrollTop: 0 }, "slow");
					if(data['status'])
					{	
						forms.reset();
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
	
	window.onload = function()
	{
		$('#User_Zip_Code').tagsinput({
		confirmKeys: [13, 32, 44],cancelConfirmKeysOnEmpty: false, trimValue: true,
		onTagExists: function(item, $tag) {
			console.log("adsfaf");
		    $tag.hide().fadeIn();
		}
	});
		var form = $( "#register_validate_form");
		form.validate({
			rules:
        	{
	        	Credit_Card_Number:"required",
	        	Cvv_Number:"required",
        	},
        	messages:
	        {
	        	Credit_Card_Number:
	        	{
	        		required: "Please enter your credit card number and try again"
	        	},
	        	Cvv_Number:
	        	{
	        		required: "Please enter your cvv number and try again"
	        	}
	        },
			submitHandler: function(){
	        	$(".loader").removeClass("hide");
				var forms 	= $('#register_validate_form')[0]; // You need to use standard javascript object here
				var formData = new FormData(forms);
	            // createToken returns immediately - the supplied callback submits the form if 
	            Stripe.createToken({
	                number: $('.card-number').val(),
	                cvc: $('.card-cvc').val(),
	                exp_month: $('.card-expiry-month option:selected').val(),
	                exp_year: $('.card-expiry-year option:selected').val()
	            }, stripeResponseHandler);
	            return false; // submit from callback
	        }
		});	


		//Update Plan info
		var change_plan_form = $( "#change_plan_form");
		change_plan_form.validate({
			rules:
        	{
	        	Plan_Id:"required",
        	},
        	messages:
	        {
	        	Plan_Id:
	        	{
	        		required: "Please select a plan first and try again"
	        	}
	        },
			submitHandler: function(){
	        	$(".loader").removeClass("hide");
	        	$('#change_plan_form').find('button').attr('disabled','disabled');
				var change_plan_form 	= $('#change_plan_form')[0]; // You need to use standard javascript object here
				var formData = new FormData(change_plan_form);
	            $.ajax({
					url: '<?php echo base_url('profile/change_plan'); ?>',
					type: 'POST',
					dataType: 'json',
					data: formData,
					processData:false,
					contentType: false,
					cache :false,
					success:function(data)
					{	
						$('#change_plan_form').find('button').removeAttr('disabled');
						msg_div(data.status, data.msg);
						$("html, body").animate({ scrollTop: 0 }, "slow");
						if(data['status'])
						{	
							window.location.reload();
						}
					}
				});
	        }
		});
	}

function cancel_subs(msg,id, obj)
{
    msgs = msg.replace(/_/g, ' ');
    $.confirm(
    {
        title: 'Confirm!',
        content: msgs,
        buttons:
        {
            confirm:
            {
                keys: ['enter'],
                btnClass: 'btn-confirm',
                action: function()
                {
                    if (id != '')
                    {
                        $.post(ajax_url + 'transactions/cancel_subs',
                        {
                            'id': id,
                        }, function(data, textStatus, xhr)
                        {
                            msg_div(data.status, data.msg);
                            if (data.status)
                            {
                                $(obj).remove();
                                window.location.reload();
                            }
                        });
                    }
                    else
                    {
                        msg_div(false, 'Invalid argument');
                    }
                },
            },
            cancel:
            {
                keys: ['esc'],
                btnClass: 'btn-cancel',
            }
        }
    });
}
	
	

</script>