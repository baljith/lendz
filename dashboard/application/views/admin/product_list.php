<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li class="active">Product list</li>
	</ol>
	<h1 class="page-header">Product list<small></small></h1>
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
							  <!-- <div  class="col-md-4 text-right">
								  <a  class="btn btn-sm btn-primary" href="<?php echo base_url('products/add'); ?>">Add New Product</a>
							  </div> -->
							</div>
						</div>
                	</div>
                   <div class="col-md-12" style="margin-top: 20px;">
                   	 	<table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>User Name</th>
                                    <th>Product Category</th>
                                    <th>Product Price</th>
                                    <th>Product Rent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
	                            <?php if(!empty($product_list)) {
	                            	foreach($product_list as $pro) { ?>
			                        	<tr>
			                        		<td><?php echo $pro['Product_Name']; ?></td>
			                        		<td><?php echo $pro['Username']; ?></td>
			                        		<td><?php echo $pro['Name']; ?></td>
			                        		<td><?php echo '$ '.$pro['Product_Rent']; ?></td>
			                        		<td>
			                        			<!-- <div class="status_div">
				                        			<?php if($pro['Status'] =="Pending") { ?>
				                        				<button type="button" class="btn btn-primary approved" rel="<?php echo $pro['Id']; ?>">Approved</button>
														<button type="button" class="btn btn-secondary unapproved" rel="<?php echo $pro['Id']; ?>">Unapproved</button>
				                        			<?php } else {?>
				                        				<input class="switch" type="checkbox" name="my-checkbox" data-on-text="Active" data-off-text="Inactive" <?php if($pro['Status'] =="Active") { echo 'checked'; } ?> id="<?php echo $pro['Id']; ?>">
			                                    	<?php }?>
			                        			</div> -->
			                        			<?php if($pro['Status'] == 'Pending') { 
			                        					
			                        						echo "<span class='badge badge-pill badge-danger'>Pending</span>";
			                        					
			                        					} else if($pro['Status'] == 'Approved') {

			                        						echo "<span class='badge badge-pill badge-success'>Approved</span>";
			                        					
			                        					}else if($pro['Status'] == 'Unapproved') {

			                        						echo "<span class='badge badge-pill badge-success'>Unapproved</span>";
			                        					}

			                        			?>
			                        		</td>
			                        		<td>
			                        			<div class="btn_three">
			                                    	<a href="<?php echo base_url('products/view/'.$pro['Id']); ?>" class="btn edit_btn">
												    	<i class="fa fa-eye" aria-hidden="true"></i>
												    </a>
												</div>
			                        		</td>
			                        	</tr>    		
	                            
	                            <?php } } ?>
                            </tbody>
                        </table>
                   </div>
                </div>
            </div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.approved').click(function(){
		var id = $(this).attr('rel');
		$.ajax({
	        url: ajax_url+'products/productApprovel',
	        type:'POST',
	        dataType: 'json',
	        data:{
	            'id':id,'Status':'Approved'
	        },
	        success:function(data)
	        {
	            $("html, body").animate(
	            {
	                scrollTop: 0
	            }, "slow");
	            if (data['status'])
	            {
	                msg_div(data['status'], data['msg']);

	            }
	            else
	            {
	                msg_div(data['status'], data['msg']);
	            }
	        }
	    })
	});
</script>