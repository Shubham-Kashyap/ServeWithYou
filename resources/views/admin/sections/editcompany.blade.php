@extends('admin.index')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Edit Company
        <small>Edit Company to the list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Companies</a></li>
        <li class="active">Edit Company</li>
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
              <h3 class="box-title">Edit Company</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ URL::to('/admin/companies/edit-company/'.$data->id) }}" method="post" class="add_agent" enctype="multipart/form-data" class="add_agent">
              <div class="box-body">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter company name" value="{{ $data->company_name }}">
                </div>
                <!-- <div class="form-group">
                  <label for="company_description">Company Description</label>
                  <input type="text" class="form-control" name="company_description" id="company_description" placeholder="Enter company description" value="{{ $data->company_description }}">
                </div> -->
                <div class="form-group">
                  <label for="company_description">Company Description</label>
                  <textarea class="form-control" name="company_description" id="company_description" placeholder="Enter company description">{{ $data->company_description }}</textarea>
                </div>
                <!-- <div class="form-group">
                  <label for="image">Image</label>
                 
                  <input type="file"  class="form-control" name="image" id="image" onchange="preview_image();"  accept="image/*"  >

                  <div id="preview_image"></div>

                    
                    <div id="overlay"></div>
                    <div id="overlayContent">
                        <img id="imgBig" src="" alt="" width="600" height="600" style="margin-right:500px;" />
                    </div>
                 

                </div> -->
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