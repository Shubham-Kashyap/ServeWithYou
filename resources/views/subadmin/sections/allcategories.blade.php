@extends('subadmin.index')

@section('content')
@if(Auth::guard('subadmin')->user()->add_category_permission == 'off' and Auth::guard('subadmin')->user()->edit_category_permission == 'off' and Auth::guard('subadmin')->user()->delete_category_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif
<section class="content-header">
      <h1>
        All Categories
        <small>list of job categories</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Categories</a></li>
        <li class="active">All Categories</li>
      </ol>
</section>
<section class="content">
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button> -->

<div class="row">
      <!-- session alerts -->
      <div class="col-md-12">
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
</div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Categories  Table</h3>
              <div class="box-tools">
              @if(Auth::guard('subadmin')->user()->add_permission == '1')
                <a href="{{ URL::to('subadmin/categories/add-categories') }}" class="btn btn bg-navy"> <i class="fa fa-plus ">  </i> Add Categories</a>
              @endif
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <div class="table-responsive">
                <!-- <table id="users" class="table table-hover"> -->
                <table id="categories" class="table display table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>Category ID</th>
                    <th>Service Category Name</th>
                    <th>Category Image</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $row)
                  <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->service_category }}</td>
                    <td>
                      @if($row->service_category_image === null)
                        <span></span>
                        @else
                        <img src="{{ Helper::categoriesImagesUrls().'id-'.$row->id.'/'.$row->service_category_image  }}" class="img-circle" style="height: 50px; width:50px;" alt="">
                      @endif
                      <!-- {{ $row->service_category_image }} -->
                    </td>
                    <td>
                      <!-- <a href="{{ URL::to('subadmin/categories/edit-category/'.$row->id) }}" class="btn btn-xs bg-navy" >Edit</a> -->
                      <!-- <a href="{{ URL::to('subadmin/categories/delete-category/'.$row->id) }}" class="btn btn-xs bg-navy" >Delete</a> -->

                        <div class="btn-group" style="width:80px;">
                          @if(Auth::guard('subadmin')->user()->edit_category_permission == 'on')
                          <a href="{{ URL::to('subadmin/categories/edit-category/'.$row->id) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                          @else

                          @endif
                          
                          @if(Auth::guard('subadmin')->user()->delete_category_permission == 'on')
                          <a type="button" data-toggle="modal" data-target="#deleteModal{{$row->id}}"  data-placement="top" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                          @else

                          @endif
                          
                        </div>
                        @if(Auth::guard('subadmin')->user()->edit_category_permission == 'off' and Auth::guard('subadmin')->user()->delete_category_permission == 'off')
                         Access Denied
                        @endif
                               <!-- Button trigger modal -->
                              <!-- <a data-toggle="modal" data-target="#deleteModal{{$row->id}}" class="btn btn-xs btn-danger"> Delete</a> -->
                                <!--delete category Modal -->
                                <div class="modal  fade " id="deleteModal{{$row->id}}" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to delete this category ?  
                                    </div>
                                    <div class="modal-footer">

                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      <a href="{{ URL('/subadmin/categories/categories-management/delete-category').'/'.$row->id }}" class="btn btn-danger"> Delete category</a>
                                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                  </div>
                                </div>
                                </div>
                       
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          
</section>

@endsection