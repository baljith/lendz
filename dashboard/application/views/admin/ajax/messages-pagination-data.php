<!-- //My data strat here -->
<ul class="media-list media-list-with-divider media-messaging" id="all_messages">
    <div class="no-messages"><?php echo $this->ajax_pagination->showing_info(); ?></div>
	<?php 
	if(!empty($messages))
	{
		foreach($messages as $msg)
		{
			if(!empty($msg['Description']))
			{
				if(strlen($msg['Description'])>40)
				{
					$desc = substr(ucfirst($msg['Description']),0,40).".....";
				}
				else
				{
					$desc = ucfirst($msg['Description']);
				}
				if($msg['Sent_By']===$this->session->userdata('User_Id'))
				{
					$Full_Name = ucfirst($msg['To_User_First_Name']).' '.ucfirst($msg['To_User_Last_Name'])." (".$desc.")";
					$Url = base_url('chat/user/'.$msg['Sent_To'].'/'.$msg['Thread'].'/'.$msg['Thread_Type']);
					$unread_counter = $this->message->unread_counter($msg['Sent_By'],$msg['Sent_To'],$msg['Thread']);
					$icon = '<i class="fa fa-share" aria-hidden="true"></i>';
				}	
				else
				{
					$Full_Name = ucfirst($msg['From_User_First_Name']).' '.ucfirst($msg['From_User_Last_Name'])." (".$desc.")";
					$Url = base_url('chat/user/'.$msg['Sent_By'].'/'.$msg['Thread'].'/'.$msg['Thread_Type']);
					$unread_counter = $this->message->unread_counter($msg['Sent_To'],$msg['Sent_By'],$msg['Thread']);
					$icon = '<i class="fa fa-reply" aria-hidden="true"></i>';
				}
			}
			else
			{
				if($msg['Sent_By']===$this->session->userdata('User_Id'))
				{
					$Full_Name = ucfirst($msg['To_User_First_Name']).' '.ucfirst($msg['To_User_Last_Name']);
					$Url = base_url('chat/user/'.$msg['Sent_To']);
					$unread_counter = $this->message->unread_counter($msg['Sent_By'],$msg['Sent_To']);
					$icon = '<i class="fa fa-share" aria-hidden="true"></i>';
				}	
				else
				{
					$Full_Name = ucfirst($msg['From_User_First_Name']).' '.ucfirst($msg['From_User_Last_Name']);
					$Url = base_url('chat/user/'.$msg['Sent_By']);
					$unread_counter = $this->message->unread_counter($msg['Sent_To'],$msg['Sent_By']);
					$icon = '<i class="fa fa-reply" aria-hidden="true"></i>';
				}
			}

			?>
			<li class="media media-sm <?php echo ($unread_counter==0)?'unread_msg':'read_msg'; ?>">
	            <a href="<?php echo $Url; ?>" class="pull-left media-object rounded-corner" ><?php echo ucfirst(substr($Full_Name,0,1)); ?><?php echo ($unread_counter!=0)?'<span class="time_label">'.$unread_counter.'</span>':''; ?></a>
	            <div class="media-body" style="padding-top: 10px;">
	            	<a href="<?php echo $Url; ?>">
						<h5 class="media-heading" style="font-size: 17px;"><?php echo $Full_Name; ?>
							<span class="msg_time"><i class="fa fa-clock-o"></i>&nbsp;<?php echo date_visible($msg['Date']); ?></span>
						</h5>
						<p><?php echo $icon." ";?><?php echo (strlen($msg['Message'])>70)?substr($msg['Message'],0,70)."...":$msg['Message']; ?></p>
					</a>
				</div>   
				<?php
				if(!empty($msg['Created_By']) && $msg['Created_By']==$this->session->userdata('User_Id'))
				{
					if($msg['Archived']==0)
					{
						?>
						<div class="media-footer">
							<button title="Archive" data-status="1" data-id="<?php echo $msg['Subject_Id']; ?>" onclick="archive_chat('<?php echo $this->lang->line('archieve_chat_confirm'); ?>',this);" class="btn btn-sm btn-success pull-right"><i class="fa fa-archive" aria-hidden="true"></i></button>
						</div>                    
						<?php
					}
				}
				?>
	        </li> 
			<?php
		}
	}
	else
	{
		?>
		<li style="padding: 10px; text-align: center; font-size: 20px; background: white;"><?php echo (!empty($archive))?$this->lang->line('no_archived_messages_yet'):$this->lang->line('no_messages_yet'); ?></li> <?php
	}
	?>
</ul>
<div class="clearfix text-center">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>

                        

       


    