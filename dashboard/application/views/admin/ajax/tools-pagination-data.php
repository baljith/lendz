<div class="col-md-12 col-sm-12 col-xs-12"> 
	<div class="unattended_show">
		<?php echo $this->ajax_pagination->showing_info(); ?>
	</div> 	
	
	<?php
	 if(!empty($users)): foreach($users as $user): 
		//print_r($user);
	?>
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
														<h2 class="usr_name m-t-10 m-b-0" title="<?php echo $user['Description']; ?>">
															<?php echo (strlen($user['Description']) > 30) ? substr($user['Description'],0,30).'...' : $user['Description']; ?>
														</h2>
														<?php if($user['Type']=='warranty'){
															?>
																<p class="reason_class">Reason for repair:
																	<span style="color: red;">
																		<?php echo $user['Reason_For_Repair']; ?>
																	</span>
																</p>
															<?php
															}?>
														<p class="sub_usr_name">
															<i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<span><?php echo date_visible($user['Created_Date']); ?></span>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>			
			    		</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<ol class="technical_list">
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-user-o" aria-hidden="true"></i>
											<span><?php if($user['User_Role']==1){ echo "Technician "; }else if($user['User_Role']==2){ echo "Shop Owner "; } ?>Name:</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_First_Name']).' '.@ucfirst($user['User_Last_Name']); ?> </span>
										</div>
									</div>
								</li>
								<?php 
								if($user['Type']=='warranty')
								{
									?>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<i class="fa fa-calendar"></i>
												<span>Tool send out on:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo date_visible_without_time($user['Sent_Date']); ?> </span>
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
			                                    <span class="list-sub-text"> <?php echo date_visible_without_time($user['Promise_Date']); ?> </span>
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
		                                    <span class="list-sub-text"> <?php echo $user['Username']; ?> </span>
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
		                                    <span class="list-sub-text"> <?php echo $user['User_Email']; ?> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="col-md-5 list-head col-xs-6 col-sm-5">
											<i class="fa fa-building-o" aria-hidden="true"></i>
											<span><?php if($user['User_Role']==1){ echo "Shop"; }else if($user['User_Role']==2){ echo "Business"; } ?> Name :</span>
										</div>
										<div class="col-md-7 col-xs-6 col-sm-7">
		                                    <span class="list-sub-text"> <?php echo  @ucfirst($user['User_Franchise_Name']); ?> </span>
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
		                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Buisness_Address']); ?> </span>
										</div>
									</div>
								</li>
							</ol>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
						<div class="btn_three pull-right">
						<?php
						  	if($this->session->userdata('Role')=='3')
					    	{
					    		$check_status = $this->common_model->connected($this->session->userdata('User_Id'),$user['User_Id']);
					    		if($check_status)
					    		{
					    			if($check_status=="accepted")
					    			{
						    			?>
							    	 	<a href="<?php echo base_url('chat/user/'.$user['User_Id'].'/'.$user['Id'].'/tool'); ?>" type="button" class="btn comment_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
								    	<i class="fa fa-commenting-o" aria-hidden="true"></i>
								    	</a>
							    		<?php
					    			}
					    		}
					    		else
					    		{
						    		?>
							    		<button onclick="connect_user('Do you want to be connected with <?php echo $user['User_First_Name']." ".get_role_name($user['Role']); ?>','<?php echo $user['User_Id']; ?>')" type="button" class="btn delete_btn"><i class="fa fa-user-plus" aria-hidden="true"></i>
				                		</button>
						    		<?php
					    		}
					    	}
					    	else
					    	{
					    		?>
						    	 	<a href="<?php echo base_url('chat/user/'.$user['User_Id'].'/'.$user['Id'].'/tool'); ?>" title="<?php echo $this->lang->line('click_here_to_chat'); ?>" type="button" class="btn comment_btn">
							    	<i class="fa fa-commenting-o" aria-hidden="true"></i>
							    	</a>
					    		<?php
					    	}
						    ?>
						    <?php 
						    if($this->session->userdata('Role')==0)
						    {
							    if($user['Is_Deleted'])
							    {
							    	?>
							    	<button    title="Activate"  data-msg="Do you want to activate <?php echo $user['Type']; ?> tool ?" data-table="tools" data-column="Id" data-id="<?php echo $user['Id'] ?>" data-status="0" onclick="perm_delete(this)" type="button" class="btn primary_btn"><i class="fa fa-reply" aria-hidden="true"></i>
	                            	</button>
	                            	<?php
							    }
							    else
							    {
							    	?>
							    	 <button title="Deactivate"  data-msg="Do you want to deactivate <?php echo $user['Type']; ?> tool ?" data-table="tools" data-column="Id" data-id="<?php echo $user['Id'] ?>" data-status="1" onclick="perm_delete(this)" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
	                            	</button>
							    	<?php
							    }
							}
						    ?>
						    <a href="<?php echo base_url('users/tool_view/'.$user['Id']); ?>" title="View" type="button" class="btn primary_btn">
							    	<i class="fa fa-eye" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>			
	    	</div>
        </div>
    </div>
     <?php endforeach; else: ?>
     <p style="    padding: 10px;
    text-align: center;
    font-size: 20px;
    background: white;"><?php echo $no_data_found_msg; ?></p>
    <?php endif; ?>
</div>
<div class="col-md-12">
	 <div class="pagination text-center center-block">
	 	<?php echo $this->ajax_pagination->create_links(); ?>
	 </div>
</div>
    