<div class="row">
        
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">0<small>%</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>
        
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="#">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-cloud-upload-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">User Uploads</span>
              <span class="info-box-number">0</span>
              <!-- <span class="info-box-number">41,410</span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="#">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number">0</span>
              <!-- <span class="info-box-number">54</span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ URL::to('/admin/user-management/user') }}">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">New Members</span>
              <span class="info-box-number">{{ $userCount }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
        </div>
        <!-- /.col -->
</div>