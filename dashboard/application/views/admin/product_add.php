		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class=""><a href="<?php echo base_url('product'); ?>">Product list</a></li>
				<li class="active"><?php echo (!empty($product_id))?'Edit':'Add'; ?> Product</li>
			</ol>
			<h1 class="page-header"><?php echo (!empty($product_id))?'Edit':'Add'; ?> Product</small></h1>
			<div class="row">
				<form action="/" method="POST" id="add_category_form" enctype='multipart/form-data'>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-inverse">
	                        <div class="panel-body">
	                            <fieldset>
	                            <div class="col-md-12">
                                    <legend><?php echo (!empty($product_id))?'Edit':'Add'; ?> Product</legend>
	                            </div>
                                    <div class="col-md-6 col-m-6 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Product Name <span style="color: red;">*</span></label>
											<?php 
											if(!empty($product_id))
											{
													?>
													<input type="hidden" class="form-control input-lg required" id="Product_Id" name="Id"  value="<?php echo (!empty($product_id))?$product_id:''; ?>" >
													<?php
											}
											?>
	                                        <input type="text" class="form-control input-lg required" id="Product_Name" name="Product_Name" placeholder="Enter Produuct Name" value="<?php echo (!empty($product_id))?$product_detail['Product_Name']:''; ?>" maxlength="200">
	                                        <label for="Product_Name" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-6 col-m-6 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Product Price <span style="color: red;">*</span></label>
	                                        <input type="text" class="form-control input-lg required" id="Product_Price" name="Product_Price" placeholder="Enter Product Price" value="<?php echo (!empty($product_id))?$product_detail['Product_Price']:''; ?>" maxlength="8">
	                                        <label for="Product_Price" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-6 col-m-6 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">User Name <span style="color: red;">*</span></label>
	                                        <!-- <input type="text" class="form-control input-lg required" id="Product_Name" name="Product_Name" placeholder="Enter Produuct Name" value="<?php echo (!empty($product_id))?$product_detail['Product_Name']:''; ?>" maxlength="200"> -->
	                                        <select class="form-control input-lg required" name="User_Id">
	                                        	<option value="">Select Username</option>
	                                        	<?php if(isset($user_list) && !empty($user_list)) { 
	                                        		foreach ($user_list as $list) {
	                                        		?>
	                                        			<option value="<?php echo $list['User_Id']; ?>" <?php if(isset($product_detail['User_Id']) && !empty($product_detail['User_Id'])) { if($product_detail['User_Id'] == $list['User_Id']){  echo 'selected'; } } ?> ><?php echo $list['Username'] ?></option>
	                                        	<?php } } ?>
	                                        </select>
	                                        <label for="User_Id" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-6 col-m-6 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Product Category <span style="color: red;">*</span></label>
	                                        <!-- <input type="text" class="form-control input-lg required" id="Product_Price" name="Product_Price" placeholder="Enter Product Price" value="<?php echo (!empty($product_id))?$product_detail['Product_Price']:''; ?>" maxlength="8"> -->
	                                        <select class="form-control input-lg required" name="Category_Id">
	                                        	<option value="">Select Product Category</option>
	                                        	<?php if(isset($category_list) && !empty($category_list)) { 
	                                        		foreach ($category_list as $cat) {
	                                        		?>
	                                        			<option value="<?php echo $cat['Id']; ?>" <?php if(isset($product_detail['Category_Id']) && !empty($product_detail['Category_Id'])) { if($product_detail['Category_Id'] == $cat['Id']){  echo 'selected'; } } ?> ><?php echo $cat['Name'] ?></option>
	                                        	<?php } } ?>
	                                        </select>
	                                        <label for="Category_Id" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-12 col-m-12 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Product Description <span style="color: red;">*</span></label>
	                                        <!-- <input type="text" class="form-control input-lg required" id="Product_Price" name="Product_Price" placeholder="Enter Product Price" value="<?php echo (!empty($product_id))?$product_detail['Product_Price']:''; ?>" maxlength="8"> -->
	                                        <textarea class="form-control input-lg required" rows="4" placeholder="Enter Product Description" name="Product_Description"><?php if(isset($product_detail['Product_Description']) && !empty($product_detail['Product_Description'])) { echo $product_detail['Product_Description']; } ?></textarea>
	                                        <label for="Product_Description" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="forUpload">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<label class="formLabels">Upload Your Profile Photo <span style="color: red;">*</span></label>
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profilepic_main">
												<div class="Upload_separator">OR</div>
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<div class="col-lg-4 col-md-5 col-sm-5 col-xs-5 pro_container">
														<div class="profimg_wrapper">
															<!-- <span class="fa fa-camera cam_icon"></span> -->
															<?php 
																if($category_detail['Image'])
																{
																	$image = base_url('assets/upload/category_img/'.$category_detail['Image']);
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
                                </fieldset>
	                        </div>
	                    </div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 text-center m-t-20">
						<button type="submit" class="btn btn-lg btn-info m-r-5">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			var id="<?php echo (!empty($category_id))?$category_id:''; ?>";
		</script>