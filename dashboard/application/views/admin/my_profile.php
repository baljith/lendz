<style>
	.bootstrap-tagsinput input {
    height: 46px;
}
.bootstrap-tagsinput {
    max-height: 52px;
    overflow: auto;
    }
</style>
<link rel="stylesheet" href="../dashboard/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">  
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers">My Profile</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active">My Profile</li>
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
						<h3>personal information</h3>
					</div><!-- col-xs-12 col-sm-12 col-md-12 col-lg-12 -->
					<div class="panel-form-start">
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>First Name</label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="firstname" name="User_First_Name" value="<?php echo $user_data['User_First_Name']; ?>" required>
							 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_First_Name"></span>

							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>Last Name</label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_First_Name" name="User_Last_Name" value="<?php echo $user_data['User_Last_Name']; ?>" required>
							 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_First_Name"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>Franchise Name</label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_Franchise_Name" value="<?php echo $user_data['User_Franchise_Name']; ?>" name="User_Franchise_Name" >
							 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Franchise_Name"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Street Address</label>
							 		<div class="input-group">
							 			<textarea  id="" class="form-control"  name="User_Buisness_Address" required style="resize: none;height: 54px;"><?php echo $user_data['User_Buisness_Address']; ?></textarea>
										<span class="custom-input-addon"><i class="fa fa-address-custom"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Buisness_Address"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->				
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							 	<div class="form-group">
									<label>Zip Code</label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_Zip_Code" value="<?php echo $user_data['User_Zip_Code']; ?>" name="User_Zip_Code" required>
							 			<!-- <span class="custom-input-addon"><i class="fa fa-zip-custom"></i></span> -->
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Zip_Code"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
							
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							 	<div class="form-group">
									<label>Phone Number</label>
							 		<div class="input-group">
										<input type="text" class="form-control" data-rule-number="true" id="User_Phone" value="<?php echo $user_data['User_Phone']; ?>" name="User_Phone" required>
							 			<span class="custom-input-addon"><i class="fa fa-phone-custom"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Phone"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							 	<div class="form-group">
									<label>Time Period Franchiser</label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="Time_Period_Franchise" value="<?php echo $user_data['Time_Period_Franchise']; ?>" name="Time_Period_Franchise" >
							 			<span class="custom-input-addon"><i class="fa fa-phone-custom"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="Time_Period_Franchise"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
							<div class="forUpload">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<label class="formLabels">Upload Your Profile Photo</label>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profilepic_main">
											<div class="Upload_separator">OR</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5 pro_container">
													<div class="profimg_wrapper">
														<!-- <span class="fa fa-camera cam_icon"></span> -->
														<?php 
															if($this->session->userdata('User_Image'))
															{
																$image = base_url('assets/upload/profile_pictures/'.$this->session->userdata('User_Image'));
															}
															else
															{
																$image = base_url('assets/dummy/no-user.png');
															}
															?>
														<div class="profilepic_container">		
															<img src="<?php echo $image; ?>" alt="" class="profile_img">
														</div>
													</div>
												</div>
												<div class="col-lg-8 col-md-7 col-sm-7 col-xs-7 pro_container">
													<div class="profpic_btncontainer">
														<span class="profile_upload">Choose a file</span>
														<span class="profileup_desc">PNG, JPG or GIF, max. 3MB</span>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 drag_section">
												<div class="dragdrop_container">
													<i class="fa fa-cloud-download fa-4x"></i>
													<h4>Drag &amp; Drop File</h4>
													<input type="file" class="profile_pic_cls" name="profile_pic" id="profile_pic">
												</div>
											</div>
										</div>											
									</div>		
									<label id="profile_pic-error" class="error" for="profile_pic"></label>												
								</div>
							<div class="clearfix"></div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
								<h3>Change Password</h3>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>Current Password <span>*</span></label>
							 		<div class="input-group">
										<input type="password" name="Current_Password" id="Current_Password" class="form-control" placeholder="Enter current password">
							 			<span class="custom-input-addon"><i class="fa fa-pw"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="Current_Password"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>New Password <span>*</span></label>
							 		<div class="input-group">
										<input type="password" name="New_Password" id="New_Password" class="form-control" placeholder="Choose a new password">
							 			<span class="custom-input-addon"><i class="fa fa-pw"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="New_Password"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
								<div class="form-group">
									<label>Confirm New Password <span>*</span></label>
							 		<div class="input-group">
										<input type="password" name="Confirm_Password" id="Confirm_Password" class="form-control" placeholder="Confirm new password">
							 			<span class="custom-input-addon"><i class="fa fa-cpw"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="Confirm_Password"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
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
</div>


 
<!-- Jquery validate plugins files -->
<script src="../dashboard/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../dashboard/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- TagsInput Plugins files -->
<script src="../dashboard/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script>

	
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
		submitHandler: function(){
        	$(".loader").removeClass("hide");
			var forms 	= $('#register_validate_form')[0]; // You need to use standard javascript object here
			var formData = new FormData(forms);
			$.ajax({
				url: '<?php echo base_url('profile/update_profile'); ?>',
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData:false,
				cache :false,
				contentType: false,
				success:function(data)
				{	
					$("html, body").animate({ scrollTop: 0 }, "slow");
					if(data['status']){
						msg_div(data['status'], data['msg']);
					}else{
						msg_div(data['status'], data['msg']);
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
	}
	
	

</script>