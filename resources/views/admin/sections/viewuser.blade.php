@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        View User
        <small>View user profile</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">view</a></li>
        <li >view user</li>
        <li class="active">View</li>
      </ol>
</section>
<section class="content">

    <div class="row">
      <div class="col-md-8 col-md-offset-2">

          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-navy">
              @if($data->image != null)

                @if($data->role == 'provider')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::providerImagesUrls().'id-'.$data->id.'/'.$data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                @if($data->role == 'consumer')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::consumerImagesUrls().'id-'.$data->id.'/'.$data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ $data->first_name }}</h3>
                <h5 class="widget-user-desc">Since {{ substr($data->created_at,0,11) }}</h5>
                @else
                <h3 class="widget-user-username text-capitalize" style="margin-left:0px;">{{ $data->first_name }}</h3>
                <h5 class="widget-user-desc" style="margin-left:0px;">Since {{ substr($data->created_at,0,11) }}</h5>
              @endif
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><i class="fa fa-envelope margin-r-5"></i>Email <span class="pull-right">{{ $data->email }}</span></a></li>
                <!-- <li><a><i class="fa fa-odnoklassniki margin-r-5"></i>Gender <span class="pull-right ">{{ $data->phone_no }}</span></a></li> -->
                <li><a><i class="fa fa-map-marker margin-r-5"></i>Location <span class="pull-right ">{{ $data->address }}</span></a></li>
                <li><a><i class="fa fa-phone margin-r-5"></i>Mobile number <span class="pull-right">{{ $data->phone_no }}</span></a></li>
              </ul>
              
              <a href="{{ URL::to('admin/users/all-users') }}" class="btn bg-navy btn-block"><b>Go Back</b></a>
                
            </div>
            

          </div>

      
      </div>
    </div>

    <div class="row">

      
    </div>
</section>

@endsection