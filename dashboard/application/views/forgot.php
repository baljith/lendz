<?php get_header(); ?>
<style>
#masthead {
	background: #000;
}
</style>
    <div class="custom_page">
		<div class="container">
			<div class="row form-controler_space">
				<div class="form-controler">
				    <div class="form_desc_text mainHeading underlineCenter">
				    	<h1>Forgot Password</h1>
				    </div>
				    <?php 
					$flash = $this->session->flashdata('flash');
					if(!empty($flash['msg']) && !empty($flash))
					{
						?>
						<div class="alert alert-success fade in m-b-15">
							<strong>Success!</strong>
							<?php echo $flash['msg']; ?>
							<span class="close" data-dismiss="alert">×</span>
						</div>
						<?php
					}
					?>
					<form class="form-horizontal custom_form_style" method="post" action="">
						<div class="form-group">
							<div class="cols-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" name="User_Email"  placeholder="Email Address or Username*" id="User_Email" value="<?php echo set_value('User_Email') ?>"/>
									<span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
								<label class="error" for="User_Email"><?php echo form_error('User_Email'); ?></label>
							</div>
						</div>
						<div class="form-group ">
							<div class="forgate_password pull-right"><a href="<?php echo base_url('login'); ?>"><span class="red_font">Login here?</span></a></div>
						</div>
						<div class="form-group ">
							<button type="submit" class="btn  btn-lg btn-block form-submit-btn">Submit</button>
						</div>
					</form>
				</div>
				<div class="panel-heading_custom">
	               <div class="panel-title text-center">
	               		Dont't have an account? <a href="<?php echo base_url('register'); ?>"><span class="red_font">Sign Up </span></a>
	               	</div>
	            </div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
