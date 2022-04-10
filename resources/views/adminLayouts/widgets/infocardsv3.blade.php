
      <!-- =========================================================== -->

      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Providers</span>
              <span class="info-box-number">{{ Helper::totalProvidersCount() }}</span>

              <a href="{{ URL::to('admin/providers/all-providers') }}"><span class="progress-description" style="color:white;">
                    click here for more details
                  </span></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-user-secret"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Consumers</span>
              <span class="info-box-number">{{ Helper::totalConsumersCount() }}</span>

              <a href="{{ URL::to('admin/consumers/all-consumers') }}"><span class="progress-description" style="color:white;">
                    click here for more details
                  </span></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-olive text-decoration-none text-light">
            <!-- <span class="info-box-icon"><i class="ion ion-ios-people-outline"></i></span> -->
            <span class="info-box-icon"><i class="fa fa-user-times"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Blocked Users</span>
              <span class="info-box-number">{{ Helper::blockedUsersCount() }}</span>


              <a href="{{ URL::to('admin/users/blocked-users') }}"><span class="progress-description" style="color:white;">
                    click here for more details
                  </span></a>
            </div>
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-gg"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jobs</span>
              <span class="info-box-number">{{ Helper::totalJobsCount() }}</span>

              
                  <a href="{{ URL::to('admin/jobs/all-jobs') }}"><span class="progress-description" style="color:white;">
                    click here for more details
                  </span></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- =========================================================== -->

  