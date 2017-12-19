<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li class="active">Categories list</li>
	</ol>
	<h1 class="page-header">Categories list<small></small></h1>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-inverse">
                <div class="panel-body">
                	<div class="box">
	                	<div  class="box-header">
						 <div  class="row">
							  <div  class="col-md-8">
								  <!-- <h3 _ngcontent-c7="" class="box-title">Booking List</h3> -->
							  </div>
							  <div  class="col-md-4 text-right">
								  <a  class="btn btn-sm btn-primary" href="<?php echo base_url('category/add'); ?>">Add New Category</a>
							  </div>
							</div>
						</div>
                	</div>
                   <div class="col-md-12 box-body" style="margin-top: 20px;">
                   	 	<table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
	                            <?php 
	                            if(!empty($category))
	                            {
	                            	foreach($category as $cat)
	                            	{
	                            		?>
		                            		<tr class="gradeA">
			                                    <td><?php echo $cat['Name']; ?></td>
			                                    <td><?php $image = base_url('assets/upload/category_img/'.$cat['Image']);  ?><img class="image_here" src="<?php echo $image; ?>" alt="" /></td>
			                                    <td>
			                                    	<div class="pull-center">
			                                    		<input class="switch" type="checkbox" name="my-checkbox" data-on-text="Active" data-off-text="Inactive" <?php if($cat['Status'] =="Active") { echo 'checked'; } ?> id="<?php echo $cat['Id']; ?>">
			                                    	</div>
			                                    </td>
			                                    <td>
			                                    	<div class="btn_three">
				                                    	<a href="<?php echo base_url('category/add/'.$cat['Id']); ?>" class="btn edit_btn">
													    	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													    </a>
				                                    	<!-- <?php
				                                    	if($cat['Is_Deleted'])
				                                    	{
				                                    		?>
				                                    		<button title="Activate"  data-msg="Do you want to rea-dd this package ?" data-table="packages" data-column="Package_Id" data-id="<?php echo $cat['id']; ?>" data-status="0"  onclick="perm_delete(this)" type="button" class="btn primary_btn"><i class="fa fa-reply" aria-hidden="true"></i>
				                                    		</button>
				                                    		<?php
				                                    	}
				                                    	else
				                                    	{
				                                    		?>
				                                    		<button title="Deactivate"  data-msg="Do you want to delete this package ?" data-table="packages" data-column="Package_Id" data-id="<?php echo $cat['id']; ?>" data-status="1"  onclick="perm_delete(this)" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
							                            	</button>
				                                    		<?php
				                                    	}
				                                    	?> -->
			                                   	 	</div>
			                                    </td>
			                                </tr>
	                            		<?php
	                            	}
	                            }
	                            ?>
                            </tbody>
                        </table>
                   </div>
                </div>
            </div>
		</div>
	</div>
</div>