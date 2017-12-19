<style type="text/css">
	.icon-wrapper {
	    width: 75px;
	    height: 75px;
	    background: red;
	    border-radius: 50%;
	    color: #fff;
	    display: inline-block;
	    text-align: center;
	}
	.icon-wrapper i.fa.fa-cog {
	    font-size: 41px;
	    position: relative;
	    top: 16px;
	}
</style>
<?php
/*
echo '<pre>';
print_r($title);die(); */
?>
<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers"><?php echo $title ?> (List)</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active"><?php echo ucfirst($title); ?></li>
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
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-l-0 res-class-left-0">
	         <!--   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 custom-padding-class  res-m-b-10">
		           <input type="text" class="form-control height-40" name="User_Buisness_Address" placeholder="Address">
		       	</div> -->
	            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 custom-padding-class res-m-b-10">
		            <input type="hidden" name="usertype" value="<?php if(!empty($usertype)) {echo $usertype; } ?>">
		           <input type="hidden" name="tool_type" value="<?php if(!empty($tool_type)) {echo $tool_type; } ?>">
		           <input type="text" class="form-control height-40" name="Description" placeholder="Title">
	           </div>
	           
	        </div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 custom-padding-class">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 custom-padding-class res-m-b-10">
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
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 padding-right0 res-padding-left0 res-m-b-10">
		           <button class="btn custom-button btn-search" type="submit">Search</button>
		       	</div>
			</div>
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