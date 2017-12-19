		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class=""><a href="<?php echo base_url('category'); ?>">Catgories list</a></li>
				<li class="active"><?php echo (!empty($category_id))?'Edit':'Add'; ?> Category</li>
			</ol>
			<h1 class="page-header"><?php echo (!empty($category_id))?'Edit':'Add'; ?> Category</small></h1>
			<div class="row">
				<form action="/" method="POST" id="add_category_form" enctype='multipart/form-data'>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-inverse">
	                        <div class="panel-body">
	                            <fieldset>
	                            <div class="col-md-12">
                                    <legend><?php echo (!empty($category_id))?'Edit':'Add'; ?> Category</legend>
	                            </div>
                                    <div class="col-md-4 col-m-4 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Category Name <span style="color: red;">*</span></label>
											<?php 
											if(!empty($category_id))
											{
													?>
													<input type="hidden" class="form-control input-lg required" id="Catefory_Id" name="Id"  value="<?php echo (!empty($category_id))?$category_id:''; ?>" placeholder="Enter name">
													<?php
											}
											?>
	                                        <input type="text" class="form-control input-lg required" id="Category_Name" name="Name" placeholder="Enter Category Name" value="<?php echo (!empty($category_id))?$category_detail['Name']:''; ?>" maxlenght="50">
	                                        <label for="Category_Name" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-8 col-m-8 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Category_Name">Category Description <span style="color: red;">*</span></label>
	                                        <input type="text" class="form-control input-lg required" id="Category_Description" name="Description" placeholder="Enter Category Description" value="<?php echo (!empty($category_id))?$category_detail['Description']:''; ?>" maxlenght="255">
	                                        <label for="Category_description" class="error"></label>
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
						<button type="submit" class="btn btn-lg btn-info m-r-5">Save</button>
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			var id="<?php echo (!empty($category_id))?$category_id:''; ?>";
		</script>