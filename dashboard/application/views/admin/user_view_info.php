<div id="content" class="content">
	<ol class="breadcrumb pull-right">
		<li><a href="<?php echo base_url(); ?>">Home</a></li>
		<li class=""><a href="<?php echo base_url('users'); ?>">User list</a></li>
		<li class="active">View User</li>
	</ol>
	<h1 class="page-header">View User</small></h1>
	<div class="row">
		<form action="/" method="POST" id="add_package_form">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-inverse">
                    <div class="panel-body">
                        <fieldset>
                        	<h2 style="margin-top: 32px; font-size: 21px; border-bottom: 1px solid #e2e7eb; padding-bottom: 7px;">User Detail</h2>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<ol class="technical_list">
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User First Name:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
				                                <span class="list-sub-text"><?php echo $user_detail['User_First_Name']; ?></span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Email:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo $user_detail['User_Email']; ?> </span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Phone Number: </span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo $user_detail['User_Phone']; ?> </span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Account Status: </span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text" style="color: white !important;" id="pro_status"> <?php if($user_detail['Verified'] == 1) { echo '<span class="badge badge-pill badge-success">Verified</span>'; } else {echo '<span class="badge badge-pill badge-info">Not Verified</span>'; } ?> </span>
											</div>
										</div>
									</li>
								</ol>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<ol class="technical_list">
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Last Name:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
				                                <span class="list-sub-text"><?php echo $user_detail['User_Last_Name']; ?> </span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>Username:</span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"><?php echo $user_detail['Username']; ?> </span>
											</div>
										</div>
									</li>
									<li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Address: </span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <span class="list-sub-text"> <?php echo $user_detail['User_Address']; ?>  </span>
											</div>
										</div>
									</li>
									<!-- <li>
										<div class="row">
											<div class="col-md-5 list-head col-xs-6 col-sm-5">
												<span>User Profile Image: </span>
											</div>
											<div class="col-md-7 col-xs-6 col-sm-7">
			                                    <div class="image">
			                                    	<!-- <?php $image = base_url('assets/upload/profile_pictures/'.$user_detail['User_Image']);  ?>
													<img class="img-circle" src="<?php echo $image; ?>" alt="" height="80" width="80"> -->
												</div>
											</div>
										</div>
									</li> -->
								</ol>
                            </div>                             
                        </fieldset>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 text-center m-t-20">
                    	<button type=button class="btn btn-lg btn-info m-r-5 active1" rel="<?php echo $user_detail['User_Id']; ?>" data-status="1">Activate</button>
					
						<button  type=button class="btn btn-lg btn-info m-r-5 deactive" rel="<?php echo $user_detail['User_Id']; ?>" data-status="0">Deactivate</button>
					</div>
                </div>
			</div>
		</form>
	</div>
</div>
<?php if($user_detail['Verified'] == '0') { ?>
	<script type="text/javascript">
		$('.deactive').hide();
	</script>
<?php } else {?>
	<script type="text/javascript">
		$('.active1').hide();
	</script>
<?php }?>
<script type="text/javascript">
	
	$('.m-r-5').click(function(){
		$(this).attr('disabled',true);
		var id_sent = $(this).attr('rel');
		var info = $(this).data("status");
		console.log(id_sent);
		console.log(info);
		// $.ajax({
	 //        url: ajax_url+'users/changeStatus',
	 //        type:'POST',
	 //        dataType: 'json',
	 //        data:{
	 //            'User_Id':id_sent,'Verified':info
	 //        },
	 //        success:function(data)
	 //        {
	            
	 //            if(info == '1') {
		// 			$('.deactive').show();
		// 			$('.active1').hide();
		// 			$('#pro_status').html('').append('<span class="badge badge-pill badge-success">Verified</span>');
		// 		} else {
		// 			$('.deactive').hide();
		// 			$('.active1').show();
		// 			$('#pro_status').html('').append('<span class="badge badge-pill badge-info">Not Verified</span>');
		// 		}
	 //            $("html, body").animate(
	 //            {
	 //                scrollTop: 0
	 //            }, "slow");
	 //            if (data['status'])
	 //            {
	 //                msg_div(data['status'], data['msg']);

	 //            }
	 //            else
	 //            {
	 //                msg_div(data['status'], data['msg']);
	 //            }
	 //        }
	 //    })
	})
</script>