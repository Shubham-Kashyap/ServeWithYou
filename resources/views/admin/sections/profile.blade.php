@extends('admin.index')

@section('content')
<section class="content-header">
      <h1>
         Settings 
         <small>Profile preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settings</a></li>
        <li class="active">Profile</li>
      </ol>
</section>
<section class="content">

      <div class="row">


        <div class="col-md-4">

            <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-navy">
              <div class="widget-user-image">
                <img class="img-circle" src="{{ Helper::adminImage() }}" style="height:65px;width:65px;" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ Helper::adminName() }}</h3>
              <h5 class="widget-user-desc">Administrator</h5>
            </div>
            
            
            <div class="box-body">
              <strong><i class="fa fa-envelope-o margin-r-5"></i> Email</strong><p class="text-muted" style="margin-left:22px">{{ $data->email }}</p><hr>
              <!-- <strong><i class="fa fa-odnoklassniki margin-r-5"></i> Gender</strong><p class="text-muted" style="margin-left:22px">{{ $data->phone_no }}</p><hr> -->
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong><p class="text-muted" style="margin-left:22px">{{ $data->address }}</p><hr>
              <strong><i class="fa fa-phone margin-r-5"></i> Phone Number</strong><p class="text-muted" style="margin-left:22px">{{ $data->phone_no }}</p>
            </div>
          </div>
          <!-- /.widget-user -->


          
        </div>
        <!-- /.col -->
        <!-- session alerts -->
        <div class="col-md-8">
             @if (Session::has('error_message'))
                  <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Warning !!</h3>

                      <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      {{ Session::get('error_message') }}
                   </div>
                  <!-- /.box-body -->
                  </div>
            @endif
            @if (Session::has('success_message'))
                  <div class="box box-success box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Success !!</h3>

                      <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                  <!-- /.box-tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      {{ Session::get('success_message') }}
                   </div>
                  <!-- /.box-body -->
                  </div>
            @endif

        </div>
        <!-- ./session alerts -->
        <!-- profile settings  update profile | change password  -->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @if(Session::get('tab') == 'profile_update')
                <?php $classUpdateProfile='active'; $classChangePwd=""?>
                @else
                <?php $classUpdateProfile='active'; $classChangePwd=""?>
              @endif
              @if(Session::get('tab') == 'password_update')
                <?php $classUpdateProfile=''; $classChangePwd="active"?>
              @endif
              <li class={{ $classUpdateProfile }}><a href="#update-profile" data-toggle="tab" aria-expanded="false">Update Profile</a></li>
              <li class={{  $classChangePwd  }}><a href="#change-password" data-toggle="tab" aria-expanded="false">Change Password</a></li>
            </ul>
            <div class="tab-content">
              
              <!-- /.tab-pane -->
              <div class="tab-pane {{$classUpdateProfile}}" id="update-profile">
                <!-- The update profile form -->
                
                <form class="form-horizontal" action="{{ URL::to('/admin/settings/profile/update-profile') }}" method="post" enctype="multipart/form-data" >
                  <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                  <!-- <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Admin Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name ="email" id="email" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="first_name"  class="col-sm-2 control-label"> First Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name ="first_name" id="first_name" value="{{ $data->first_name }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="last_name"  class="col-sm-2 control-label"> Last Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name ="last_name" id="last_name" value="{{ $data->last_name }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">Address</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name ="address" id="address" value="{{ $data->address }}">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="mobile"  class="col-sm-2 control-label">Phone number</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name ="phone_number" id="mobile" value="{{ $data->phone_no }}">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="image" class="col-sm-2 control-label">Profile Picture</label>

                    <div class="col-sm-10">
                    <input type="file"  class="form-control" name="image" id="image" onchange="preview_image();"  accept="image/*"  >
                    <!-- <span>Selected image : </span> -->
                    <!-- <img src=" {{Helper::adminImage()}} " alt="admin_image" style="height: 100px; width:100px;"> -->
                    <div id="preview_image"></div>

                    <!-- zoom effect of an image  -->
                    <div id="overlay"></div>
                    <div id="overlayContent">
                        <img id="imgBig" src="" alt="" width="600" height="600" style="margin-right:1000px;" />
                    </div>
                    <!-- ./zoom in effect of an image -->

                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </div>
                </form>



              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane {{$classChangePwd }}" id="change-password">

                <!-- change password form -->
                <form class="form-horizontal" action="{{ URL::to('/admin/settings/profile/change-password') }}" method="post">

                  <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                  <!-- <div class="form-group">
                    <label for="admin_email" class="col-sm-2 control-label">Admin Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="admin_email" id="admin_email" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="old_password" class="col-sm-2 control-label">Old Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="new_password" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="confirm_new_password" class="col-sm-2 control-label">Confirm New Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        <!-- ./profile settings  update profile | change password  -->
      </div>
      <!-- /.row -->

    </section>
@endsection