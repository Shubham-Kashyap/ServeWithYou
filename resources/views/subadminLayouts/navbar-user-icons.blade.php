<div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ Helper::adminImage() }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Helper::adminName() }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ Helper::adminImage() }}" class="img-circle" alt="User Image">

                <p>
                   {{ Helper::adminName() }} 
                  <small>Member since {{ Helper::memberSince() }}</small>
                </p>
              </li>
              <!-- Menu Body -->

                    <!-- ADD MENU ICONS FUNCTIONALITY HERE  -->

              <!-- ./menu body  -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!-- <a href="{{ URL::to('subadmin/settings/profile') }}" class="btn btn-default btn-flat">Profile</a> -->
                </div>
                <div class="pull-right">
                  <!-- <a data-toggle="modal" data-target="#admin-logout" class="btn btn-default btn-flat">Log out</a> -->
                  <a  class="btn btn-default btn-flat subadminlogout_btn">Log out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
</div>