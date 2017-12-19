<div id="content" class="content header-sec">
	<div class="row">
		<div class="col-md-5 col-sm-12 col-lg-6 col-xs-12 header-left">

			    <span class="page-headers">Chat (<?php echo ucfirst($info['User_First_Name']." ".$info['User_Last_Name']);?>)<?php 
			if(!empty($tool_info['Description'])){
				if(strlen($tool_info['Description'])>30){
					echo "(".substr($tool_info['Description'],0,20)."...)";
				}
				else{
					echo "(".$tool_info['Description'].")";
				}
			}
			else if(!empty($subject_info['Subject_Name'])){
				if(strlen($subject_info['Subject_Name'])>30){
					echo "(".substr($subject_info['Subject_Name'],0,20)."...)";
				}
				else{
					echo "(".$subject_info['Subject_Name'].")";
				}
			}
			?></span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
					<li class="active">Chat (<?php echo $info['User_First_Name'];?>)</li>
				</ol>
		</div>
		<div class="col-md-7 col-sm-12 col-lg-6 col-xs-12 header-right">
			<ul class="top-link">
				
			</ul>
		</div>
	</div>
	
</div>
<hr class="horizental_line">
<div class="clear-fix"></div>
<div id="content" class="content pagecontent-sec">
	<div class="row" id="usersList">						
		<div class="panel panel-inverse" data-sortable-id="index-2">			           
			<div class="panel-body chat-content-block">
				<!-- <h4 class="chat-heading">Today</h4>	 -->
			    <div data-scrollbar="true" data-height="300px" id="main_div">
			    	<button class="center-block" id="load_previous_msg_button" style="display: block;">Load previous messages</button>
			        <ul class="chats" id="msg_container">
			        	<div class="cssload-container"> <div class="cssload-zenith" style="left: 48%; top: 50%;"></div></div> 
			        </ul>
			    </div>
			</div>
			<div class="panel-footer">
			    <form name="send_message_form" id="send_message_form" data-id="message-form">
			        <div class="input-group col-md-12">
			            <input type="hidden" class="form-control input-sm" name="sent_to" value="<?php echo $send_to; ?>" id="User_Id" placeholder="Enter your message here.">

			            <input type="hidden"  name="thread_id" id="thread_id" value="<?php echo $thread_id; ?>">
			            <input type="hidden"  name="thread_type" id="thread_type" value="<?php echo $thread_type; ?>">
			            <?php 
					if(!empty($tool_info['Archived']))
					{
						?>
						<div class="row">
							<div class="col-md-12 center-text">
								<p style="text-align: center; font-size: 15px; color: red;">You can't send message in this thread has been archived</p>
							</div>
						</div>
						<?php
					}
					else if(!empty($subject_info['Archived']))
					{
						?>
						<div class="row">
							<div class="col-md-12 center-text">
								<p style="text-align: center; font-size: 15px; color: red;">You can't send message here</p>
							</div>
						</div>
						<?php
					}
					else
					{
						?>
				            <input type="text" class="form-control input-sm" name="message" placeholder="Enter your message here.">
				            <span class="input-group-btn">
				                <button class="btn btn-primary btn-sm" type="submit">Send</button>
				            </span>
			        	<?php
			    	} ?>
			        </div>
			    </form>
			    
			</div>
		</div>			
    </div>
</div>
<script>
	window.onload=function()
	{
		get_messages();
		start();
	}
</script>