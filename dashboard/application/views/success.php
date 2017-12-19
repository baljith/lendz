<?php get_header(); ?>
<style>
#masthead {
	background: #000;
}
.success-log{padding: 10px 29px;border: 0;font-size: 18px;margin: 20px 0;background: #eb1515 none repeat scroll 0 0;border-color: #eb1515 !important;border-radius: 30px;}
@media(min-width: 768px){
.succes-bg{background: #ffffff;margin-top: 78px;}
}
</style>
    <div class="custom_page">
		<div class="container">
			<div class="row text-center form-controler_space" style="padding-top: 100px;">
				<?php 
				if($this->session->flashdata('flash_msg'))
				{
					$flash = $this->session->flashdata('flash_msg');
					?>
						<div class="col-sm-6 col-sm-offset-3 succes-bg">
				        	<br><br>
				        	<h2 style="color:#0fad00;position: relative;     font-family: Averta Demo;   margin-top: 0;" class="succes-border">Registered Successfully</h2>
				        	<img src="<?php echo base_url('assets/dummy/check.png'); ?>" style="width: 100px;">
				        	<h3 style="font-family: Averta Demo;"><?php echo $flash['name']; ?></h3>
				        	<p style="font-size:20px;color:#5C5C5C;font-family: Averta Demo;"><?php echo $flash['desc']; ?></p>
				        	<a href="<?php echo base_url('login'); ?>" class="btn btn-danger success-log">Log in</a>
				    		<br><br>
				        </div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
