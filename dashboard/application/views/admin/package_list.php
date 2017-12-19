<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li class="active">Packages list</li>
	</ol>
	<h1 class="page-header">Packages list<small></small></h1>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-inverse">
                <div class="panel-body">
                   <div class="col-md-12">
                   	 	<table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Period (Month)</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
	                            <?php 
	                            if(!empty($packages))
	                            {
	                            	foreach($packages as $package)
	                            	{
	                            		?>
		                            		<tr class="gradeA">
			                                    <td><?php echo $package['Package_Name']; ?></td>
			                                    <td><?php echo $package['Package_Price']; ?></td>
			                                    <td><?php echo $package['Package_Period']; ?></td>
			                                    <td><?php echo html_entity_decode($package['Package_Description']); ?></td>
			                                    <td>
			                                    	<div class="btn_three pull-right">
				                                    	<a href="<?php echo base_url('packages/add/'.$package['Package_Id']); ?>" class="btn edit_btn">
													    	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													    </a>
				                                    	<?php
				                                    	if($package['Is_Deleted'])
				                                    	{
				                                    		?>
				                                    		<button title="Activate"  data-msg="Do you want to rea-dd this package ?" data-table="packages" data-column="Package_Id" data-id="<?php echo $package['Package_Id']; ?>" data-status="0"  onclick="perm_delete(this)" type="button" class="btn primary_btn"><i class="fa fa-reply" aria-hidden="true"></i>
				                                    		</button>
				                                    		<?php
				                                    	}
				                                    	else
				                                    	{
				                                    		?>
				                                    		<button title="Deactivate"  data-msg="Do you want to delete this package ?" data-table="packages" data-column="Package_Id" data-id="<?php echo $package['Package_Id']; ?>" data-status="1"  onclick="perm_delete(this)" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
							                            	</button>
				                                    		<?php
				                                    	}
				                                    	?>
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