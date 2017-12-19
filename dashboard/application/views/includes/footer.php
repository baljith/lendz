	</div>
<style>
	.ui-autocomplete
	{
		z-index: 100000;
	}
</style>
<!-- #modal-alert -->
<div class="modal fade" id="modal-alert">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="" id="create_thread_here" method="post" class="form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Compose a new message</h4>
			</div>
			<div class="modal-body">
				<div class="form-group" style="margin-bottom: 7px;">
                  	<label class="col-lg-2 control-label text-right">To</label>
                  	<div class="col-lg-10">
                     	<input type="hidden" id="user_id" name="user_id" value="">
						<input type="text" id="individual_autocomplete" name="individual_autocomplete" class="form-control" value="" name="term" placeholder="Search a user to chat">
						<label id="individual_autocomplete-error" class="error" for="individual_autocomplete" style="visibility: visible;"></label>
                  	</div>
              </div>
              <div class="form-group" style="margin-bottom: 7px;">
                  	<label class="col-lg-2 control-label text-right">Subject</label>
                  	<div class="col-lg-10">
						<input type="text" id="subject" class="form-control" value="" name="subject" placeholder="Enter a subject">
						<label id="subject-error" class="error" for="subject" style="visibility: visible;"></label>
                  	</div>
              </div>
              <div class="form-group" style="margin-bottom: 7px;">
                  	<label class="col-lg-2 control-label text-right">Message</label>
                  	<div class="col-lg-10">
						<textarea name="message" id="message" class="form-control" rows="3" placeholder="Enter your message"></textarea>
						<label id="message-error" class="error" for="message" style="visibility: visible;"></label>
                  	</div>
              </div>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
				<button  type="submit" id="create_thread_btn_submit" class="btn btn-sm btn-success">Submit</button>
			</div>
		</form>
		</div>
	</div>
</div>
	<?php 
	$ControllerName = $this->router->fetch_class();
	$FunctionName = $this->router->fetch_method();
	?>
	<!-- end page container -->
	<script>
	var ajax_url = '<?php echo base_url(); ?>';
	</script>
	<!-- ================== BEGIN BASE JS ================== -->
	
	<script src="<?php echo base_url('assets/plugins/jquery/jquery-migrate-1.1.0.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>  
	<!--[if lt IE 9]>
		<script src="<?php echo base_url('assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo base_url('assets/crossbrowserjs/respond.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/crossbrowserjs/excanvas.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/select2/dist/js/select2.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/sticky_table/jquery.stickytable.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?php echo base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>

	 <script src="<?php  echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>">
        </script>
        <script src="<?php echo base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>

	<script src="<?php echo base_url('assets/js/table-manage-responsive.demo.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/apps.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/ladda-bootstrap/dist/spin.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/ladda-bootstrap/dist/ladda.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins\jquery-validation\dist\jquery.validate.min.js'); ?>"></script>
	<!-- <script src="<?php echo base_url('assets/plugins\jquery-validation\dist\jadditional-methods.min.js'); ?>"></script> -->
	<script src="<?php  echo base_url('assets/js/jquery-confirm.min.js'); ?>"></script>
	<script src="<?php  echo base_url('assets/plugins/bootstrap-daterangepicker/moment.js'); ?>"></script>
	<script src="<?php  echo base_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/dateformat.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/custom/common.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/custom/'.$ControllerName.'.js'); ?>"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
	<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		$(document).ready(function() {
			App.init();
			
		});
	</script>
</body>
</html>
