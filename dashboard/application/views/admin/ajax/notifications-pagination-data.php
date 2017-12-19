<style>
	.link_p>p
	{
		color:blue !important;
	}
</style>
<!-- //My data strat here -->
<ul class="media-list media-list-with-divider media-messaging" id="all_messages">
    <div class="no-messages"><?php echo $this->ajax_pagination->showing_info(); ?></div>
	<?php 
	if(!empty($notifications))
	{
		foreach($notifications as $noti)
		{
			?>
			<li class="media media-sm <?php echo ($noti['Is_Read']==0)?'read_msg':'unread_msg'; ?>">
			  <a href="javascript:void(0);" class="pull-left media-object rounded-corner" ><?php echo ucfirst(substr($noti['User_First_Name'],0,1)); ?></a>

	            <div class="media-body" style="padding-top: 10px;">
	            		<?php
	            		if($noti['Notification_Type']=='new_tool')
	            		{
	            			?>
	            			<a class="link_p" href="<?php echo base_url('users/tool_view/'.$noti['Tool_Id']); ?>">
	            			<?php
	            		 }
	            		 else if($noti['Notification_Type']=='show_tools')
	            		 {
	            		 	?>
	            			<a class="link_p" href="<?php echo base_url('users/notifications/'.$noti['N_Id']); ?>">
	            			<?php
	            		 }
	            		 ?>
						<p><?php echo  ucfirst($noti['User_First_Name'])." ".ucfirst($noti['User_Last_Name'])." (".get_role_name($noti['Role']).")".$noti['Notification']; ?>
							<?php 
							if(!empty($noti['Connect_Id']))
							{
								$check_connect =$this->common_model->connected($this->session->userdata('User_Id'),$noti['From_User']);
								if($check_connect)
								{
									if($check_connect=='pending')
									{
										?>
										<button class="btn btn-sm btn-success notification-action" onclick="accpet_or_reject_status('<?php echo $noti['Connect_Id']; ?>','1',this)">Accept</button>
										<button class="btn btn-sm btn-danger notification-action" onclick="accpet_or_reject_status('<?php echo $noti['Connect_Id']; ?>','2',this)">Reject</button>
										<?php
									}
								}
							}
							?>
						</p>
						<?php
	            		if($noti['Notification_Type']=='new_tool' || $noti['Notification_Type']=='show_tools')
	            		{
	            			?>
	            			</a>
	            			<?php
	            		 }
	            		 ?>
						<span class="msg_time pull-right"><i class="fa fa-clock-o"></i>&nbsp;<?php echo date_visible($noti['Date']); ?></span>
					<!-- </a> -->
				</div>                       
	        </li> 
			<?php
		}
	}
	else
	{
		?>
		<li style="    padding: 10px;
    text-align: center;
    font-size: 20px;
    background: white;"><?php echo $this->lang->line('no_notifications_yet'); ?></li>
		<?php
	}
	?>
</ul>
<div class="clearfix text-center">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>

                        

       


    