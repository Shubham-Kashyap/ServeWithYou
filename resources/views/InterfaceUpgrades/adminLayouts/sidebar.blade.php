<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

<!-- Sidebar mobile toggler -->
<div class="sidebar-mobile-toggler text-center">
    <a href="#" class="sidebar-mobile-main-toggle">
        <i class="icon-arrow-left8"></i>
    </a>
    Navigation
    <a href="#" class="sidebar-mobile-expand">
        <i class="icon-screen-full"></i>
        <i class="icon-screen-normal"></i>
    </a>
</div>
<!-- /sidebar mobile toggler -->


<!-- Sidebar content -->
<div class="sidebar-content">

    <!-- User menu -->
    <div class="sidebar-user">
        <div class="card-body">
            <div class="media">
                <div class="mr-3">
                    @if(Helper::adminData()->image != null )
                    <a href="#"><img src="{{ Helper::adminImageUrl() }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    @else
                    <a href="#"><img src="{{ URL::to('/admin_files/global_assets/images/placeholders/placeholder.jpg') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    @endif
                </div>

                <div class="media-body">
                    <div class="media-title font-weight-semibold">{{ Helper::adminData()->name }}</div>
                    <div class="font-size-xs opacity-50">
                        <!-- <i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA -->
                        Online
                    </div>
                </div>

                <!-- <div class="ml-3 align-self-center">
                    <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                </div> -->
            </div>
        </div>
    </div>
    <!-- /user menu -->


    <!-- Main navigation -->
    <div class="card card-sidebar-mobile">
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <!-- <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li> -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/dashboard') }}" class="nav-link {{request()->is('admin/dashboard') ?'active':''}}">
                    <i class="icon-home4"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
           
            <!-- Bidding requests  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/biddings/all-requests') }}" class="nav-link {{request()->is('admin/biddings/*') ?'active':''}}">
                    <i class="icon-list3"></i>
                    <span>Bidding Requests</span>
                    
                </a>
            </li>
            <!-- bidding requests -->
            
            <!-- orders  -->
            <!-- <li class="nav-item nav-item-submenu {{request()->is('admin/orders/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-cart"></i> <span>Orders</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/orders/custom-orders') }}" class="nav-link {{request()->is('admin/orders/custom-orders') ?'active':''}}">Custom orders</a></li>
                    <li class="nav-item"><a href="{{ URL::to('admin/orders/all-orders') }}" class="nav-link {{request()->is('admin/orders/all-drivers') ?'active':''}}">All Orders</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/drivers/blocked-drivers') }}" class="nav-link {{request()->is('admin//blocked-drivers') ?'active':''}}">Blocked Drivers</a> 
                        <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <!-- orders  -->

            <!-- Products  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/products/all-farm-products') }}" class="nav-link {{request()->is('admin/products/*') ?'active':''}}">
                    <i class="icon-basket"></i>
                    <span>Products</span>
                    <!-- <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span> -->
                </a>
            </li>
            <!-- Products -->

            <!-- users management  -->
            <li class="nav-item nav-item-submenu {{request()->is('admin/users/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-users"></i> <span>Users</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/users/all-users') }}" class="nav-link {{request()->is('admin/users/all-users') ?'active':''}}">All Users</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/users/blocked-users') }}" class="nav-link {{request()->is('admin/users/blocked-users') ?'active':''}}">Blocked Users</a>
                        <!-- <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>
            <!-- users management  -->

            <!-- categories  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/categories/all-categories') }}" class="nav-link {{request()->is('admin/categories/*') ?'active':''}}">
                    <i class="icon-clipboard3"></i>
                    <span>Categories</span>
                </a>
            </li>
            <!-- categories  -->

            <!-- verticals  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/verticals/all-verticals') }}" class="nav-link {{request()->is('admin/verticals/*') ?'active':''}}">
                    <i class="icon-flip-vertical3"></i>
                    <span>Verticals</span>
                </a>
            </li>
            <!-- verticals  -->

            <!-- cuisines  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/cuisines/all-cuisines') }}" class="nav-link {{request()->is('admin/cuisines/*') ?'active':''}}">
                    <i class="icon-flip-vertical4"></i>
                    <span>Cuisines</span>
                </a>
            </li>
            <!-- cuisines -->

            <!-- coupons  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/coupons/get-coupon') }}" class="nav-link {{request()->is('admin/coupons/*') ?'active':''}}">
                    <i class="icon-import"></i>
                    <span>Coupons & Banners</span>
                </a>
            </li>
            <!-- coupons  -->

            <!-- Companies management  -->
            <li class="nav-item nav-item-submenu {{request()->is('admin/companies/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-city"></i> <span>Companies</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/companies/companies-list') }}" class="nav-link {{request()->is('admin/companies/companies-list') ?'active':''}}">All Companies</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/companies/inactive-companies-list') }}" class="nav-link {{request()->is('admin/companies/inactive-companies-list') ?'active':''}}">Inactive Companies</a>
                        <!-- <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>
            <!-- companies management  -->

            <!-- mashool farms  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/mahsool/shop-menu') }}" class="nav-link {{request()->is('admin/mahsool/*') ?'active':''}}">
                    <i class="icon-import"></i>
                    <span>Mahsool Farm</span>
                </a>
            </li>
            <!-- mashool farms  --> 
            
            <!-- shops management  -->
            <li class="nav-item nav-item-submenu {{request()->is('admin/shops/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-office"></i> <span>Shops (Farms)</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/shops/shops-list') }}" class="nav-link {{request()->is('admin/shops/shops-list') ?'active':''}}">All Shops</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/shops/inactive-shops-list') }}" class="nav-link {{request()->is('admin/shops/inactive-shops-list') ?'active':''}}">Inactive Shops</a>
                        <!-- <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>
            <!-- shops management  -->
            
        

            <!-- branch management  -->
            <li class="nav-item nav-item-submenu {{request()->is('admin/branches/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-home2"></i> <span>Branches</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/branches/branches-list') }}" class="nav-link {{request()->is('admin/branches/branches-list') ?'active':''}}">All Branches</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/branches/inactive-branches-list') }}" class="nav-link {{request()->is('admin/branches/inactive-branches-list') ?'active':''}}">Inactive Branches</a>
                        <!-- <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>
            <!-- branch management  -->

            <!-- farms management  -->
            <!-- <li class="nav-item nav-item-submenu {{request()->is('admin/farms/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-earth"></i> <span>Farms</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <li class="nav-item"><a href="{{ URL::to('admin/farms/all-farms') }}" class="nav-link {{request()->is('admin/farms/all-farms') ?'active':''}}">All Farms</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/farms/blocked-farms') }}" class="nav-link {{request()->is('admin/farms/blocked-farms') ?'active':''}}">Blocked Farms</a>
                        <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <!-- farms management  -->

            <!-- drivers management  -->
            <li class="nav-item nav-item-submenu {{request()->is('admin/drivers/*') ?' nav-item-expanded nav-item-open ':''}}">
                <a href="#" class="nav-link"><i class="icon-truck"></i> <span>Drivers</span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Service pages" style="">
                    <!-- <li class="nav-item"><a href="{{ URL::to('admin/drivers/driver-requests') }}" class="nav-link {{request()->is('admin/drivers/driver-requests') ?'active':''}}">Drivers Requests</a></li> -->
                    <li class="nav-item"><a href="{{ URL::to('admin/drivers/all-drivers') }}" class="nav-link {{request()->is('admin/drivers/all-drivers') ?'active':''}}">All Drivers</a></li>
                    <li class="nav-item ">
                        <a href="{{ URL::to('admin/drivers/blocked-drivers') }}" class="nav-link {{request()->is('admin/drivers/blocked-drivers') ?'active':''}}">Blocked Drivers</a>
                        <!-- <ul class="nav nav-group-sub">
                            <li class="nav-item"><a href="invoice_template.html" class="nav-link">Invoice template</a></li>
                            <li class="nav-item"><a href="invoice_grid.html" class="nav-link">Invoice grid</a></li>
                            <li class="nav-item"><a href="invoice_archive.html" class="nav-link">Invoice archive</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>

            <!-- best seller   -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/best-seller-list') }}" class="nav-link {{request()->is('admin/best*') ?'active':''}}">
                    <i class="icon-import"></i>
                    <span>Best Seller</span>
                </a>
            </li>
            <!-- best seller   -->


             <!-- profile settings  -->
             <li class="nav-item">
                <a href="{{ URL::to('admin/profile-settings') }}" class="nav-link {{request()->is('admin/profile-settings') ?'active':''}}">
                    <i class="icon-cog3"></i>
                    <span>Profile Settings</span>
                    <!-- <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span> -->
                </a>
            </li>

            <!-- logout  -->
            <li class="nav-item">
                <a href="{{ URL::to('admin/logout') }}" class="nav-link">
                    <i class="icon-switch"></i>
                    <span>Logout</span>
                    <!-- <span class="badge bg-blue-400 align-self-center ml-auto">2.0</span> -->
                </a>
            </li>
            <!-- /logout  -->
            <!-- /main -->

        </ul>
    </div>
    <!-- /main navigation -->

</div>
<!-- /sidebar content -->

</div>
<!-- /main sidebar -->

