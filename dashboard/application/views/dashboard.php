<div id="content" class="content dashboard-main">
	<div class="header-sec">
		<div class="col-lg-12 header-left no-pad">
		  <h1 class="page-header">Dashboard <small>Welcome to <?php echo 'LandzApp'; ?></small></h1>
			<ol class="breadcrumb">
				<li><a href="javascript:;">Home</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div>

	</div>
	<hr style="border-top: 1px solid #ccc;margin-top: 8px;">
	<?php
if ($this->session->userdata('Role') == 0)
{
    ?>
		<div class="row">
			<div class="col-md-4 col-sm-6">
		        <div class="widget widget-stats bg-red">
		            <div class="stats-icon stats-icon-lg"><i class=""><img src="<?php echo base_url('assets/img/technician.png'); ?>" alt=""></i></div>
		            <div class="stats-title">Total Category</div>
		            <div class="stats-number"><?php echo (!empty($Role['category']))?$Role['category']:'0'; ?></div>
		            <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 70.1%;"></div>
                    </div>
                    <div class="stats-desc">
                    	<a href="<?php echo base_url('category'); ?>">View Details</a>
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>
		        </div>
		    </div>
			<div class="col-md-4 col-sm-6">
		        <div class="widget widget-stats bg-blue" style="background-color: #11A2D9 !important;">
		            <div class="stats-icon stats-icon-lg"><i class=""><img src="<?php echo base_url('assets/img/shop.png'); ?>" alt=""></i></div>
		            <div class="stats-title">Total Products</div>
		            <div class="stats-number"><?php echo (!empty($Role['products']))?$Role['products']:'0'; ?></div>
		            <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 70.1%;"></div>
                    </div>
                    <div class="stats-desc">
                    	<a href="<?php echo base_url('products'); ?>">View Details</a>
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>
		        </div>
		    </div>
		    <div class="col-md-4 col-sm-6">
		        <div class="widget widget-stats bg-green">
		            <div class="stats-icon stats-icon-lg"><i class=""><img src="<?php echo base_url('assets/img/truck.png'); ?>" alt=""></i></div>
		            <div class="stats-title">Total LandzApp Users</div>
		            <div class="stats-number"><?php echo (!empty($Role['total_users']))?$Role['total_users']:'0'; ?></div>
		            <div class="stats-progress progress">
                        <div class="progress-bar" style="width: 70.1%;"></div>
                    </div>
                    <div class="stats-desc">
                    	<a href="<?php echo base_url('users'); ?>">View Details</a>
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>
		        </div>
		    </div>
		</div>
	<?php
}
else
{
   
}
?>
	<!-- begin row -->
	<div class="row">
		<?php 
		if ($this->session->userdata('Role') == 0)
		{
			?>
			<!-- begin col-8 -->
			<div class="col-md-12">
				<div class="panel panel-inverse" data-sortable-id="index-1">
					<div class="panel-heading">
						<h4 class="panel-title">Users Currently Registered <span>( Last 10 Days )	</span></h4>
					</div>
					<div class="panel-body">
						<div id="interactive-chart" class="height-sm"></div>
					</div>
				</div>
			</div>
			<!-- end col-8 -->
			<?php
		}
		else
		{
			?>
			<!-- begin col-8 -->
			<!-- <div class="col-md-12">
				<div class="panel panel-inverse" data-sortable-id="index-1">
					<div class="panel-heading">
						<h4 class="panel-title">Need and Want Requests Analytics ( Last 10 Days )</h4>
					</div>
					<div class="panel-body">
						<div id="interactive-chart" class="height-sm"></div>
					</div>
				</div>
			</div> -->
			<!-- end col-8 -->
			<?php
		}
		?>
	</div>
	<!-- end row -->
	<!-- <div class="row">
		<div class="col-md-4">
			<div class="panel panel-inverse" data-sortable-id="index-7">
				<div class="panel-heading">
					<h4 class="panel-title">Request for Repair Tools</h4>
				</div>
				<div class="panel-body">
					<div id="donut-chart" class="height-sm"></div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-inverse" data-sortable-id="index-5">
				<div class="panel-heading">
					<h4 class="panel-title"><span style="">Message</span>
						<a href="<?php echo base_url('chat/messages'); ?>" class=" Notifications_counter2" style="display: none;position: absolute; top: 8px; left: 91px; background: red; border-radius: 4px; padding: 2px 7px;"></a></h4> </div>
				<div class="panel-body">
					<div class="height-sm" data-scrollbar="true">
						<ul class="media-list media-list-with-divider media-messaging" id="all_messages">
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
											<span style="float: right;font-size: 13px;"><i class="fa fa-clock-o"></i>&nbsp;<?php echo date_visible($msg['Date']); ?></span>
										</h5>
										<p><?php echo (strlen($msg['Message'])>70)?substr($msg['Message'],0,70)."...":$msg['Message']; ?></p>
										</a>
									</div>                       
						        </li> 
								<?php
							}
						}
						else{
							echo "<li style='font-size:20px;text-align:center'>No Messages</li>";
						}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> -->
