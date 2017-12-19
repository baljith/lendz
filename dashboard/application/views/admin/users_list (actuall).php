<style>
.bootstrap-select .btn-default
{
	background: white !important;
    color: #a599b2 !important;
    border: 1px solid #cecece !important;
}
.custom-padding-class {
    padding: 0px 5px 0 0 !important;
}
.padding-right0 {
    padding: 0px !important;
}
</style>
<?php
$ControllerName = $this->router->fetch_class();
$FunctionName   = $this->router->fetch_method();		
?>
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers"><?php if($FunctionName=='connected'){ echo"Connected " ; } echo ucfirst($usertype); ?> (List)</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active"><?php if($FunctionName=='connected'){ echo"Connected " ; } echo ucfirst($usertype); ?></li>
				</ol>
		</div>
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
		
		</div>
	</div>
</div>
<hr class="horizental_line">
<div id="content" class="content">
	<div class="search_form">
		<form id="user_filters" onsubmit="getData(0);return false;">
			
			<?php 
				if($this->session->userdata('Role')!=3){
	        ?>
			
	           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12  res-m-b-10 custom-padding-class">
	           		<input type="hidden" name="usertype" value="<?php if(!empty($usertype)) {echo $usertype; } ?>">
	           		<select class="form-control height-40 selectpicker" data-live-search="true" multiple name="address[]" title="Filter by Zip code">
		           		<?php 
		           		if(!empty($get_zip_codes)){
		           			foreach($get_zip_codes as $zip){
		           				?>
		           				<option value="<?php echo $zip; ?>"><?php echo $zip; ?></option>
		           				<?php
		           			}
		           		}
		           		?>
	           		</select>
	           </div>
	           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12  res-m-b-10 custom-padding-class">
	           		<input type="text" class="form-control height-40" name="user_name" placeholder="Name">
	           </div>
			
			
				<div class="col-lg-3 col-md-7 col-sm-7 col-xs-12  res-m-b-10 custom-padding-class">
	            
	                <div class="input-group default-daterange">
                        <span class="input-group-btn">
                            <button class="btn btn-default height-40 btn-add-on" type="button">
                                <i class="fa fa-calendar">
                                </i>
                            </button>
                        </span>
                        <input class="form-control height-40" name="daterange" placeholder="click to select the date range" type="text" value=""/>
                    </div>
                	
	            </div>
				<div class="col-lg-3 custom-padding-class col-md-5 col-sm-5 col-xs-12 padding-right0 res-padding-left0 res-m-b-10">
		           <button class="btn custom-button btn-search" type="submit">Search</button>
		       	</div>
			
			<?php
				}else{
			?>
           
           	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 custom-padding-class res-m-b-10">
           		<input type="hidden" name="usertype" value="<?php if(!empty($usertype)) {echo $usertype; } ?>">
           		<select class="form-control height-40 selectpicker" data-live-search="true" multiple name="address[]" title="Filter by Zip code">
	           		<?php 
	           		if(!empty($get_zip_codes)){
	           			foreach($get_zip_codes as $zip){
	           				?>
	           				<option value="<?php echo $zip; ?>"><?php echo $zip; ?></option>
	           				<?php
	           			}
	           		}
	           		?>
           		</select>
           	</div>

           	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 custom-padding-class res-m-b-10">
           		<input type="text" class="form-control height-40" name="user_name" placeholder="Name">
           	</div>

			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 padding-right0 res-padding-left0 res-m-b-10">
	           <button class="btn custom-button btn-search" type="submit">Search</button>
	       	</div>
			
           	<?php
           		}
           	?>
		</form>   
	</div>
</div>
<div class="clearfix"></div>
<div id="content" class="content">
	<div class="row" id="usersList">
		
	</div>
</div>

<?php 
$this->ajax_pagination->getData();
?>
<script type="text/javascript">
	window.onload = function()
	{
		getData('0');
	}
</script>