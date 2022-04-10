@extends('subadmin.index')

@section('content')
@if(Auth::guard('subadmin')->user()->add_provider_permission == 'off' and Auth::guard('subadmin')->user()->edit_provider_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif
<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Edit Provider 
        <small>Edit a exsisting provider to the list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Providers</a></li>
        <li class="active">Edit Provider</li>
      </ol>
</section>

    <!-- Main content -->
<section class="content">
      <div class="row">
        <!-- session alerts -->
        <div class="col-md-8 col-md-offset-2">
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
       
        <div class="col-md-8 col-md-offset-2">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Provider -- {{ $data->user_id }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ URL::to('/subadmin/providers/edit-provider/'.$data->user_id) }}" method="post" class="add_agent" enctype="multipart/form-data" class="add_agent">
              <div class="box-body">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input name="edit_provider_permission" type="hidden" value="on"/>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" name="first_name" id="last_name" placeholder="Enter first name" value="{{ $data->first_name }}">
                </div>
                <div class="form-group">
                  <label for="first_name">Last Name</label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name" value="{{ $data->last_name }}">
                </div>
                <div class="form-group">
                  <label for="phone_number">Phone Number</label>
                  <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number" value="{{ $data->phone_no }}" disabled>
                </div>
                <!-- <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ $data->email }}">
                </div>
                 -->
                 <div class="form-group">
                  <label for="company">Assign Company</label>
                  <select name="company" id="company" class="form-control select-2">
                  <option value="">Select company name that you want to assign to this provider</option>
                  @foreach(Helper::fetchingCompaniesData() as $company)
                    <option value="{{$company->company_id}}">{{ $company->company_name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="{{ $data->address }}">
                </div>
                <div class="form-group">
                  <label for="state">State</label>
                  <input type="text" class="form-control" name="state" id="state" placeholder="Enter State" value="{{ $data->state }}">
                </div>
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" value="{{ $data->country }}">
                </div>
                <div class="form-group">
                  <label for="account_number">Account Number</label>
                  <input type="text" class="form-control" name="account_number" id="accpunt" placeholder="Enter account number" value="{{ $data->account_number }}" disabled>
                </div>
                <div class="form-group">
                  <label for="image">Image</label>
                  <!-- <input type="file" name='image' id="agent_image" onclick="preview_agent_image();" accept="image/*" > -->
                  <input type="file"  class="form-control" name="image" id="image" onchange="preview_image();"  accept="image/*"  >

                  <div id="preview_image"></div>

                    <!-- zoom effect of an image  -->
                    <div id="overlay"></div>
                    <div id="overlayContent">
                        <img id="imgBig" src="" alt="" width="600" height="600" style="margin-right:500px;" />
                    </div>
                    <!-- ./zoom in effect of an image -->

                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary ajax_agent">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div id="loader"></div>

</section>
<!-- /.content -->
@endsection