		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class=""><a href="<?php echo base_url('transactionss'); ?>">Subscription list</a></li>
				<li class="active">View Subscription</li>
			</ol>
			<h1 class="page-header">View Subscription</small></h1>
			<div class="row">
				<form action="/" method="POST" id="add_package_form">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-inverse">
	                        <div class="panel-body">
	                            <fieldset>
		                            <div class="col-md-12">
	                                    <legend><?php echo $subscription['User_Full_Name']; ?></legend>
		                            </div>
	                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<ol class="technical_list">
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-id-badge" aria-hidden="true"></i>
														<span>Current Package:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
						                                <span class="list-sub-text"><?php echo $subscription['Package_Name']; ?></span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-repeat" aria-hidden="true"></i>
														<span>Renewal Date:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php if($subscription['Status']==0){ echo date('M,d Y',$subscription['End_At']); }else{ echo "-"; } ?> </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-map-marker" aria-hidden="true"></i> 
														<span>Subscription Status: </span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php echo ($subscription['Status']==0)?'Active':'Cancelled'; ?> </span>
													</div>
												</div>
											</li>
										</ol>
	                                </div>
	                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<ol class="technical_list">
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
														<span>Subscription ID:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
						                                <span class="list-sub-text"><?php echo $subscription['Subs_Id']; ?></span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-cc-stripe" aria-hidden="true"></i>
														<span>Stripe ID:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"><?php echo $subscription['Cust_Id']; ?></span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<i class="fa fa-usd" aria-hidden="true"></i>
														<span>Package Amount: </span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php echo $subscription['Package_Price']; ?> </span>
													</div>
												</div>
											</li>
										</ol>
	                                </div>                                    
                                </fieldset>
                                 <fieldset>
                                 	<div class="col-md-12">
			                            <h2 style="margin-top: 32px; font-size: 21px; border-bottom: 1px solid #e2e7eb; padding-bottom: 7px;">Transaction History</h2> <table id="data-table2" class="table table-striped table-bordered">
				                            <thead>
				                                <tr>
				                                    <th>Date</th>
				                                    <th>Package Name</th>
				                                    <th>Package Price ($)</th>
				                                    <th>Amount Paid ($)</th>
				                                    <th>Balance ($)</th>
				                                </tr>
				                            </thead>
				                            <tbody>
					                            <?php 
					                            if(!empty($subscription['transactions']))
					                            {
					                            	foreach($subscription['transactions'] as $transaction)
					                            	{
					                            		?>
						                            		<tr class="gradeA">
							                                    <td><?php echo date_visible_without_time2($transaction['Created_At']); ?></td>
							                                    <td><?php echo $transaction['Package_Name']; ?></td>
							                                    <td><?php echo $transaction['Package_Price']; ?></td>
							                                    <td><?php echo $transaction['Payment']/100; ?></td>
							                                    <td><?php echo $transaction['Balance']/100; ?></td>
							                             	</tr>
					                            		<?php
					                            	}
					                            }
					                            ?>
				                            </tbody>
			                			</table>
                                 	</div>
                    			</fieldset>
	                        </div>
	                    </div>
					</div>
				</form>
			</div>
		</div><script>
	window.onload = function()
	{
		 $('#data-table2').dataTable({
        /* Disable initial sort */
        "aaSorting": []
    	});
	}
</script>