
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

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>First Name<span>*</span></label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_First_Name" name="User_First_Name" value="<?php echo $user_data['User_First_Name']; ?>" required>
							 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
							 		</div>
							 		<span class="error" for="User_First_Name"></span>
							 	</div>
							</div>
							 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Last Name<span>*</span></label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_Last_Name" name="User_Last_Name" value="<?php echo $user_data['User_Last_Name']; ?>" required>
							 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
							 		</div>
							 		<span class="error" for="User_Last_Name"></span>
							 	</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Email Address<span>*</span></label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_Email" value="<?php echo $user_data['User_Email']; ?>" name="User_Email" required>
							 			<span class="custom-input-addon"><i class="fa fa-address-custom"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Email"></span>
							 	</div><!-- form-group -->
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							 	<div class="form-group">
									<label>Phone Number<span>*</span></label>
							 		<div class="input-group">
										<input type="text" class="form-control" id="User_Phone" data-rule-number="true" value="<?php echo $user_data['User_Phone']; ?>" name="User_Phone" required>
							 			<span class="custom-input-addon"><i class="fa fa-phone-custom"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="User_Phone"></span>
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