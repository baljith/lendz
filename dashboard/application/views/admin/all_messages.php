<div id="content" class="content header-sec">
	<div class="row">
		<div class="col-md-5 col-sm-12 col-lg-6 col-xs-12 header-left">
			    <span class="page-headers">All threads
			    	<a href="javascript:;" class="btn btn-success btn-xs m-r-5 Notifications_counter2" style="display: none;"></a>
			    </span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active">
						<a href="javascript:;">
							<?php echo $user_info['User_First_Name']." ".$user_info['User_Last_Name']; ?>
						</a>
					</li>
					<li class="active">All threads</li>
				</ol>
		</div>
		<div class="col-md-7 col-sm-12 col-lg-6 col-xs-12 header-right">
			<!-- <ul class="top-link">
				<li><a href="javascript:void();" onclick="getData(0)"><i class="fa fa-refresh"></i> Refresh</a></li>
				<li>
				<li id="show_archive"><a style="cursor: pointer;" type="button">Show Archive</a></li>
				<li>
				<a href="#modal-alert" data-toggle="modal"><i class="fa fa-inbox"></i> New Message</a>
				</li>
			</ul> -->
		</div>
	</div>
</div>
<hr class="horizental_line">
<div class="clear-fix"></div>
<div id="content" class="content pagecontent-sec">
	<div class="row">
	    <!-- begin col-12 -->
	    <div class="col-md-12">
	        <div class="result-container">
            <form id="Message_Filters" onsubmit="getData(0);return false;">
	            <div class="input-group m-b-20">
	            	<input type="hidden" value="0" name="archive" id="archive_input">
	            	<input type="hidden" name="User_Id" value="<?php echo $user_info['User_Id']; ?>">
                    <!-- <div class="input-group-btn">
                        <button type="button" onclick="getData(0);" class="btn btn-inverse"><i class="fa fa-search"></i> Search</button>
                    </div> -->
                </div>
            </form>
                <div id="message_append_hre">
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
