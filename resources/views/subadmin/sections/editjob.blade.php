@extends('subadmin.index')

@section('content')
@if(Auth::guard('subadmin')->user()->edit_job_permission == 'off' and Auth::guard('subadmin')->user()->delete_job_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif
<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Edit Job
        <small>Edit a exsisting job to the list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Jobs</a></li>
        <li class="active">Edit Job</li>
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
              <h3 class="box-title">Edit Job -- {{ $data->id }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ URL::to('/subadmin/jobs/edit-job/'.$data->id) }}" method="post" class="add_agent" enctype="multipart/form-data" class="add_agent">
              <div class="box-body">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input name="edit_job_permission" type="hidden" value="on"/>
                <div class="form-group">
                  <label for="job_title">Job Title</label>
                  <input type="text" class="form-control" name="job_title" id="job_title" placeholder="Enter job title" value="{{ $data->job_title }}">
                </div>
                <div class="form-group">
                  <label for="job_location">Job Location</label>
                  <input type="text" class="form-control" name="job_location" id="job_location" placeholder="Enter job location" value="{{ $data->job_location }}">
                </div>
                <div class="form-group">
                  <label for="job_description">Job Description</label>
                  <textarea class="form-control" name="job_description" id="job_description" placeholder="Add short description here ">{{ $data->job_description }}</textarea>
                </div>
                 <div class="form-group">
                  <label for="image">Images</label>
                  <div class="box box-info">
                    <div class="box-header with-border">
                      
                          <!-- <input type="file" name='images[]' id="gallery-photo-add" multiple> -->
                          <input type="button" id="add-images-btn" value="Add images" class="btn btn-sm bg-navy">
                       
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                      <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                      <!-- box body  -->
                      <div class="timeline-body" style="overflow:auto;height:150px;">
                              @if($data->images != null)
                                @foreach(explode(',',$data->images) as $img)
                                @if($img == null)
  
                                  @break
                                @endif
                           
                                <div id="wrapper">
                                  <div id="container">
                                      <img src="{{ Helper::postJobsImageUrls().'job_id-'.$data->id.'/'.$img }}" class="db_images" alt="images" style="height: 100px; width:120px;">
                                          <!-- <a href="  "  id="button"><i class="fa fa-trash-o"></i></a> -->
                                          <a type="button" data-toggle="modal" data-target="#{{ str_replace('.','0',$img) }}" class="btn btn-xs btn-danger x"><i class="fa fa-trash-o"></i></a>
                                           <!--delete image user Modal -->
                                          <div class="modal  fade " id="{{ str_replace('.','0',$img) }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                  Are you sure you want to Delete this image?
                                                </div>
                                                <div class="modal-footer">

                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                  <a href="{{ URL::to('subadmin/jobs/edit-job/delete-image').'/'.$data->id.'/'.$img }}" class="btn btn-danger">Delete image</a>
                                                  <!-- <a href="" class="btn btn-danger"> Delete property image</a> -->
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>
                                  </div>
                                @endforeach
                              @endif                                                   
                            
                            
                            
                                                      
                                                      <div id="images_preview"></div>
                          
                            <!-- zoom effect of an image  -->
                            <div id="overlay"></div>
                            <div id="overlayContent">
                                <img id="imgBig" src="" alt="" width="600" height="600" style="margin-right:500px;">
                            </div>
                            <!-- ./zoom in effect of an image -->
                      </div>

                    <!-- dummy testing  -->


                    </div>
                    <!-- /.box-body -->
                  </div>
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