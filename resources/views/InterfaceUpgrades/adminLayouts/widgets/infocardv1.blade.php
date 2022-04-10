                <div class="row">
					<div class="col-sm-6 col-xl-3">
						<div class="card card-body bg-blue-400 has-bg-image">
							<a href="{{ URl::to('admin/users/all-users') }}">
							<div class="media">
								<div class="media-body">
									<h3 class="mb-0" style="color:white">{{ Helper::usersCount() }}</h3>
									<span class="text-uppercase font-size-xs" style="color:white">Users</span>
								</div>

								<div class="ml-3 align-self-center">
									<i class="icon-users icon-3x opacity-75" style="color:white"></i>
								</div>
							</div>
							</a>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card card-body bg-danger-400 has-bg-image">
							<a href="{{ URl::to('admin/shops/shops-list') }}">
							<div class="media">
								<div class="media-body">
									<h3 class="mb-0" style="color:white">{{ Helper::farmersCount() }}</h3>
									<span class="text-uppercase font-size-xs" style="color:white">Farms</span>
								</div>

								<div class="ml-3 align-self-center">
									<i class="icon-accessibility icon-3x opacity-75" style="color:white"></i>
								</div>
							</div>
							</a>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card card-body bg-success-400 has-bg-image">
							<a href="{{ URl::to('admin/drivers/all-drivers') }}">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-car2 icon-3x opacity-75" style="color:white"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="mb-0" style="color:white">{{ Helper::driversCount() }}</h3>
									<span class="text-uppercase font-size-xs" style="color:white">Drivers</span>
								</div>
							</div>
							</a>
						</div>
					</div>

					<div class="col-sm-6 col-xl-3">
						<div class="card card-body bg-indigo-400 has-bg-image">
							<a href="{{ URl::to('admin/products/all-farm-products') }}">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-bag icon-3x opacity-75" style="color:white"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="mb-0" style="color:white">{{ Helper::productsCount() }}</h3>
									<span class="text-uppercase font-size-xs" style="color:white">Products</span>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>