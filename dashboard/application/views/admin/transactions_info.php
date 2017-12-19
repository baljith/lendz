<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li class="active">Profile</li>
		<li class="active">Transactions History</li>
	</ol>
	<h1 class="page-header">Transactions History<small></small></h1>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-inverse">
                <div class="panel-body">
                   <div class="col-md-12">
                   	 	<table id="data-table2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Package Name</th>
                                    <th>Package Price</th>
                                    <th>Amount Paid ($)</th>
                                    <th>Balance ($)</th>
                                   <!--  <th>Subscription ID</th> -->
                                </tr>
                            </thead>
                            <tbody>
	                            <?php 
	                            if(!empty($transactions))
	                            {
	                            	foreach($transactions as $transaction)
	                            	{
	                            		?>
		                            		<tr class="gradeA">
			                                    <td><?php echo date_visible_without_time2($transaction['Created_At']); ?></td>
			                                    <td><?php echo $transaction['Package_Name']; ?></td>
			                                    <td><?php echo $transaction['Package_Price']; ?></td>
			                                    <td><?php echo (!empty($transaction['Payment']))?$transaction['Payment']/100:0; ?></td>
			                                    <td><?php echo (!empty($transaction['Balance']))?$transaction['Balance']/100:0; ?></td>
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
<script>
	window.onload = function()
	{
		 $('#data-table2').dataTable({
        /* Disable initial sort */
        "aaSorting": []
    	});
	}
</script>