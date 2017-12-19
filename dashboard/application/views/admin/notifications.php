<div id="content" class="content header-sec">
	<div class="row">
		<div class="col-md-5 col-sm-12 col-lg-6 col-xs-12 header-left">
			    <span class="page-headers">Notifications 
			    <!-- 	<a href="javascript:;" class="btn btn-success btn-xs m-r-5 Notifications_counter2" style="display: none;"></a> -->
			    </span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active">Notifications</li>
				</ol>
		</div>
		<div class="col-md-7 col-sm-12 col-lg-6 col-xs-12 header-right">
			<ul class="top-link">
				<li><a href="javascript:void();" onclick="getData(0)"><i class="fa fa-refresh"></i> Refresh</a></li>
			</ul>
		</div>
	</div>
	
</div>
<hr class="horizental_line">
<div class="clear-fix"></div>
<div id="content" class="content pagecontent-sec">
	<div class="row">
	    <!-- begin col-12 -->
	    <div class="col-md-12">
	    	<?php 
	    	if(!empty($Noti_Id))
	    	{
	    		?>
	    		<div class="alert alert-warning fade in m-b-15" style="background: transparent; padding: 0px;">
	    			<span style="padding: 3px 11px;" class="close" data-dismiss="alert">×</span>
					<div class="note note-warning">
						<h4>Congratulations</h4>
						<p>
							<?php
								$noti_info = $this->common_model->get_data('notification',array('N_Id'=>$Noti_Id),'single');
								$user_info = $this->common_model->get_data('users',array('User_Id'=>$noti_info['Notification_From']),'single');
								 ?>
							<b><?php 
							echo $user_info['User_First_Name']." ".$user_info['User_Last_Name'];
							?></b> has been connected with you. Now you can see tool request sent by <?php echo $user_info['User_First_Name']." ".$user_info['User_Last_Name'] ?>. You can go from sidebar menus to find tools request of connected users.
						</p>
					</div>
				</div>
	    		<?php
	    	}
	    	?>
	        <div class="result-container">
                <div id="notifications_append_hre">
                    <!-- Message Content goes here -->
                </div>
            </div>
	    </div>
	    <!-- end col-12 -->
	</div>
</div>
<?php 
$this->ajax_pagination->getData();
?>
<script type="text/javascript">
    window.onload = function()
    {
        getData(0);
    }
</script>
