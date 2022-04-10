  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Helper::adminImage() }}" class="img-circle" style="height:45px;cursor:auto;" alt="User Image">
        </div>
        <div class="pull-left info">
          
          <p class="widget-user-username">{{ Helper::adminName() }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
      <ul class="sidebar-menu" style="margin-top:25px;">


        <!-- for dashboard treeview -->
        @if(Session::get('page') == 'dashboard')
        <li class="treeview active">
        @else
        <li class="treeview ">
        @endif
          <a href="{{ URL::to('admin/dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>


        <!-- for job categories treeview -->
        @if(Session::get('page') === 'allsubadmins' or Session::get('page') === 'addsubadmins')
        <li class="treeview active">
        @else
        <li class="treeview">
        @endif
          <a href="">
            <i class="fa fa-list-alt"></i> <span>Subadmins</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Session::get('page') == 'allsubadmins')
              <?php $allsubadmins = 'text-aqua'  ?>
            @else
              <?php $allsubadmins = "" ?>
            @endif
            @if(Session::get('page') == 'addsubadmins')
              <?php $addsubadmins = 'text-aqua' ?>
            @else
              <?php $addsubadmins = '' ?>
            @endif
            <!-- <li><a href="{{ URL::to('admin/categories/add-categories') }}"><i class="fa fa-circle-o {{ $addsubadmins}}  "></i>Add Subadmin </a></li>/ -->
            <li><a href="{{ URL::to('admin/subadmins/all-subadmins') }}"><i class="fa fa-circle-o {{ $allsubadmins }}  "></i>All Subadmins </a></li>
            <!-- <li><a href="{{ URL::to('categories/all-categories') }}"></a>All Ctaegories</li> -->
          </ul>
        </li>

        <!-- for companies treeview -->
        @if(Session::get('page') == 'allCompanies')
        <li class="treeview active">
        @else
        <li class="treeview ">
        @endif
          <a href="{{ URL::to('admin/companies/all-companies') }}">
            <i class="fa fa-home"></i> <span>Companies</span>
          </a>
        </li>

        <!-- for job categories treeview -->
        @if(Session::get('page') === 'allcategories' or Session::get('page') === 'addcategories')
        <li class="treeview active">
        @else
        <li class="treeview">
        @endif
          <a href="">
            <i class="fa fa-list-alt"></i> <span>Categories</span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <span class="label label-primary pull-right">{{ Helper::totalCategoriesCount() }}</span>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Session::get('page') == 'allcategories')
              <?php $allcategories = 'text-aqua'  ?>
            @else
              <?php $allcategories = "" ?>
            @endif
            @if(Session::get('page') == 'addcategories')
              <?php $addcategories = 'text-aqua' ?>
            @else
              <?php $addcategories = '' ?>
            @endif
            <li><a href="{{ URL::to('admin/categories/add-categories') }}"><i class="fa fa-circle-o {{ $addcategories }}  "></i>Add Categories </a></li>
            <li><a href="{{ URL::to('admin/categories/all-categories') }}"><i class="fa fa-circle-o {{ $allcategories }}  "></i>All Categories </a></li>
            <!-- <li><a href="{{ URL::to('categories/all-categories') }}"></a>All Ctaegories</li> -->
          </ul>
        </li>


        <!-- for users treeview -->
        <!-- @if(Session::get('page') == 'blockedusers' or Session::get('page') == 'allusers')
          <li class="treeview active">
          @else
          <li class="treeview">
        @endif
          <a href="#">
            <i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" >
            @if( Session::get('page') === 'allusers' )
              <?php $allusers = 'text-aqua'?>
              @else
              <?php $allusers = ''?>
            @endif
            @if( Session::get('page') === 'blockedusers' )
              <?php $blockedusers = 'text-aqua'?>
              @else
              <?php $blockedusers = ''?>
            @endif
            <li><a href="{{ URL::to('admin/users/all-users') }}"><i class="fa fa-circle-o {{ $allusers }}"></i>All Users
            <span class="pull-right-container">
              <small class="label pull-right bg-green">{{ '55' }}</small>
            </span>
            </a></li>
            <li><a href="{{ URL::to('admin/users/blocked-users') }}"><i class="fa fa-circle-o  {{ $blockedusers }}"></i>Blocked Users
            <span class="pull-right-container">
              <small class="label label-sm pull-right bg-red">{{ Helper::blockedUsersCount() }}</small>
            </span>
            </a></li>
          </ul>
        </li>
        -->
        <!-- consumers treeview  -->
        @if(Session::get('page') === 'addconsumer' or Session::get('page') === 'allconsumers')
          <li class="treeview active">
          @else
          <li class="treeview">
        @endif
          <a href="#">
            <i class="fa fa-user-secret"></i> <span>Consumers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              @if( Session::get('page') === 'addconsumer' )
                <?php $addconsumer = 'text-aqua'?>
                @else
                <?php $addconsumer = ''?>
              @endif
              @if( Session::get('page') === 'allconsumers' )
                <?php $allconsumers = 'text-aqua'?>
                @else
                <?php $allconsumers = ''?>
              @endif
              <!-- <li><a href="{{URL::to('/admin/consumers/add-consumer')}}"><i class="fa fa-circle-o {{ $addconsumer }}"></i> Add Consumer</a></li> -->
              <li><a href="{{URL::to('/admin/consumers/all-consumers')}}"><i class="fa fa-circle-o {{ $allconsumers }} "></i>All Consumers</a></li>
          </ul>
        </li>

        <!-- providers treview  -->
        @if(Session::get('page') === 'allproviders' or Session::get('page') === 'addprovider' or Session::get('page') === 'blockedproviders' or Session::get('page') === 'associatedemployes')
          <li class="treeview active">
          @else
          <li class="treeview ">
        @endif
          <a href="#">
            <i class="ion ion-ios-people"></i> <span>Providers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" >
            @if( Session::get('page') === 'allproviders' )
              <?php $allproviders = 'text-aqua'?>
              @else
              <?php $allproviders = ''?>
            @endif
            @if(Session::get('page') === 'addprovider')
              <?php $addprovider="text-aqua" ?>
              @else
              <?php $addprovider="" ?>
            @endif
            @if( Session::get('page') === 'blockedproviders' )
              <?php $blockedproviders = 'text-aqua'?>
              @else
              <?php $blockedproviders = ''?>
            @endif
            @if( Session::get('page') === 'associatedemployes' )
              <?php $associatedemployes = 'text-aqua'?>
              @else
              <?php $associatedemployes = ''?>
            @endif
            <!-- <li><a href="{{ URL::to('admin/providers/add-providers') }}"><i class="fa fa-circle-o {{ $addprovider }}"></i>Add Provider </a></li> -->
            <li><a href="{{ URL::to('admin/providers/company-associated-providers') }}"><i class="fa fa-circle-o {{ $associatedemployes }}"></i>Associated Providers </a></li>
            <li><a href="{{ URL::to('admin/providers/all-providers') }}"><i class="fa fa-circle-o {{ $allproviders }} "></i>All Providers
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">{{ '55' }}</small> -->
            </span>
            </a></li>
            <!-- <li><a href="{{ URL::to('admin/providers/blocked-providers') }}"><i class="fa fa-circle-o {{ $blockedproviders }}"></i>Blocked Providers
            <span class="pull-right-container">
              <small class="label label-sm pull-right bg-red">{{ '55' }}</small>
            </span>
            </a></li> -->
          </ul>
        </li>
        

        <!-- jobs treeview  -->
        @if(Session::get('page') === 'alljobs' or Session::get('page') === 'rejectedjobs' or Session::get('page') === 'donejobs')
          <li class="treeview active">
          @else
          <li class="treeview ">
        @endif
          <a href="#">
            <i class="fa fa-gg"></i> <span>Jobs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if( Session::get('page') === 'alljobs' )
              <?php $alljobs = 'text-aqua'?>
              @else
              <?php $alljobs = ''?>
            @endif
            @if( Session::get('page') === 'rejectedjobs' )
              <?php $rejectedjobs = 'text-aqua'?>
              @else
              <?php $rejectedjobs = ''?>
            @endif
            @if( Session::get('page') === 'donejobs' )
              <?php $donejobs = 'text-aqua'?>
              @else
              <?php $donejobs = ''?>
            @endif
              <li><a href="{{URL::to('/admin/jobs/all-jobs')}}"><i class="fa fa-circle-o {{ $alljobs }}"></i>All Jobs</a></li>
              <li><a href="{{URL::to('/admin/jobs/done-jobs')}}"><i class="fa fa-circle-o {{ $donejobs }}"></i>Done Jobs
                <span class="pull-right-container">
                  <small class="label pull-right bg-blue">{{ Helper::doneJobsCount() }}</small>
                </span>
              </a></li>
              <li><a href="{{URL::to('/admin/jobs/rejected-jobs')}}"><i class="fa fa-circle-o {{ $rejectedjobs }}"></i>Rejected Jobs
                <span class="pull-right-container">
                  <small class="label pull-right bg-red">{{ Helper::rejectedJobsCount() }}</small>
                </span>
              </a></li>
          </ul>
        </li>

        <!-- blocked users  -->
        @if(Session::get('page') === 'blockedusers')
        <li class="treeview active">
        @else
        <li class="treeview">
        @endif
        <a href="#">
            <i class="fa fa-user-times"></i> <span>Blocked users</span>
            <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <span class="label label-danger pull-right">{{ Helper::blockedUsersCount() }}</span>
            </span>
          </a>
          <ul class="treeview-menu">
              @if(Session::get('page') === 'blockedusers')
              <?php $blockedusers = "text-aqua"?>
              @else 
              <?php $blockedusers = ""?>
              @endif
              <li><a href="{{URL::to('/admin/users/blocked-users')}}"><i class="fa fa-circle-o {{ $blockedusers }}"></i> Blocked users</a></li>
          </ul>
        </li>

        <!-- settings treeview  -->
        @if(Session::get('page') === 'profile')
        <li class="treeview active">
        @else
        <li class="treeview">
        @endif
          <a href="#">
            <i class="fa fa-gears"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              @if(Session::get('page') === 'profile')
              <?php $profile = "text-aqua"?>
              @else 
              <?php $profile = ""?>
              @endif
              <li><a href="{{URL::to('/admin/settings/profile')}}"><i class="fa fa-circle-o {{ $profile }}"></i> Profile</a></li>
              <!-- <li><a href="{{URL::to('/admin/settings/profile')}}"><i class="fa fa-circle-o "></i> Profile</a></li> -->
          </ul>
        </li>

        <li class="treeview">
        <!-- admin logout trigger button -->
          <a data-toggle="modal" class="logout_btn" type="button">
          <!-- <a data-toggle="modal"  data-target="#admin-logout" type="button"> -->
            <i class="fa fa-share"></i> <span>Logout</span>
          </a>
        </li>

        <!-- <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- admin logout model  -->
  <div class="modal  fade " id="admin-logout" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to logout ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <a href="{{ URL::to('admin/logout') }}" class="btn bg-navy">Logout</a>
          <!-- <a href="" class="btn btn-danger"> Delete property image</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- ========================================================================= -->