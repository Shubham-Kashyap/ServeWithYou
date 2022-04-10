@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        All users
        <small>list of users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">all users</li>
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
              <h3 class="box-title">Users  Table</h3>
              <div class="box-tools">
                <a href="{{ URL::to('admin/users/blocked-users') }}" class="btn btn bg-navy"> <i class="fa fa-user-times ">  </i> Check blocked Users</a>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <div class="table-responsive">
                <!-- <table id="users" class="table table-hover"> -->
                <table id="users" class="table display table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Blocked Status</th>
                    <th>Address</th>
                    
                    <th>Image</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  @foreach( $users as $row)
                  @if($row->role != 'admin' and $row->is_blocked != '1')
                  <tr>
                  
                      <td>{{ $row->id }}</td>
                      <td>{{ $row->first_name }}</td>
                      <td>{{ $row->last_name }}</td>
                      <td>{{ $row->email }}</td>
                      <td>{{$row->phone_no}}</td>
                      <td>
                        @if($row->is_blocked == '0')

                            <span class="label label bg-olive">un-blocked</span>
                          @else
                            <span class="label label bg-navy">blocked</span>
                        @endif
                      </td>

                      <td style="">{{$row->address}}</td>

                      <td>
                          @if ($row->image != null)
                              @if($row->role == 'provider')
                                <img src="{{ Helper::providerImagesUrls().'id-'.$row->id.'/'.$row->image }}" class="img-circle" alt="images" style="height: 50px; width:50px;"></img>
                              @endif
                              @if($row->role == 'consumer')
                                <img src="{{ Helper::consumerImagesUrls().'id-'.$row->id.'/'.$row->image }}" class="img-circle" alt="images" style="height: 50px; width:50px;"></img>
                              @endif
                              @else
                                  <span> </span>
                          @endif
                          </td>
                      <td>
                          <!-- <a href="" class="btn btn-xs btn-success" >Edit</a> -->
                          <!-- Button trigger modal -->
                          <a href="{{ URL('/admin/users/view-user/').'/'.$row->id }}" class="btn btn-xs btn-success"> view</a>
                            @if($row->is_blocked === '0')
                                <!-- Button trigger modal -->
                                <a data-toggle="modal" data-target="#blockModal{{$row->id}}" class="btn btn-xs bg-navy"> block user</a>
                                <!--block user Modal -->
                                <div class="modal  fade " id="blockModal{{$row->id}}" role="dialog" aria-labelledby="blockModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to block this user ?  
                                    </div>
                                    <div class="modal-footer">

                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      <a href="{{ URL('/admin/users/user-management/block-user').'/'.$row->id }}" class="btn bg-navy"> block user</a>
                                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                  </div>
                                </div>
                                </div>
                                             
                            @endif
                      </td>
                  
                  </tr>
                  @endif
                  @endforeach
                
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          
</section>

@endsection