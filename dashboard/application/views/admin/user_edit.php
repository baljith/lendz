<style>
	.bootstrap-tagsinput input {
    height: 46px;
}
.bootstrap-tagsinput {
    max-height: 52px;
    overflow: auto;
    }
</style>
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers">Edit <?php echo get_role_name($user['Role']); ?></span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active">Edit <?php echo get_role_name($user['Role']); ?></li>
				</ol>
		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
		
		</div>
	</div>
	
</div>
<hr class="horizental_line">
<div class="clear-fix"></div>
<div id="content" class="content">
	<form id="User_Edit" class="forms" method="post" action="">
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
									<input type="text" class="form-control required" name="User_First_Name" id="User_First_Name" value="<?php echo @$user['User_First_Name']; ?>">
									<input type="hidden" class="form-control required" name="User_Id" id="User_Id" value="<?php echo @$user['User_Id']; ?>">
						 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="User_First_Name"></span>
						 	</div><!-- form-group -->

						</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Last Name</label>
						 		<div class="input-group">
									<input type="text" class="form-control required" name="User_Last_Name" id="User_Last_Name" value="<?php echo @$user['User_Last_Name']; ?>">
						 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Last_Name"></span>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
							<div class="form-group">
								<label><?php 
									if($user['Role']==1){ echo "Shop "; }else if($user['Role']==2){ echo "Business "; }else{ echo "Franchise"; }
								?> Name</label>
						 		<div class="input-group">
									<input type="text" class="form-control" name="User_Franchise_Name" id="User_Franchise_Name" value="<?php echo @$user['User_Franchise_Name']; ?>">
						 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Franchise_Name"></span>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-4 col-lg-4 -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>
								<?php 
									if($user['Role']==1){ echo "Shop Address"; }else{ echo "Business Address"; }
								?></label>
						 		<div class="input-group">
									<!-- <input type="text" class="form-control required" name="User_Buisness_Address" id="User_Buisness_Address" value="<?php echo @$user['User_Buisness_Address']; ?>"> -->

									<textarea  id="" class="form-control" rows="3" name="User_Buisness_Address" required style="resize: none;height: 54px;"><?php echo $user['User_Buisness_Address']; ?></textarea>

						 			<span class="custom-input-addon"><i class="fa fa-address-custom"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Buisness_Address"></span>
						 	</div><!-- form-group -->
						</div>					
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						 	<div class="form-group">
								<label>Zip Code</label>
						 		<div class="input-group">
									<input type="text" class="form-control required" name="User_Zip_Code" id="User_Zip_Code" value="<?php echo @$user['User_Zip_Code']; ?>">
						 			<!-- <span class="custom-input-addon"><i class="fa fa-zip-custom"></i></span> -->
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Zip_Code"></span>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
						<?php 
						if($user['Role']==3)
						{
							?>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label>Time Period of Franchise Ownership</label>
							 		<div class="input-group">
										<input type="text" class="form-control " name="Time_Period_Franchise" id="Time_Period_Franchise" value="<?php echo @$user['Time_Period_Franchise']; ?>">
							 			<span class="custom-input-addon"><i class="fa fa-angle-down"></i></span>
							 		</div><!-- input-group -->
							 		<span class="error" for="Time_Period_Franchise"></span>
							 	</div><!-- form-group -->
							</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
						<?php
						}
						?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						 	<div class="form-group">
								<label>Phone Number</label>
						 		<div class="input-group">
									<input type="text" class="form-control required" name="User_Phone" data-rule-number="true" id="User_Phone" value="<?php echo @$user['User_Phone']; ?>">
						 			<span class="custom-input-addon"><i class="fa fa-phone-custom"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Phone"></span>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Email Address</label>
						 		<div class="input-group">
									<input type="text" name="User_Email" class="form-control" readonly id="User_Email" value="<?php echo @$user['User_Email']; ?>" required>
						 			<span class="custom-input-addon"><i class="fa fa-envelope-o"></i></span> 
						 		</div><!-- input-group -->
						 		<span class="error" for="User_Email"></span>
						 	</div><!-- form-group -->
						</div><!-- col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Username</label>
						 		<div class="input-group">
									<input type="text" name="Username" class="form-control" id="Username" value="<?php echo @$user['Username']; ?>" readonly>
						 			<span class="custom-input-addon"><i class="fa fa-user-o"></i></span>
						 		</div><!-- input-group -->
						 		<span class="error" for="Username"></span>
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
															if(!empty($user['User_Image']))
															{
																$image = base_url('assets/upload/profile_pictures/'.$user['User_Image']);
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
					
				</div><!-- panel-form-start -->
			</div><!-- panel-start -->
			<hr class="horizental_line">
			
		</div><!-- panel -->
		<div class="save-btn">
			<button type="submit" class="btn custom-btn">save changes</button>
		</div>
    </div>
    </form>
</div>
<?php 
if($user['Role']==3)
{
	?>
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
	}
	</script>
	<?php
}
?>
