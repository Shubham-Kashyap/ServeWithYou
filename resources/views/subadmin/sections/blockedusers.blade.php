@extends('subadmin.index')

@section('content')

<section class="content-header">
      <h1>
        Blocked Users
        <small>>List of blocked users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Blocked Users</li>
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
              <h3 class="box-title">Blocked Users Table</h3>
              <div class="box-tools">
                <!-- <a href="{{ URL::to('subadmin/users/all-users') }}" class="btn btn bg-olive"> Check un-blocked users</a> -->
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
                    <th>Role</th>
                    <!-- <th>Email Verified At</th> -->
                    <th>Blocked Status</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Image</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  @foreach( $users as $row)
                  @if( $row->is_blocked == '1')
                  <tr>
                  
                      <td>{{ $row->id }}</td>
                      <td>{{ $row->first_name }}</td>
                      <td>{{ $row->last_name }}</td>
                      <td>{{ $row->email }}</td>
                      <td>
                        @if($row->role == 'consumer')
                        <span class="label label-sm bg-navy">Consumer</span>
                        @else
                        <span class="label label-sm bg-olive">Provider</span>
                        @endif
                      </td>
                      <td>
                        @if($row->is_blocked == '0')

                            <span class="label label bg-olive">Un-blocked</span>
                          @else
                            <span class="label label bg-navy">Blocked</span>
                        @endif
                      </td>
                      
                      <td>{{$row->address}}</td>

                      

                      <td>{{$row->phone_no}}</td>

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
                      <td>
                          <!-- <a href="{{ URL('/subadmin/user-management/user/edit').'/'.$row->id }}" class="btn btn-xs btn-success" >Edit</a> -->
                          <!-- Button trigger modal -->
                          <!-- <a type="button"  data-toggle="modal" data-target="#deleteModal{{$row->id}}" class="btn btn-xs btn-danger">delete</a> -->
                          <!-- <a href="{{ URL('/subadmin/users/view-user/').'/'.$row->id }}" class="btn btn-xs btn-success"> view</a> -->

                                <!--delete user Modal -->
                                <!-- <div class="modal modal-danger fade " id="deleteModal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Danger !!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        Are you sure you want to Delete ? 
                                      </div>
                                      <div class="modal-footer">

                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <a href="{{ URL('/subadmin/user-management/user/delete').'/'.$row->id }}" class="btn btn-danger"> Delete user</a>
                                      </div>
                                    </div>
                                  </div>
                                </div> -->

                            @if($row->is_blocked === '1')
                              <!-- Button trigger modal -->
                              <!-- <a data-toggle="modal" data-target="#unblockModal{{$row->id}}" class="btn btn-xs bg-navy">Unblock user</a>  -->

                              <div class="btn-group" style="width:80px;">
                                
                                <a type="button" data-toggle="modal" data-target="#unblockModal{{$row->id}}"  data-placement="top" title="Unblock" class="btn btn-danger btn-xs"><i class="fa fa-user"></i></a>
                              </div>

                              <!--unblock user Modal -->
                              <div class="modal  fade " id="unblockModal{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="unblockModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to unblock this user  ?
                                    </div>
                                    <div class="modal-footer">

                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      <a href="{{ URL('/subadmin/users/user-management/unblock-user/').'/'.$row->id }}" class="btn btn bg-navy"> Unblock user </a>
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