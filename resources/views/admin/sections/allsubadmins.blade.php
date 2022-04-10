@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        All Subadmins
        <small>list of subadmins</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Subadmins</a></li>
        <li class="active">All Subadmins</li>
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
              <h3 class="box-title">Subadmins  Table</h3>
              <div class="box-tools">
                <a href="{{ URL::to('admin/subadmins/add-subadmins') }}" class="btn btn bg-navy"> <i class="fa fa-plus ">  </i> Add Subadmins</a>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <div class="table-responsive">
                <!-- <table id="users" class="table table-hover"> -->
                <table id="users" class="table display table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>Subadmin ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Photo</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($subadmins as $row)
                  <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->tmp_password }}</td>
                    
                    <td>
                      @if($row->image === null)
                        <span>N/A</span>
                        @else
                        <img src="{{ url('/').'/images/subadmin_images/id-'.$row->id.'/'.$row->image }}" class="img-circle" style="height: 50px; width:50px;" alt="">
                      @endif
                      <!-- {{ $row->service_category_image }} -->
                    </td>
                    <td>
                     
                        <div class="btn-group" style="width:80px;">
                          <a href="{{ URL::to('admin/subadmins/edit-subadmin/'.$row->id) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                          <a type="button" data-toggle="modal" data-target="#deleteSubadminModal{{$row->id}}"  data-placement="top" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        </div>
                        <!--delete category Modal -->
                        <div class="modal  fade " id="deleteSubadminModal{{$row->id}}" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this subadmin ?  
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <a href="{{ URL('/admin/subadmins/subadmins-management/delete-subadmin').'/'.$row->id }}" class="btn btn-danger"> Delete subadmin</a>
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