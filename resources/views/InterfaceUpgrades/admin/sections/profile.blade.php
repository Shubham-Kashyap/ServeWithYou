@extends('admin.index')

@section('content')
<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Profile</span> - Settings</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<!-- <div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
						</div>
					</div> -->
				</div>

				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="{{ URL::to('admin/dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">Profile - Settings</span>
						</div>

						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">
							<a href="{{ URL::to('admin/dashboard') }}" class="breadcrumb-elements-item">
								<i class="icon-home2 mr-2"></i>
								Dashboard
							</a>

							<!-- quick links  -->
							@include('adminLayouts.widgets.quicklinks')
							<!-- quick links  -->
						</div>
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="content">

				<div class="d-md-flex align-items-md-start">

					<!-- Left sidebar component -->
					<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

						<!-- Sidebar content -->
						<div class="sidebar-content">

							<!-- Navigation -->
							<div class="card">
								<div class="card-body bg-indigo-400 text-center card-img-top" style="background-image: url(http://demo.interface.club/limitless/assets/images/bg.png); background-size: contain;">
									<div class="card-img-actions d-inline-block mb-3">
										@if(Helper::adminData()->image == null )
											<img class="img-fluid rounded-circle" src="{{ URL::to('admin_files/global_assets/images/placeholders/placeholder.jpg') }}" width="170" height="170" alt="">
											@else
											<img src="{{ Helper::adminImageUrl() }}" width="170" height="170" class="rounded-circle" alt="">
										@endif
										
										<div class="card-img-actions-overlay rounded-circle">
											<!-- <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
												<i class="icon-plus3"></i>
											</a>
											<a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2">
												<i class="icon-link"></i>
											</a> -->
										</div>
									</div>

						    		<h6 class="font-weight-semibold mb-0">{{ Helper::adminData()->name }}</h6>
						    		<span class="d-block opacity-75">Administator</span>

					    			<div class="list-icons list-icons-extended mt-3">
									<a href="{{ URL::to('admin/companies/companies-list') }}" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Companies"><i class="icon-city"></i></a>
				                    	<a href="{{ URL::to('admin/shops/shops-list') }}" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Shops"><i class="icon-office"></i></a>
				                    	<a href="{{ URL::to('admin/branches/branches-list') }}" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Branches"><i class="icon-home2 mr-2"></i></a>
				                    	
			                    	</div>
						    	</div>
								
								<!-- <div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										<li class="nav-item-header">Navigation</li>
										<li class="nav-item">
											@if(Session::get('page') === 'profile' or Session::get('tab') === 'profile')
											<a href="#profile" class="nav-link active" data-toggle="tab">
											@else
											<a href="#profile" class="nav-link " data-toggle="tab">
											@endif
												<i class="icon-user"></i>
												 My profile
											</a>
										</li>
										<li class="nav-item">
											@if(Session::get('page') === 'profile' and Session::get('tab') === 'profileSettings')
											<a href="#profileSettings" class="nav-link active" data-toggle="tab">
											@else
											<a href="#profileSettings" class="nav-link " data-toggle="tab">
											@endif
												<i class="icon-cog6"></i>
												Update Profile
												<span class="font-size-sm font-weight-normal opacity-75 ml-auto">02:56pm</span>
											</a>
										</li>
									
										
										<li class="nav-item-divider"></li>
										<li class="nav-item">
											<a href="{{ URL::to('admin/logout') }}" class="nav-link" >
												<i class="icon-switch2"></i>
												Logout
											</a>
										</li>
									</ul>
								</div> -->
							</div>
							<!-- /navigation -->

						</div>
						<!-- /sidebar content -->

					</div>
					<!-- /left sidebar component -->


					<!-- Right content -->
					<div class="tab-content w-100 overflow-auto">
						
						<div class="tab-pane fade" id="profile">
						


							<div class="card">
								<div class="card-header header-elements-inline">
									<h5 class="card-title">Profile information</h5>
									<div class="header-elements">
										<div class="list-icons">
					                		<a class="list-icons-item" data-action="collapse"></a>
					                		<a class="list-icons-item" data-action="reload"></a>
					                		<a class="list-icons-item" data-action="remove"></a>
					                	</div>
				                	</div>
								</div>

								<div class="card-body">
									<form action="#">
										<div class="form-group">
											<div class="row">
											
												<div class="col-md-12">
													<label>Full name</label>
													<input type="text" readonly="readonly" value="{{ $data->name }}" class="form-control">
												</div>
											</div>
										</div>

									

										

										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Email</label>
													<input type="text" readonly="readonly" value="{{ $data->email }}" class="form-control">
												</div>
												<div class="col-md-6">
						                            <label>Phone Number</label>
						                            <input type="text" readonly="readonly" value="{{ $data->phone_no }}" class="form-control">
												</div>
											</div>
										</div>
										
				                        
				                        <!-- <div class="text-right">
				                        	<button type="submit" class="btn btn-primary">Save changes</button>
				                        </div> -->
									</form>
								</div>
							</div>

					    </div>

						
						<div class="tab-pane fade active show" id="profileSettings">
						
					    

				    		<!-- Profile update -->
							<div class="card">
								<div class="card-header header-elements-inline">
									<h5 class="card-title">Update profile </h5>
									<div class="header-elements">
										<div class="list-icons">
					                		<a class="list-icons-item" data-action="collapse"></a>
					                		<a class="list-icons-item" data-action="reload"></a>
					                		<a class="list-icons-item" data-action="remove"></a>
					                	</div>
				                	</div>
								</div>

								<div class="card-body">

										@if(Session::has('profile_error_message'))
											<div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal border-teal alert-dismissible">
												<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
												<span class="font-weight-semibold"> </span> {{ Session::get('profile_error_message') }} 
											</div>
										@endif
										@if(Session::has('profile_success_message'))
											<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
												<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
												<span class="font-weight-semibold"> </span> {{ Session::get('profile_success_message') }} 
							    			</div>
										@endif
									<form action="{{ URL::to('admin/settings/profile/update-profile') }}" method="POST" enctype="multipart/form-data">

										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										
										
											
										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Name <span class="text-danger">*</span></label>
													<input type="text" name="name" value="{{ $data->name }}" class="form-control">
												</div>
												<div class="col-md-6">
													<label>Phone Number <span class="text-danger">*</span></label>
													<input type="text" name="phone_no" value="{{ $data->phone_no }}" class="form-control">
												</div>
											</div>
										</div>
									 	
										<div class="form-group">
											<label for="image"> Profile Picture </label>
											<input type="file" name='image' id="image" class="file-input form-control-sm" data-show-caption="false" data-show-upload="false" data-browse-class="btn btn-primary btn-sm" data-remove-class="btn btn-light btn-sm" accept=".png,.jpeg,.jpg" data-fouc>
										
											<!-- <span class="form-text text-muted">Must be a type of image with specific file extensions. i.e. only <code>.jpg</code>, <code>.png</code> and <code>.jpeg</code> and  extensions are allowed.</span> -->
										</div>

							
				                        <div class="text-right">
				                        	<button type="submit" class="btn btn-primary">Save changes</button>
				                        </div>
									</form>
								</div>
							</div>
							<!-- /profile update -->

							<!-- Account settings -->
							<div class="card">
								<div class="card-header header-elements-inline">
									<h5 class="card-title">Update password</h5>
									<div class="header-elements">
										<div class="list-icons">
					                		<a class="list-icons-item" data-action="collapse"></a>
					                		<a class="list-icons-item" data-action="reload"></a>
					                		<a class="list-icons-item" data-action="remove"></a>
					                	</div>
				                	</div>
								</div>

								<div class="card-body">
									<form action="{{ URL::to('admin/settings/profile/change-password') }}" method="POST">

										<input type="hidden" name="_token" value="{{ csrf_token() }}" />


										@if(Session::has('pwd_error_message'))
											<div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal border-teal alert-dismissible">
												<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
												<span class="font-weight-semibold"> </span> {{ Session::get('pwd_error_message') }} 
											</div>
										@endif
										@if(Session::has('pwd_success_message'))
											<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
												<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
												<span class="font-weight-semibold"> </span> {{ Session::get('pwd_success_message') }} 
							    			</div>
										@endif

										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>Email</label>
													<input type="text" value="{{ Helper::adminData()->email }}" readonly="readonly" class="form-control">
												</div>

												<div class="col-md-6">
													<label>Current Password <span class="text-danger">*</span></label>
													<input type="password" name="current_password" placeholder="Enter current password" class="form-control">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-6">
													<label>New Password <span class="text-danger">*</span></label>
													<input type="password" name="new_password" placeholder="Enter new password" class="form-control">
												</div>

												<div class="col-md-6">
													<label>Confirm New Password <span class="text-danger">*</span></label>
													<input type="password" name="confirm_new_password" placeholder="Confirm new password" class="form-control">
												</div>
											</div>
										</div>

				                        <div class="text-right">
				                        	<button type="submit" class="btn btn-primary">Save changes</button>
				                        </div>
			                        </form>
								</div>
							</div>
							<!-- /account settings -->


				    	</div>


				    	<div class="tab-pane fade" id="orders">

							<!-- Orders history -->
							<div class="card">
								<div class="card-header header-elements-inline">
									<h6 class="card-title">Orders history</h6>
									<div class="header-elements">
										<span><i class="icon-arrow-down22 text-danger"></i> <span class="font-weight-semibold">- 29.4%</span></span>
			                		</div>
								</div>

								<div class="card-body">
									<div class="chart-container">
										<div class="chart has-fixed-height" id="balance_statistics" _echarts_instance_="ec_1615958719258" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;"><div style="position: relative; overflow: hidden; width: 100px; height: 400px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="100" height="400" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
									</div>
								</div>

								<div class="table-responsive">
									<table class="table text-nowrap">
										<thead>
											<tr>
												<th colspan="2">Product name</th>
												<th>Size</th>
												<th>Colour</th>
												<th>Article number</th>
												<th>Units</th>
												<th>Price</th>
												<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
											</tr>
										</thead>
										<tbody>
											<tr class="table-active">
												<td colspan="7" class="font-weight-semibold">New orders</td>
												<td class="text-right">
													<span class="badge bg-secondary badge-pill">24</span>
												</td>
											</tr>

											<tr>
												<td class="pr-0" style="width: 45px;">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Fathom Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-grey border-grey mr-1"></span>
														Processing
													</div>
												</td>
												<td>34cm x 29cm</td>
												<td>Orange</td>
												<td>
													<a href="#">1237749</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 79.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
													<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Mystery Air Long Sleeve T Shirt</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-grey border-grey mr-1"></span>
														Processing
													</div>
												</td>
												<td>L</td>
												<td>Process Red</td>
												<td>
													<a href="#">345634</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 38.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Women’s Prospect Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-grey border-grey mr-1"></span>
														Processing
													</div>
												</td>
												<td>46cm x 28cm</td>
												<td>Neu Nordic Print</td>
												<td>
													<a href="#">5739584</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 60.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Overlook Short Sleeve T Shirt</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-grey border-grey mr-1"></span>
														Processing
													</div>
												</td>
												<td>M</td>
												<td>Gray Heather</td>
												<td>
													<a href="#">434450</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 35.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr class="table-active">
												<td colspan="7" class="font-weight-semibold">Shipped orders</td>
												<td class="text-right">
													<span class="badge bg-success badge-pill">42</span>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Infinite Ride Liner</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>43</td>
												<td>Black</td>
												<td>
													<a href="#">34739</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 210.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Custom Snowboard</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>151</td>
												<td>Black/Blue</td>
												<td>
													<a href="#">5574832</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 600.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Kids' Day Hiker 20L Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>24cm x 29cm</td>
												<td>Figaro Stripe</td>
												<td>
													<a href="#">6684902</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 55.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Lunch Sack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>24cm x 20cm</td>
												<td>Junk Food Print</td>
												<td>
													<a href="#">5574829</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 20.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Cambridge Jacket</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>XL</td>
												<td>Nomad/Railroad</td>
												<td>
													<a href="#">475839</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 175.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Covert Jacket</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-success border-success mr-1"></span>
														Shipped
													</div>
												</td>
												<td>XXL</td>
												<td>Mocha/Glacier Sierra</td>
												<td>
													<a href="#">589439</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 126.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr class="table-active">
												<td colspan="7" class="font-weight-semibold">Cancelled orders</td>
												<td class="text-right">
													<span class="badge bg-danger badge-pill">9</span>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Day Hiker Pinnacle 31L Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-danger border-danger mr-1"></span>
														Cancelled
													</div>
												</td>
												<td>42cm x 26.5cm</td>
												<td>Blotto Ripstop</td>
												<td>
													<a href="#">5849305</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 130.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Kids' Gromlet Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-danger border-danger mr-1"></span>
														Cancelled
													</div>
												</td>
												<td>22cm x 20cm</td>
												<td>Slime Camo Print</td>
												<td>
													<a href="#">4438495</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 35.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Tinder Backpack</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-danger border-danger mr-1"></span>
														Cancelled
													</div>
												</td>
												<td>42cm x 26cm</td>
												<td>Dark Tide Twill</td>
												<td>
													<a href="#">4759383</a>
												</td>
												<td>2</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 180.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="pr-0">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" height="60" alt="">
													</a>
												</td>
												<td>
													<a href="#" class="font-weight-semibold">Almighty Snowboard Boot</a>
													<div class="text-muted font-size-sm">
														<span class="badge badge-mark bg-danger border-danger mr-1"></span>
														Cancelled
													</div>
												</td>
												<td>45</td>
												<td>Multiweave</td>
												<td>
													<a href="#">34432</a>
												</td>
												<td>1</td>
												<td>
													<h6 class="mb-0 font-weight-semibold">€ 370.00</h6>
												</td>
												<td class="text-center">
													<div class="list-icons">
														<div class="list-icons-item dropdown">
															<a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu7"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<a href="#" class="dropdown-item"><i class="icon-truck"></i> Track parcel</a>
																<a href="#" class="dropdown-item"><i class="icon-file-download"></i> Download invoice</a>
																<a href="#" class="dropdown-item"><i class="icon-wallet"></i> Payment details</a>
																<div class="dropdown-divider"></div>
																<a href="#" class="dropdown-item"><i class="icon-warning2"></i> Report problem</a>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- /orders history -->

				    	</div>
					</div>
					<!-- /right content -->

				</div>
				

			</div>
			<!-- /content area -->


			<!-- Footer -->
			@include('adminLayouts.footer')
			<!-- /footer -->

		</div>
@endsection