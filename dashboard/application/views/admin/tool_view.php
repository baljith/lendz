<style type="text/css">
	.icon-wrapper {
	    width: 75px;
	    height: 75px;
	    background: red;
	    border-radius: 50%;
	    color: #fff;
	    display: inline-block;
	    text-align: center;
	}
	.icon-wrapper i.fa.fa-cog {
	    font-size: 41px;
	    position: relative;
	    top: 16px;
	}
</style>
<?php
/*
echo '<pre>';
print_r($title);die(); */
?>
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers"><?php echo ucfirst(@$tool_info['Type']); ?> Tool View</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li><a href="<?php echo base_url('users/tools/'.get_role_type($tool_info['Role']).'/'.$tool_info['Type']); ?>">Tools</a></li>
					<li class="active">View</li>
				</ol>
		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
		
		</div>
	</div>
	
</div>
<hr class="horizental_line">
<div class="clearfix"></div>
<div id="content" class="content">
	<div class="row" id="usersList">
		<div class="col-md-12 col-sm-12 col-xs-12"> 
			<div class="panel panel-inverse margin-b1">
		        <div class="panel-body p-0">
		            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<div id="unattended_detail" class="panel margin-b0">   
							<div class="row unattended_results">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="persinfo_container">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
											<div class="row">
												<div class="col-md-1 col-sm-1 col-lg-1 hidden-xs custom-padding-class">
													<div class="icon-wrapper">
														<i class="fa fa-cog" aria-hidden="true"></i>
													</div>
									 			</div>
												<div class="col-md-11 col-sm-11  col-lg-11 col-xs-12" style="    border-bottom: 1px solid #eeeeee;">
													<div class="p-l-5">
														<div class="row">
															<div class="col-xs-9 col-lg-9 col-md-9 col-sm-9">
																<h2 class="usr_name m-t-10 m-b-0" title="need">
																<?php 
																if(strlen($tool_info['Description'])>40)
																{
																	echo substr($tool_info['Description'],0,40)."....";
																}
																else
																{
																	echo $tool_info['Description'];
																}
																?>
																</h2>
																<i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<span><?php echo date_visible($tool_info['Created_Date']); ?></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>			
					    		</div>
							</div>
							<div class="col-md-12">
								<p style="font-size: 16px; padding: 16px 10px; color: black;"> <?php echo $tool_info['Description']; ?>
									</p>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									
									<ol class="technical_list">
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-user-o" aria-hidden="true"></i>
											<span><?php if($tool_info['User_Role']==1){ echo "Technician "; }else if($tool_info['User_Role']==2){ echo "Shop Owner "; } ?>Name:</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo @ucfirst($tool_info['User_First_Name']).' '.@ucfirst($tool_info['User_Last_Name']); ?> </span>
										</div>
									</div>
								</li>
								<?php 
								if($tool_info['Type']=='warranty')
								{
									?>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<i class="fa fa-calendar"></i>
												<span>Tool send out on:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo date_visible_without_time($tool_info['Sent_Date']); ?> </span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
												<span>Promise date of return:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo date_visible_without_time($tool_info['Promise_Date']); ?> </span>
											</div>
										</div>
									</li>
									<?php
								}
								?>
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-user-o"></i>
											<span>Username:</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo $tool_info['Username']; ?> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-envelope-o" aria-hidden="true"></i>
											<span>Email Address:</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo $tool_info['User_Email']; ?> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-building-o" aria-hidden="true"></i>
											<span><?php if($tool_info['User_Role']==1){ echo "Shop"; }else if($tool_info['User_Role']==2){ echo "Business"; } ?> Name :</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo  @ucfirst($tool_info['User_Franchise_Name']); ?> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-map-marker" aria-hidden="true"></i> 
											<span>Shop Address: </span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo @ucfirst($tool_info['User_Buisness_Address']); ?> </span>
										</div>
									</div>
								</li>
							</ol>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
								<div class="btn_three pull-right">
									<?php 
									if($this->session->userdata('Role')==3)
									{
										$check_status = $this->common_model->connected($this->session->userdata('User_Id'),$tool_info['User_Id']);
									}
									else
									{
										$check_status = "accepted";
									}
									if($check_status)
						    		{
						    			if($check_status=="accepted")
						    			{
							    			?>
								    	 	<a href="<?php echo base_url('chat/user/'.$tool_info['User_Id'].'/'.$tool_info['Id'].'/tool'); ?>" type="button" class="btn comment_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
									    	<i class="fa fa-commenting-o" aria-hidden="true"></i>
									    	</a>
								    		<?php
						    			}
						    		}
									?>
								</div>
							</div>
						</div>			
			    	</div>
		        </div>
    		</div>
     	</div>
    </div>
</div>
<?php 
$this->ajax_pagination->getData();
?>
<script type="text/javascript">
	window.onload = function()
	{
		getData('0');
	}
</script>