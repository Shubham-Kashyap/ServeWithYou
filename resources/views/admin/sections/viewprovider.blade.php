@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        View Provider Profile
        <small>view provider details</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Providers</a></li>
        <!-- <li class="active">All providers</li> -->
        <li class="active">View Provider</li>
        <!-- <li class="active">provider profile</li> -->
      </ol>
</section>
<section class="content">

<div class="row">
      <div class="col-md-5">
            <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-navy">
              @if($data->image != null)

                @if($data->role == 'provider')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::providerImagesUrls().'id-'.$data->user_id.'/'.$data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                @if($data->role == 'consumer')
                <div class="widget-user-image"> 
                  <img class="img-circle"  src="{{ Helper::consumerImagesUrls().'id-'.$data->user_id.'/'.$data->image }}" style="height:65px;width:65px;" alt="User Avatar">
                </div>
                @endif
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ $data->first_name }} {{ $data->last_name }}</h3>
                <h5 class="widget-user-desc">Since {{ substr($data->created_at,0,11) }}</h5>
                @else
                <h3 class="widget-user-username text-capitalize" style="margin-left:0px;">{{ $data->first_name }}</h3>
                <h5 class="widget-user-desc" style="margin-left:0px;">Since {{ substr($data->created_at,0,11) }}</h5>
              @endif
              
              
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a>Email <span class="pull-right">{{ $data->email }}</span></a></li>
                <!-- <li><a>Location <span class="pull-right ">{{ $data->address }}</span></a></li> -->
                <li><a>Phone Number <span class="pull-right ">{{ $data->phone_no }}</span></a></li>
                <li><a>Service  <span class="pull-right label label bg-navy">{{ $data->service }}</span></a></li>
                <li><a>Experience  <span class="pull-right "><strong>{{ $data->experience }}  Years</strong></span></a></li>
                
              </ul>
              
              <a href="{{ URL::to('admin/providers/all-providers') }}" class="btn bg-navy btn-block"><b>Go Back</b></a>
                
            </div>
            

          </div>


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
                  {{ substr($data->created_at,8,2) }} / {{ substr($data->created_at,5,2) }} / {{ substr($data->created_at,0,4) }}
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
             

                <h3 class="timeline-header"><a href="#">Provider Done Jobs Images</a> </h3>

                <!-- <div class="timeline-body">
                  <img class="img-responsive pad" src="" alt="Photo">
                </div> -->
                <!-- <div class="timeline-body" style="overflow:auto;height:200px;"> -->
                @if($data->done_jobs_images == null)
                <div class="timeline-body" >
                  <h4>Not-available </h4>
                @else
                <div class="timeline-body" style="overflow:auto;height:300px;">
                @endif
                  @foreach(explode(',',$data->done_jobs_images) as $img)
                    @if($img == null)
                    
                    @break
                    @endif
                    <img src="{{ Helper::doneJobsImagesUrls().'id-'.$data->user_id.'/'.$img }}" class="margin db_images" alt="images" style="height: 100px; width:120px;"></img>
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
                

                <h3 class="timeline-header"><a >Company Description</a> </h3>

                <div class="timeline-body ">
                    @if($data->company_description != null)
                    <h4>{{ $data->company_description }} </h4>
                    @else
                    <h4>Not-available</h4>
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
                

                <h3 class="timeline-header"><a >Current Location</a> </h3>

                <div class="timeline-body ">
                    <h4>
                    {{ $data->address }} 
                    </h4>
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
</section>

@endsection