</div>


<!-- ================== BEGIN PAGE LEVEL JS ================== -->

<!-- <script src="assets/plugins/gritter/js/jquery.gritter.js"></script> -->
<script src="assets/plugins/flot/jquery.flot.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- <script src="assets/plugins/sparkline/jquery.sparkline.js"></script> -->
<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script>
var handleInteractiveChart = function (){
	"use strict";
    function showTooltip(x, y, contents){
        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
            top: y - 45,
            left: x - 55
        }).appendTo("body").fadeIn(200);
    }
	if ($('#interactive-chart').length !== 0) {
		<?php
		if(isset($chart_users))
		{
			?>
			var data1 = $.parseJSON('<?php echo json_encode($chart_users['total_users']); ?>');
	        // data1 =
	        var data2 = $.parseJSON('<?php echo json_encode($chart_users['verified_user']); ?>');

	        var data3 = $.parseJSON('<?php echo json_encode($chart_users['unverified_user']); ?>');
	        var xLabel = $.parseJSON('<?php echo json_encode($chart_users['labels']); ?>');
	        $.plot($("#interactive-chart"), [
	                {
	                    data: data1,
	                    label: "Total Registed Users",
	                    color: '#11A2D9',
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: true, radius: 3, fillColor: '#fff' },
	                    shadowSize: 0
	                },
	                {
	                    data: data2,
	                    label: 'Verified Users',
	                    color: 'green',
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: true, radius: 3, fillColor: '#fff' },
	                    shadowSize: 0
	                },
	                {
	                    data: data3,
	                    label: 'Unverified Users',
	                    color: 'red',
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: true, radius: 3, fillColor: '#fff' },
	                    shadowSize: 0
	                }
	            ],
	            {
	                xaxis: {  ticks:xLabel, tickDecimals: 0, tickColor: '#ddd' },
	                yaxis: {  ticks: 10, tickColor: '#ddd', min: 0, max: '<?php echo $chart_users['max_value']; ?>' },
	                grid: {
	                    hoverable: true,
	                    clickable: true,
	                    tickColor: "#ddd",
	                    borderWidth: 1,
	                    backgroundColor: '#fff',
	                    borderColor: '#ddd'
	                },
	                legend: {
	                    labelBoxBorderColor: '#ddd',
	                    margin: 10,
	                    noColumns: 1,
	                    show: true
	                }
	            }
	        );
			<?php
		}
		else
		{
			?>
			var data1 = $.parseJSON('<?php echo json_encode($chart_requests['needed']); ?>');
	        // data1 =
	        var data2 = $.parseJSON('<?php echo json_encode($chart_requests['wanted']); ?>');
	        var xLabel = $.parseJSON('<?php echo json_encode($chart_requests['labels']); ?>');
	        $.plot($("#interactive-chart"), [
	                {
	                    data: data1,
	                    label: "Need Request",
	                    color: 'red',
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: true, radius: 3, fillColor: '#fff' },
	                    shadowSize: 0
	                },
	                {
	                    data: data2,
	                    label: 'Want Request',
	                    color: 'green',
	                    lines: { show: true, fill:false, lineWidth: 2 },
	                    points: { show: true, radius: 3, fillColor: '#fff' },
	                    shadowSize: 0
	                }
	            ],
	            {
	                xaxis: {  ticks:xLabel, tickDecimals: 0, tickColor: '#ddd' },
	                yaxis: {  ticks: 10, tickColor: '#ddd', min: 0, max: '<?php echo $chart_requests['max_value']; ?>' },
	                grid: {
	                    hoverable: true,
	                    clickable: true,
	                    tickColor: "#ddd",
	                    borderWidth: 1,
	                    backgroundColor: '#fff',
	                    borderColor: '#ddd'
	                },
	                legend: {
	                    labelBoxBorderColor: '#ddd',
	                    margin: 10,
	                    noColumns: 1,
	                    show: true
	                }
	            }
	        );
			<?php
		}
		?>
        var previousPoint = null;
        $("#interactive-chart").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint !== item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(2);

                    var content = item.series.label + " " + y;
                    showTooltip(item.pageX, item.pageY, content);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;
            }
            event.preventDefault();
        });
    }
};
var handleDonutChart = function () {
	"use strict";
	if ($('#donut-chart').length !== 0) {
        var donutData = $.parseJSON('<?php echo json_encode($chart_warranty_tools); ?>');
		$.plot('#donut-chart', donutData, {
			series: {
				pie: {
					innerRadius: 0.5,
					show: true,
					label: {
						show: true
					}
				}
			},
			legend: {
				show: true
			}
		});
    }
};
handleInteractiveChart();
handleDonutChart();
</script>
<!-- 	<script src="assets/js/dashboard.js"></script>
<script src="assets/js/apps.min.js"></script> -->

<!-- ================== END PAGE LEVEL JS ================== -->