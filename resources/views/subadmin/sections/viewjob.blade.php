@extends('subadmin.index')

@section('content')

<section class="content-header">
      <h1>
        View Job
        <small>Job details</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Jobs</a></li>
        <li class="active">All Jobss</li>
        <li class="active">view</li>
       
      </ol>
</section>
<section class="content">

<div class="row">
      <div class="col-md-5">
            <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <!-- <div class="widget-user-header bg-navy">
              @if($provider_data->image != null)

                @if($provider_data->role == 'provider')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::providerImagesUrls().'id-'.$provider_data->user_id.'/'.$provider_data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                @if($provider_data->role == 'consumer')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::consumerImagesUrls().'id-'.$provider_data->user_id.'/'.$provider_data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                
                <h3 class="widget-user-username">{{ $provider_data->first_name }}</h3>
                <h5 class="widget-user-desc">Provider</h5>
                @else
                <h3 class="widget-user-username text-capitalize" style="margin-left:0px;">{{ $provider_data->first_name }}</h3>
                <h5 class="widget-user-desc" style="margin-left:0px;">Since {{ substr($provider_data->created_at,0,11) }}</h5>
              @endif
              
              
            </div> -->
            <div class="widget-user-header bg-navy" style="background: url('/admin_files/dist/img/photo1.png') center center;">
              <h3 class="widget-user-username">{{ $provider_data->first_name }} {{  $provider_data->last_name }}</h3>
              <h5 class="widget-user-desc">Provider</h5>
            </div>
            <div class="widget-user-image img-circle" style="height:90px;width:120px;">
              @if($provider_data->image != '')
                <img class="img-circle" style="height:90px;"  src="{{ Helper::providerImagesUrls().'id-'.$provider_data->user_id.'/'.$provider_data->image }}" alt="provider Avatar" >
                @else
                <img class="img-circle" style="height:90px;" src="{{ url('/').'/images/user_images/dummy.jpg' }}" alt="User Avatar">
              @endif
              
            </div>
            <div class="box-footer">
              <div class="row" >
              </div>
              <ul class="nav nav-stacked">
                <li><a>Email <span class="pull-right">{{ $provider_data->email }}</span></a></li>
                <li><a>Bank account number <span class="pull-right ">{{ $provider_data->account_number }}</span></a></li>
                <li><a>Phone Number <span class="pull-right ">{{ $provider_data->phone_no }}</span></a></li>
                <li><a>Service  <span class="pull-right label label bg-navy">{{ $provider_data->service }}</span></a></li>
                <li><a>Experience  <span class="pull-right ">{{ $provider_data->experience }} Years</span></a></li>
              </ul>
              <a href="{{ URL('/subadmin/providers/view-provider/').'/'.$provider_data->user_id }}" target="_blank" class="btn bg-navy btn-block"><b>view more info</b></a>
            
            </div>
          </div>
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-navy" style="background: url('/admin_files/dist/img/photo1.png') center center;">
              <h3 class="widget-user-username">{{ $consumer_data->first_name }} {{  $consumer_data->last_name }}</h3>
              <h5 class="widget-user-desc">Consumer</h5>
            </div>
            <div class="widget-user-image" style="height:90px;width:90px;">
              @if($consumer_data->image != '')
                <img class="img-circle" style="height:90px;" src="{{ Helper::consumerImagesUrls().'id-'.$consumer_data->user_id.'/'.$consumer_data->image }}" alt="consumer Avatar" >
                @else
                <img class="img-circle" style="height:90px;" src="{{ url('/').'/images/user_images/dummy.jpg' }}" alt="User Avatar">
              @endif
              
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"> {{ Helper::consumerPostedJobsCount($consumer_data->user_id,$provider_data->user_id)}}</h5>
                    <span class="description-text">JOBS POSTED</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{ Helper::consumerdoneJobsCount($consumer_data->user_id,$provider_data->user_id)}}</h5>
                    <span class="description-text">JOBS DONE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">{{ Helper::consumerRejectedJobsCount($consumer_data->user_id,$provider_data->user_id) }}</h5>
                    <span class="description-text">JOBS REJECTED</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                
              </div>
              <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a>Consumer Email <span class="pull-right">{{ $consumer_data->email }}</span></a></li>
                <!-- <li><a>Location <span class="pull-right ">{{ $consumer_data->address }}</span></a></li> -->
                <li><a>Phone Number <span class="pull-right ">{{ $consumer_data->phone_no }}</span></a></li>
                <!-- <li><a>Service  <span class="pull-right label label bg-navy">{{ $provider_data->service }}</span></a></li> -->
                <!-- <li><a>Experience  <span class="pull-right ">{{ $provider_data->experience }} Years</span></a></li> -->
              </ul>
              <a href="{{ URL::to('subadmin/jobs/all-jobs') }}" class="btn bg-navy btn-block"><b>Go Back</b></a>
            </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->

      </div>
      <!-- zoom effect of an image  -->
      <div id="overlay"></div>
        <div id="overlayContent">
        <img id="imgBig" src="" alt=""  class="db_images" width="600" height="600" style="margin-right:450px;" />
      </div>
      <!-- ./zoom in effect of an image -->
      <div class="col-md-7">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                  {{ substr($job_data->created_at,8,2) }} / {{ substr($job_data->created_at,5,2) }} / {{ substr($job_data->created_at,0,4) }}
                  <!-- Other information -->
                  </span>
            </li>
            <!-- /.timeline-label -->
            
            
            
            <!-- timeline time label -->
            <!-- <li class="time-label">
                  <span class="bg-green">
                    3 Jan. 2014
                  </span>
            </li> -->
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-camera bg-purple"></i>

              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Job Images</a> </h3>
                <!-- <div class="timeline-body">
                  <img class="img-responsive pad" src="" alt="Photo">
                </div> -->
                <!-- <div class="timeline-body" style="overflow:auto;height:200px;"> -->
                @if($job_data->images == null)
                <div class="timeline-body" >
                  <h5>Not-available </h5>
                @else
                <div class="timeline-body" style="overflow:auto;height:200px;">
                @endif
                  @foreach(explode(',',$job_data->images) as $img)
                    @if($img == null)
                    
                    @break
                    @endif
                    <img src="{{ Helper::postJobsImageUrls().'job_id-'.$job_data->id.'/'.$img }}" class="margin db_images" alt="images" style="height: 100px; width:120px;"></img>
                  @endforeach
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- zoom effect of an image  -->
                <div id="overlay"></div>
                    <div id="overlayContent">
                    <img id="imgBig" src="" alt=""  class="db_images" width="600" height="600" style="margin-right:3500px;" />
                </div>
                <!-- ./zoom in effect of an image -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-share-alt bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a >Job Description</a> </h3>
                <div class="timeline-body ">
                    @if($job_data->job_description != null)
                    <h5>{{ $job_data->job_description }} </h5>
                    @else
                    <h5>Not-available</h5>
                    @endif
                </div>
                <div class="timeline-footer">
                  <!-- <a class="btn btn-primary btn-xs">Read more</a> -->
                  <!-- <a class="btn btn-danger btn-xs">Delete</a> -->
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <li>
              <i class="fa fa-location-arrow bg-navy"></i>
              <div class="timeline-item">
                

                <h3 class="timeline-header"><a >Job Location</a> </h3>

                <div class="timeline-body ">
                    <h5>
                    {{ $job_data->job_location }} 
                    </h5>
                </div>
                <!-- <div class="timeline-footer">
                  <a class="btn btn-primary btn-xs">Read more</a>
                  <a class="btn btn-danger btn-xs">Delete</a>
                </div> -->
              </div>
            </li>


            <li>
                <i class="fa fa-clock-o bg-grey"></i>
            </li>

          </ul>
        </div>
</div>
<div class="row">
<div class="col-md-4">
          
        </div>
</div>
</section>

@endsection