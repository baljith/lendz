<?php
$ControllerName = $this->router->fetch_class();
$FunctionName   = $this->router->fetch_method();		
?>
<div id="sidebar" class="sidebar">
	<div data-scrollbar="true" data-height="100%">
		<ul class="nav">
			<li class="nav-profile">
				<div class="image">
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
					<a href="<?php echo base_url('profile'); ?>"><img class="image_here" src="<?php echo $image; ?>" alt="" /></a>
				</div>
				<div class="info name_here">
					<?php echo $this->session->userdata('User_First_Name')." ".$this->session->userdata('User_Last_Name'); ?>
				</div>
			</li>
		</ul>
		
		<ul class="nav">
			<!-- <li class="nav-header">Navigation</li> -->
			<li <?php if($ControllerName=='dashboard'){  echo "class='active'"; } ?>><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if($this->session->userdata['Role'] == 0){?>
			<li class='has-sub <?php if($ControllerName=='category'){ echo "active"; } ?>'>
				<a href="javascript:;">
						<i class="fa fa-tasks"></i>
						 <b class="caret pull-right"></b>
						<span>Manage Category</span>
					</a>
					<ul class="sub-menu">
						<li <?php if($FunctionName=='add'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('category/add'); ?>">Add Category</a></li>
						<li <?php if($FunctionName=='index'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('category'); ?>">Category List</a></li>
					</ul>
			</li>
			<li class='has-sub <?php if($ControllerName=='products'){ echo "active"; } ?>'>
				<a href="javascript:;">
						<i class="fa fa-shopping-bag" aria-hidden="true"></i>
						 <b class="caret pull-right"></b>
						<span>Manage Products</span>
					</a>
					<ul class="sub-menu">
						<li <?php if($FunctionName=='index'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('products'); ?>">Product List</a></li>
						<!-- <li <?php if($FunctionName=='add'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('product/add'); ?>">Add Product</a></li> -->
					</ul>
			</li>
			<li class='has-sub <?php if($ControllerName=='users'){ echo "active"; } ?>'>
				<a href="javascript:;">
						<i class="fa fa-users" aria-hidden="true"></i>
						 <b class="caret pull-right"></b>
						<span>Manage Users</span>
					</a>
					<ul class="sub-menu">
						<li <?php if($FunctionName=='index'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('users'); ?>">User List</a></li>
						<!-- <li <?php if($FunctionName=='add'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('product/add'); ?>">Add Product</a></li> -->
					</ul>
			</li>
			<?php }?>
			

			<!-- <li <?php if($ControllerName=='chat'){  echo "class='active'"; } ?>><a href="<?php echo base_url('chat/messages'); ?>"><i class="fa fa-comments" aria-hidden="true"></i> <span>Messages</span></a></li>
			<?php if($this->session->userdata['Role'] != 0){?>

			<li <?php if($ControllerName=='users' && $FunctionName=='notifications'){  echo "class='active'"; } ?>><a href="<?php echo base_url('users/notifications'); ?>"><i class="fa fa-bell" aria-hidden="true"></i> <span>Notifications</span></a></li>
			<?php 
			} ?>

			<?php if($this->session->userdata['Role'] == 0){?>

			<li <?php if($ControllerName=='transactions'){  echo "class='active'"; } ?>><a href="<?php echo base_url('transactions'); ?>"><i class="fa fa-money" aria-hidden="true"></i> <span>Transactions</span></a></li>
			<?php 
			} ?> -->
				
			<!-- <?php 
				if($this->session->userdata("Role")==0)
				{
					?>
					<li <?php if($ControllerName=='profile'){  echo "class='active'"; } ?>><a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user" aria-hidden="true"></i> <span>My Profile</span></a></li>
					<?php
				}
				else
				{
					?>
					<li class='has-sub <?php if($ControllerName=='profile'){ echo "active"; } ?>'>
						<a href="javascript:;">
								<i class="fa fa-user" aria-hidden="true"></i> 
								 <b class="caret pull-right"></b>
								<span>My Profile</span>
							</a>
							<ul class="sub-menu">
								<li <?php if($ControllerName=='profile' && $FunctionName=='index'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('profile'); ?>">Personal Info</a></li>
								<li <?php if($ControllerName=='profile' && $FunctionName=='payment'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('profile/payment'); ?>">Payment Info</a></li>
								<li <?php if($ControllerName=='profile' && $FunctionName=='transactions'){  echo "class='active'"; }  ?>><a href="<?php echo base_url('profile/transactions'); ?>">Transaction History</a></li>
							</ul>
					</li>
					<?php
				}
			?>	 -->
			<li>
				<a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
			</li>
	    </ul>
	</div>
</div>
<div class="sidebar-bg"></div>