<div id="content" class="content">
	<div class="row">
		<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
			    <span class="page-headers">Need Requests (List)</span>
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active"> Need Requests</li>
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
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 p-l-0">
	           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 custom-padding-class">
	           		<select data-style="btn-white" class="form-control selectpicker" data-live-search="true">
						<option>Filter</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
					</select>
	           </div>
	           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 custom-padding-class">
	           		<select data-style="btn-white" class="form-control selectpicker" data-live-search="true">
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
					</select>
	           </div>
	           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 custom-padding-class">
	             <select data-style="btn-white" class="form-control selectpicker" data-live-search="true">
				        <option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
						<option>Demo 1</option>
					</select>
	           </div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 custom-padding-class">
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 custom-padding-class">
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
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 padding-right0">
		           <button class="btn custom-button btn-search" type="submit">Search</button>
		       	</div>
			</div>
		</form>   
	</div>
</div>
<div class="clear-fix"></div>
<div id="content" class="content">
	<div class="row" id="usersList">
		<div class="col-md-12 col-sm-12 col-xs-12"> 
			<div class="unattended_show">
				Showing 1-10 of 15
			</div> 	
            <div class="panel panel-inverse margin-b1">
                <div class="panel-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<div id="unattended_detail" class="panel margin-b0">   
						<!-- 	<div class="panel-body"> -->
								<div class="row unattended_results">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="persinfo_container">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
												<div class="row">
													<div class="col-md-1 col-sm-1 col-lg-1 col-xs-2 custom-padding-class">
														<img src="<?php echo base_url();?>assets/img/setting.png" class="img-responsive user_img">
										 			</div>
													<div class="col-md-11 col-sm-11  col-lg-11 col-xs-10" style="    border-bottom: 1px solid #eeeeee;">
														<div class="p-l-5">
															<div class="row">
																<div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 custom-padding-class">
																	<h2 class="usr_name m-t-10 m-b-0">3/8” Drive, 1/2” Shallow Chrome Socket</h2>
																	<p class="sub_usr_name"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp Jul 18, 2017 <span>3:49 am </span></p>
																</div>
																<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																	
								<div class="btn_three pull-right">
								    <button type="button" class="btn edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								    <button type="button" class="btn comment_btn"><i class="fa fa-commenting-o" aria-hidden="true"></i></button>
								    								    	 <button onclick="perm_delete('Do you want to deactivate technician account','users','User_Id','10','1','refresh')" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
	                                	</button>
								    							
							</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>			
						    		</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ol class="technical_list">
										<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Technician Name :</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> David Smith </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Uername:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> smith5863223 </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
														<span>Email Address:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Manpreet@gmail.con </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-hospital-o" aria-hidden="true"></i>
														<span>Shop Name:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Helton Tools & Home Ratione </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head">
														<i class="fa fa-map-marker" aria-hidden="true"></i> 
														<span>Shop Address: </span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Ludhiana </span>
													</div>
												</div>
											</li>
										</ol>
									</div>
								</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
								
							</div>
						<!-- </div> -->
					</div>			
			    </div>
                </div>
            </div>
            <div class="panel panel-inverse margin-b1">
                <div class="panel-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<div id="unattended_detail" class="panel margin-b0">   
						<!-- 	<div class="panel-body"> -->
								<div class="row unattended_results">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="persinfo_container">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
												<div class="row">
													<div class="col-md-1 col-sm-1 col-lg-1 col-xs-2 custom-padding-class">
														<img src="<?php echo base_url();?>assets/img/setting.png" class="img-responsive user_img">
										 			</div>
													<div class="col-md-11 col-sm-11  col-lg-11 col-xs-10" style="    border-bottom: 1px solid #eeeeee;">
														<div class="p-l-5">
															<div class="row">
																<div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 custom-padding-class">
																	<h2 class="usr_name m-t-10 m-b-0">3/8” Drive, 1/2” Shallow Chrome Socket</h2>
																	<p class="sub_usr_name"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp Jul 18, 2017 <span>3:49 am </span></p>
																</div>
																<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																	
								<div class="btn_three pull-right">
								    <button type="button" class="btn edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								    <button type="button" class="btn comment_btn"><i class="fa fa-commenting-o" aria-hidden="true"></i></button>
								    								    	 <button onclick="perm_delete('Do you want to deactivate technician account','users','User_Id','10','1','refresh')" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
	                                	</button>
								    							
							</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>			
						    		</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ol class="technical_list">
										<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Technician Name :</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> David Smith </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Uername:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> smith5863223 </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
														<span>Email Address:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Manpreet@gmail.con </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-hospital-o" aria-hidden="true"></i>
														<span>Shop Name:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Helton Tools & Home Ratione </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head">
														<i class="fa fa-map-marker" aria-hidden="true"></i> 
														<span>Shop Address: </span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Ludhiana </span>
													</div>
												</div>
											</li>
										</ol>
									</div>
								</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
								
							</div>
						<!-- </div> -->
					</div>			
			    </div>
                </div>
            </div>
            <div class="panel panel-inverse margin-b1">
                <div class="panel-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<div id="unattended_detail" class="panel margin-b0">   
						<!-- 	<div class="panel-body"> -->
								<div class="row unattended_results">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="persinfo_container">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
												<div class="row">
													<div class="col-md-1 col-sm-1 col-lg-1 col-xs-2 custom-padding-class">
														<img src="<?php echo base_url();?>assets/img/setting.png" class="img-responsive user_img">
										 			</div>
													<div class="col-md-11 col-sm-11  col-lg-11 col-xs-10" style="    border-bottom: 1px solid #eeeeee;">
														<div class="p-l-5">
															<div class="row">
																<div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 custom-padding-class">
																	<h2 class="usr_name m-t-10 m-b-0">3/8” Drive, 1/2” Shallow Chrome Socket</h2>
																	<p class="sub_usr_name"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp Jul 18, 2017 <span>3:49 am </span></p>
																</div>
																<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																	
								<div class="btn_three pull-right">
								    <button type="button" class="btn edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								    <button type="button" class="btn comment_btn"><i class="fa fa-commenting-o" aria-hidden="true"></i></button>
								    								    	 <button onclick="perm_delete('Do you want to deactivate technician account','users','User_Id','10','1','refresh')" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
	                                	</button>
								    							
							</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>			
						    		</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ol class="technical_list">
										<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Technician Name :</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> David Smith </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Uername:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> smith5863223 </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
														<span>Email Address:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Manpreet@gmail.con </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-hospital-o" aria-hidden="true"></i>
														<span>Shop Name:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Helton Tools & Home Ratione </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head">
														<i class="fa fa-map-marker" aria-hidden="true"></i> 
														<span>Shop Address: </span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Ludhiana </span>
													</div>
												</div>
											</li>
										</ol>
									</div>
								</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
								
							</div>
						<!-- </div> -->
					</div>			
			    </div>
                </div>
            </div>
            <div class="panel panel-inverse margin-b1">
                <div class="panel-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    	<div id="unattended_detail" class="panel margin-b0">   
						<!-- 	<div class="panel-body"> -->
								<div class="row unattended_results">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="persinfo_container">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pad">
												<div class="row">
													<div class="col-md-1 col-sm-1 col-lg-1 col-xs-2 custom-padding-class">
														<img src="<?php echo base_url();?>assets/img/setting.png" class="img-responsive user_img">
										 			</div>
													<div class="col-md-11 col-sm-11  col-lg-11 col-xs-10" style="    border-bottom: 1px solid #eeeeee;">
														<div class="p-l-5">
															<div class="row">
																<div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 custom-padding-class">
																	<h2 class="usr_name m-t-10 m-b-0">3/8” Drive, 1/2” Shallow Chrome Socket</h2>
																	<p class="sub_usr_name"><i class="fa fa-clock-o" aria-hidden="true"></i> &nbsp Jul 18, 2017 <span>3:49 am </span></p>
																</div>
																<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																	
								<div class="btn_three pull-right">
								    <button type="button" class="btn edit_btn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								    <button type="button" class="btn comment_btn"><i class="fa fa-commenting-o" aria-hidden="true"></i></button>
								    								    	 <button onclick="perm_delete('Do you want to deactivate technician account','users','User_Id','10','1','refresh')" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
	                                	</button>
								    							
							</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>			
						    		</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<ol class="technical_list">
										<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Technician Name :</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> David Smith </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-user" aria-hidden="true"></i>
														<span>Uername:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> smith5863223 </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
														<span>Email Address:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Manpreet@gmail.con </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-5 list-head">
														<i class="fa fa-hospital-o" aria-hidden="true"></i>
														<span>Shop Name:</span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Helton Tools & Home Ratione </span>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													
													<div class="col-md-5 list-head">
														<i class="fa fa-map-marker" aria-hidden="true"></i> 
														<span>Shop Address: </span>
													</div>
													<div class="col-md-7">
					                                    <span class="list-sub-text"> Ludhiana </span>
													</div>
												</div>
											</li>
										</ol>
									</div>
								</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 veritically-center">
								
							</div>
						<!-- </div> -->
					</div>			
			    </div>
                </div>
            </div>
           
        </div>
        <div class="col-md-12">
        	 <div class="pagination text-center center-block">
        <ul class="pagination"><li class="paginate_button active"><a href="#">1</a></li></ul>        	 </div>
        </div>
    </div>
</div>
