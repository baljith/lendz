		
		<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class=""><a href="<?php echo base_url('products'); ?>">Product list</a></li>
				<li class="active">View Product</li>
			</ol>
			<h1 class="page-header">View Product</small></h1>
			<div class="row">
				<form action="/" method="POST" id="add_package_form">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-inverse">
	                        <div class="panel-body">
	                            <fieldset>
	                            	<h2 style="margin-top: 32px; font-size: 21px; border-bottom: 1px solid #e2e7eb; padding-bottom: 7px;">Product Detail</h2>
	                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<ol class="technical_list">
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>Product Name:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
						                                <span class="list-sub-text"><?php echo $product_list->Product_Name; ?></span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>Product Rent:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php echo '$'.$product_list->Product_Rent; ?> </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>Product Description: </span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php echo $product_list->Product_Description; ?> </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>Product Status: </span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text" style="color: white !important;" id="pro_status"> <?php if($product_list->Status == 'Approved') { echo '<span class="badge badge-pill badge-success">Approved</span>'; } else if($product_list->Status == 'Pending'){ echo '<span class="badge badge-pill badge-info">Pending</span>';  } else  {echo '<span class="badge badge-pill badge-danger">Unapproved</span>'; } ?> </span>
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
														<span>User Name:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
						                                <span class="list-sub-text"><?php echo $product_list->Username; ?> </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>User Email:</span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"><?php echo $product_list->User_Email; ?> </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head col-xs-6 col-sm-5">
														<span>Product Category: </span>
													</div>
													<div class="col-md-7 col-xs-6 col-sm-7">
					                                    <span class="list-sub-text"> <?php echo $product_list->Name; ?>  </span>
													</div>
												</div>
											</li>
										</ol>
	                                </div>                                 
                                </fieldset>
	                        </div>
	                        <div class="col-lg-12">
	                       		
	                       	<h1 class="page-header" style="margin-top: 10px;padding: 0 15px;">Product Images</h1>
	                        <?php if($product_images){foreach ($product_images as $data) {?>
		                   		
                               
                            	<div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                    <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="Im so nice" data-caption="And if there is money left, my girlfriend will receive this car" data-image="<?php echo base_url('assets/upload/product_img/'.$data['Product_Image']); ?>" data-target="#image-gallery">
                                        <img class="img-responsive" src="<?php echo base_url('assets/upload/product_img/'.$data['Product_Image']); ?>" alt="Another alt text">
                                    </a>
                               	</div>
		                    	
		                    <?php }} ?>
		                    </div>
		                    		
		                    	 	
		                  
                          
	                        <div class="col-md-12 col-sm-12 col-xs-12 text-center m-t-20">
								<button type=button class="btn btn-lg btn-info m-r-5 active1"  rel="<?php echo $product_list->Id; ?>" data-status="Approved">Approved <div class="loader hide"></div></button>
								<button  type=button class="btn btn-lg btn-info m-r-5 deactive" rel="<?php echo $product_list->Id; ?>" data-status="Unapproved">Unapproved <div class="loader hide"></button>
							</div>
	                    </div>
					</div>
				</form>

			</div>
			<div class="row">

				   

				<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			               <!--  <h4 class="modal-title" id="image-gallery-title"></h4> -->
			            </div>
			            <div class="modal-body">
			                <img id="image-gallery-image" class="img-responsive" src="">
			            </div>
			            <div class="modal-footer">

			                <div class="col-md-2">
			                    <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>
			                </div>

			                <div class="col-md-8 text-justify">
			                   
			                </div>

			                <div class="col-md-2">
			                    <button type="button" id="show-next-image" class="btn btn-default">Next</button>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>

		</div>
		<?php if($product_list->Status == 'Approved') { ?>
			<script type="text/javascript">
				$('.active1').hide();
			</script>
		<?php }?>
		<?php if($product_list->Status == 'Unapproved') { ?>
			<script type="text/javascript">
				$('.deactive').hide();
			</script>
		<?php }?>
		<script type="text/javascript">
			
			$('.m-r-5').click(function(){
				var that = $(this);
				that.find('.loader').removeClass("hide");
				var id_sent = $(this).attr('rel');
				var info = $(this).data("status");
				$.ajax({
			        url: ajax_url+'products/productApprovel',
			        type:'POST',
			        dataType: 'json',
			        data:{
			            'id':id_sent,'Status':info
			        },
			        success:function(data)
			        {	
			        	that.find('.loader').addClass("hide");
			            if(info == 'Approved') {
							$('.deactive').show();
							$('.active1').hide();
							$('#pro_status').html('').append('<span class="badge badge-pill badge-info">Approved</span>');
						} else {
							$('.deactive').hide();
							$('.active1').show();
							$('#pro_status').html('').append('<span class="badge badge-pill badge-info">Unapproved</span>');
						}

			            $("html, body").animate(
			            {
			                scrollTop: 0
			            }, "slow");
			            if (data['status'])
			            {
			                msg_div(data['status'], data['msg']);

			            }
			            else
			            {
			                msg_div(data['status'], data['msg']);
			            }
			        }
			    })
			})
			loadGallery(true, 'a.thumbnail');

		    //This function disables buttons when needed
		    function disableButtons(counter_max, counter_current){
		        $('#show-previous-image, #show-next-image').show();
		        if(counter_max == counter_current){
		            $('#show-next-image').hide();
		        } else if (counter_current == 1){
		            $('#show-previous-image').hide();
		        }
		    }

		    /**
		     *
		     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
		     * @param setClickAttr  Sets the attribute for the click handler.
		     */

		    function loadGallery(setIDs, setClickAttr){
		        var current_image,
		            selector,
		            counter = 0;

		        $('#show-next-image, #show-previous-image').click(function(){
		            if($(this).attr('id') == 'show-previous-image'){
		                current_image--;
		            } else {
		                current_image++;
		            }

		            selector = $('[data-image-id="' + current_image + '"]');
		            updateGallery(selector);
		        });

		        function updateGallery(selector) {
		            var $sel = selector;
		            current_image = $sel.data('image-id');
		            $('#image-gallery-caption').text($sel.data('caption'));
		            $('#image-gallery-title').text($sel.data('title'));
		            $('#image-gallery-image').attr('src', $sel.data('image'));
		            disableButtons(counter, $sel.data('image-id'));
		        }

		        if(setIDs == true){
		            $('[data-image-id]').each(function(){
		                counter++;
		                $(this).attr('data-image-id',counter);
		            });
		        }
		        $(setClickAttr).on('click',function(){
		            updateGallery($(this));
		        });
		    }
		</script>