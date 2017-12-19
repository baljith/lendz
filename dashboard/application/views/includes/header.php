<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title><?php echo 'LendzApp'; ?></title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/logo/favicon.ico'); ?>"/>
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="<?php echo base_url('assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<!-- <link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" /> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link href="<?php echo base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style2.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/select2/dist/css/select2.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/sticky_table/jquery.stickytable.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/style-responsive.min.css'); ?>" rel="stylesheet" />
	<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/theme/red.css'); ?>" rel="stylesheet" id="theme" />
	<link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css');?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-confirm.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>">
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?php echo base_url('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/datepicker.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
	<link href="<?php echo base_url('assets/plugins/ladda-bootstrap/dist/ladda-themeless.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css'); ?>" rel="stylesheet"/>
	<link href="https://unpkg.com/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://unpkg.com/bootstrap-switch"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
<style>
.ui-autocomplete-loading { background:url('<?php echo base_url('assets/img/Eclipse.gif'); ?>') no-repeat right center;    background-size: 32px; }

    .cssload-container {
	width: 100%;
	height: 44px;
	text-align: center;
}

.message
{
	    word-break: break-word;
    white-space: pre;
}

.cssload-zenith {
	left: 50%;
    top: 50%;
    position: absolute;
	width: 44px;
	height: 44px;
	margin: 0 auto;
	border-radius: 50%;
	border-top-color: transparent;
	border-left-color: transparent;
	border-right-color: transparent;
	box-shadow: 3px 3px 1px rgb(17,162,217);
	animation: cssload-spin 1050ms infinite linear;
		-o-animation: cssload-spin 1050ms infinite linear;
		-ms-animation: cssload-spin 1050ms infinite linear;
		-webkit-animation: cssload-spin 1050ms infinite linear;
		-moz-animation: cssload-spin 1050ms infinite linear;
}



@keyframes cssload-spin {
	100%{ transform: rotate(360deg); transform: rotate(360deg); }
}

@-o-keyframes cssload-spin {
	100%{ -o-transform: rotate(360deg); transform: rotate(360deg); }
}

@-ms-keyframes cssload-spin {
	100%{ -ms-transform: rotate(360deg); transform: rotate(360deg); }
}

@-webkit-keyframes cssload-spin {
	100%{ -webkit-transform: rotate(360deg); transform: rotate(360deg); }
}

@-moz-keyframes cssload-spin {
	100%{ -moz-transform: rotate(360deg); transform: rotate(360deg); }
}

</style>
<div id="pagination_loader" style="display: none">
	<div class="cssload-container"> <div class="cssload-zenith"></div></div>
</div>
	<!-- <div id="page-loader" class="fade in"><span class="spinner"></span></div> -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="<?php echo base_url(); ?>" class="navbar-brand">
						<span class="navbar-logo">
							<img src="<?php echo base_url('assets/img/logo/dashboard_header_logo_2.png'); ?>" alt="navbar logo" class="img-circle"/>
						</span> 
						<?php echo 'LendzApp'; ?>
						<div class="clearfix"></div>
					</a>
					
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<ul class="nav navbar-nav navbar-right">
				<?php if($this->session->userdata['Role'] != 0){?>
					<li class="dropdown">
						<a href="javascript:;" id="load_notifications" data-toggle="dropdown" class="dropdown-toggle f-s-14" aria-expanded="false">
							<i class="fa fa-bell-o"></i>
							<span class="label Notifications_counter" style="display: none;" id="">0</span>
						</a>
						<ul class="dropdown-menu  media-list pull-right animated fadeInDown" id="my_notifications" style="    min-height: 130px;max-height: 300px;overflow: auto;">
                            <div class="cssload-container"> <div class="cssload-zenith" style="left: 36%; top: 36%;"></div></div>
                        </ul>
					</li>
				<?php } ?>
					<li class="dropdown">
						<!-- <a href="javascript:;" id="load_notification_messages" data-toggle="dropdown" class="dropdown-toggle f-s-14" aria-expanded="false">
							<i class="fa fa-envelope"></i>
							<span class="label Messages_counter" style="display: none;" id="">0</span>
						</a> -->
						<ul class="dropdown-menu  media-list pull-right animated fadeInDown" id="my_messages" style="    min-height: 130px;max-height: 300px;overflow: auto;">
                            <div class="cssload-container"> <div class="cssload-zenith" style="left: 36%; top: 36%;"></div></div>
                        </ul>
					</li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<?php 
							if($this->session->userdata('User_Image'))
							{
								$image = base_url('assets/upload/profile_pictures/'.$this->session->userdata('User_Image'));
							}
							else
							{
								$image = base_url('assets/dummy/no-user.png');
							}
							?>
							<img class="image_here" src="<?php echo $image; ?>" alt="" /> 
						
							<span class="hidden-xs hidden-sm name_here">
								<?php echo $this->session->userdata('User_First_Name')." ".$this->session->userdata('User_Last_Name'); ?>
							</span> 
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="<?php echo base_url('profile'); ?>">Edit Profile</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url('login/logout'); ?>">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>