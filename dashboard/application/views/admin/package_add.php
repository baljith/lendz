		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class=""><a href="<?php echo base_url('packages'); ?>">Packages list</a></li>
				<li class="active"><?php echo (!empty($Package_Id))?'Edit':'Add'; ?> Package</li>
			</ol>
			<h1 class="page-header"><?php echo (!empty($Package_Id))?'Edit':'Add'; ?> Package</small></h1>
			<div class="row">
				<form action="/" method="POST" id="add_package_form">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-inverse">
	                        <div class="panel-body">
	                            <fieldset>
	                            <div class="col-md-12">
                                    <legend><?php echo (!empty($Package_Id))?'Edit':'Add'; ?> Package</legend>
	                            </div>
                                    <div class="col-md-4 col-m-4 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Package_Name">Package Name</label>
											<?php 
											if(!empty($Package_Id))
											{
													?>
													<input type="hidden" class="form-control input-lg required" id="Package_Id" name="Package_Id"  value="<?php echo (!empty($Package_Id))?$Package_Id:''; ?>" placeholder="Enter name">
													<?php
											}
											?>
	                                        <input type="text" class="form-control input-lg required" id="Package_Name" name="Package_Name" placeholder="Enter name" value="<?php echo (!empty($Package_Id))?$Package_details['Package_Name']:''; ?>">
	                                        <label for="Package_Name" class="error"></label>
                                    	</div>
                                    </div>
                                    <?php 
                                    	if(empty($Package_Id)){
                                    ?>
                                    <div class="col-md-4 col-m-4 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Package_Price">Package Price</label>
	                                        <input type="text" class="form-control check_price input-lg required" id="Package_Price" name="Package_Price" placeholder="Enter price" value="<?php echo (!empty($Package_Id))?$Package_details['Package_Price']:''; ?>">
	                                         <label for="Package_Price" class="error"></label>
                                    	</div>
                                    </div>
                                    <div class="col-md-4 col-m-4 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Package_Period">Package Period (in months)</label>
	                                        <input type="text" class="form-control check_numeric input-lg required" id="Package_Period" name="Package_Period" placeholder="Enter period" value="<?php echo (!empty($Package_Id))?$Package_details['Package_Period']:''; ?>">
	                                         <label for="Package_Period" class="error"></label>
                                    	</div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-12 col-m-12 col-xs-12">
                                    	<div class="form-group">
	                                        <label for="Package_Description">Package Description</label>
	                                         <textarea class="Package_Description required" id="Package_Description" name="Package_Description" rows="20"><?php echo (!empty($Package_Id))?$Package_details['Package_Description']:''; ?></textarea>
	                                         <label for="Package_Description" class="error"></label>
                                    	</div>
                                    </div>                                    
                                </fieldset>
	                        </div>
	                    </div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 text-center m-t-20">
						<button type="submit" class="btn btn-lg btn-danger m-r-5">Save Changes</button>
					</div>
				</form>
			</div>
		</div>