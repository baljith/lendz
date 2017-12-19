<style type="text/css">
	.usr_name {margin: 25px 0 !important;}
</style>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<div class="unattended_show">

<?php echo $this->ajax_pagination->showing_info(); ?>
</div> 	
<?php
 if(!empty($users)): foreach($users as $user): ?>
<div class="panel panel-inverse margin-b1">
<div class="panel-body p-0">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div id="unattended_detail" class="panel margin-b0">   
<!-- 	<div class="panel-body"> -->
		<div class="row unattended_results">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="persinfo_container">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
						<div class="row">
							<div class="col-md-1 col-sm-2 col-lg-1 col-xs-2 custom-padding-class">
								<?php 
									if(!empty($user['User_Image']))
									{
										$image = base_url('assets/upload/profile_pictures/'.$user['User_Image']);
									}
									else
									{
										$image = base_url('assets/dummy/no-user.png');
									}
									?>
								<img src="<?php echo $image; ?>" class="user_img">
				 			</div>
							<div class="col-md-11 col-sm-10  col-lg-11 col-xs-10" style="    border-bottom: 1px solid #eeeeee;padding-bottom: 7px;">
								<div class="p-l-5">
									<div class="row">
										<div class="col-xs-8 col-lg-9 col-md-9 col-sm-9">
											<h2 class="usr_name m-t-10 m-b-0"><?php echo $user['User_First_Name']." ".$user['User_Last_Name']; ?></h2>
											<p class="sub_usr_name hide"><i class="fa fa-user" aria-hidden="true"></i>  Username- <span><?php echo $user['Username']; ?> </span></p>
										</div>
										<?php 
											if($this->session->userdata('Role')=='0'){?>
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 res-date_in_list">
											<div class="user_mobile pull-right">
											<i class="fa fa-clock-o" aria-hidden="true"></i>
											<?php 
											echo date_visible_without_time2($user['Created_Date']);
											?>
											</div>
										</div>
											<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
    		</div>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
				<ol class="technical_list">
					<li>
						<div class="row">
							<div class="col-md-5 list-head col-xs-6 col-sm-5">
								<i class="fa fa-envelope-o" aria-hidden="true"></i>
								<span>Email Address:</span>
							</div>
							<div class="col-md-7 col-xs-6 col-sm-7">
                                <span class="list-sub-text"> <?php echo @ucfirst($user['User_Email']); ?> </span>
							</div>
						</div>
					</li>
					<?php 
					if($user['Role']==1)
					{
						?>
						<li>
						<div class="row">
							<div class="col-md-5 list-head col-xs-6 col-sm-5">
								<i class="fa fa-hospital-o" aria-hidden="true"></i>
								<span style="padding-left: 20px;">Shop Name:</span>
							</div>
							<div class="col-md-7 col-xs-6 col-sm-7">
                                <span class="list-sub-text"> <?php echo @ucfirst($user['User_Franchise_Name']); ?> </span>
							</div>
						</div>
						</li>
						<li>
							<div class="row">
								
								<div class="col-md-5 list-head col-xs-6 col-sm-5">
									<i class="fa fa-map-marker" aria-hidden="true"></i> 
									<span style="padding-left: 25px;">Shop Address: </span>
								</div>
								<div class="col-md-7 col-xs-6 col-sm-7">

                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Buisness_Address']); ?> (<?php echo @ucfirst($user['User_Zip_Code']); ?>) </span>
								</div>
							</div>
						</li>
						<?php
					}
					elseif($user['Role']==2)
					{
						?>
						<li>
							<div class="row">
								<div class="col-md-5 list-head col-xs-6 col-sm-5">
									<i class="fa fa-hospital-o" aria-hidden="true"></i>
									<span>Business Name:</span>
								</div>
								<div class="col-md-7 col-xs-6 col-sm-7">
                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Franchise_Name']); ?> </span>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								
								<div class="col-md-5 list-head col-xs-6 col-sm-5">
									<i class="fa fa-map-marker" aria-hidden="true"></i> 
									<span>Business Address: </span>
								</div>
								<div class="col-md-7 col-xs-6 col-sm-7">
                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Buisness_Address']); ?>  (<?php echo @ucfirst($user['User_Zip_Code']); ?>) </span</span>
								</div>
							</div>
						</li>
						<?php
					}
					elseif($user['Role']==3)
					{
						?>
						<li>
							<div class="row">
								<div class="col-md-5 list-head col-xs-6 col-sm-5">
									<i class="fa fa-hospital-o" aria-hidden="true"></i>
									<span>Franchise Name:</span>
								</div>
								<div class="col-md-7 col-xs-6 col-sm-7">
                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Franchise_Name']); ?> </span>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								
								<div class="col-md-5 list-head col-xs-6 col-sm-5">
									<i class="fa fa-map-marker" aria-hidden="true"></i> 
									<span>Business Address: </span>
								</div>
								<div class="col-md-7 col-xs-6 col-sm-7">
                                    <span class="list-sub-text"> <?php echo @ucfirst($user['User_Buisness_Address']); ?> </span>
								</div>
							</div>
						</li>
						<?php
					}
					?>
				</ol>
			</div>
		</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
	<div class="btn_three pull-right">

			<?php if($User_Role == 0){?>
			    <a title="Edit" href="<?php echo base_url('users/edit/').$user['User_Id']; ?>" type="button" class="btn edit_btn">
			    	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
			    </a>
		    <?php } ?>
		     <?php
		     if($User_Role == 0)
		     {
			    if($user['Is_Deleted'])
			    {
			    	?>
				    	<button title="Activate"  data-msg="<?php echo $this->lang->line('account_activate').get_role_name($user['Role']); ?> account ?" data-table="users" data-column="User_Id" data-id="<?php echo $user['User_Id'] ?>" data-status="0"  onclick="perm_delete(this)" type="button" class="btn primary_btn"><i class="fa fa-reply" aria-hidden="true"></i>
                    	</button>
                	<?php
			    }
			    else
			    {
			    	?>
			    		<button title="Deactivate" data-msg="<?php echo $this->lang->line('account_deactivate').get_role_name($user['Role']); ?> account ?" data-table="users" data-column="User_Id" data-id="<?php echo $user['User_Id'] ?>" data-status="1"  onclick="perm_delete(this)"  type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
                		</button>
			    	<?php
			    }
			}
			if($this->session->userdata('Role')=='3')
	    	{
	    		$check_status = $this->common_model->connected($this->session->userdata('User_Id'),$user['User_Id']);
	    		if($check_status)
	    		{
	    			if($check_status=="accepted")
	    			{
		    			?>
			    	 	<a href="<?php echo base_url('chat/messages/').$user['User_Id']; ?>" type="button" class="btn comment_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
				    	<i class="fa fa-commenting-o"  aria-hidden="true"></i>
				    	</a>
			    		<?php
	    			}
	    			else
	    			{
	    				?>
	    				<label class="label label-success">Request Sent</label>
	    				<?php
	    			}
	    		}
	    		else
	    		{
		    		?>
			    		<button onclick="connect_user('Do you want to be Connected with <?php echo $user['User_First_Name']." ".get_role_name($user['Role']); ?> ?','<?php echo $user['User_Id']; ?>',this)" type="button" class="btn delete_btn" title="<?php echo $this->lang->line('click_here_to_connect'); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i>
                		</button>
		    		<?php
	    		}
	    	}
	    	else
	    	{
	    		?>
		    	 	<a title="Chat" href="<?php echo base_url('chat/messages/'.$user['User_Id']); ?>" type="button" class="btn comment_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
			    	<i class="fa fa-commenting-o" aria-hidden="true"></i>
			    	</a>

			    	<a title="All thread" href="<?php echo base_url('chat/all_messages/'.$user['User_Id']); ?>" type="button" class="btn comment_btn" title="<?php echo $this->lang->line('click_here_to_chat'); ?>">
			    	<i class="fa fa-envelope-open" aria-hidden="true"></i>
			    	</a>
	    		<?php
	    	}
		    ?>
		</div>
	</div>
<!-- </div> -->
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
<div class="clearfix"></div>
<div class="col-md-12">
<div class="pagination text-center center-block">
<?php echo $this->ajax_pagination->create_links(); ?>
</div>
</div>
