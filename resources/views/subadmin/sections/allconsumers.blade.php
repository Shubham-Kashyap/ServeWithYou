@extends('subadmin.index')

@section('content')
@if(Auth::guard('subadmin')->user()->add_consumer_permission == 'off' and Auth::guard('subadmin')->user()->edit_consumer_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif
<section class="content-header">
      <h1>
        All Consumers
        <small>list of registered consumers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Consumers</a></li>
        <li class="active">All Consumers</li>
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
              <h3 class="box-title">Consumers  Table</h3>
              <div class="box-tools">
              @if(Auth::guard('subadmin')->user()->add_consumer_permission)
                <a href="{{ URL::to('subadmin/consumers/add-consumer') }}" class="btn btn bg-navy"> <i class="fa fa-plus ">  </i> Add Consumers</a>
              @endif
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
                    <!-- <th>Role</th> -->
                    <!-- <th>Address</th> -->
                    
                    <th>Image</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  @foreach( $consumers as $row)
                  @if($row->role != 'admin' and $row->is_blocked != '1')
                  <tr>
                  
                      
                      <td>{{ $row->user_id }}</td>
                      <td>
                        @if($row->first_name == null)
                          N/A
                        @else
                          {{ $row->first_name }}
                        @endif
                      </td>
                      <td>
                        @if($row->last_name == null)
                          N/A
                        @else
                          {{ $row->last_name }}
                        @endif
                      </td>
                      <td>
                        @if($row->email == null)
                          N/A
                        @else
                          {{ $row->email }}
                        @endif
                      </td>
                      <td>
                        @if($row->phone_no == null)
                          N/A
                        @else
                          {{ $row->phone_no }}
                        @endif
                      </td>
                      <td>
                        @if($row->is_blocked == '0')

                            <span class="label label bg-olive">Un-blocked</span>
                          @else
                            <span class="label label bg-navy">Blocked</span>
                        @endif
                      </td>
                      <!-- <td>{{ $row->role }}</td> -->
                      <!-- <td style="">{{$row->address}}</td> -->

                      <td>
                          @if ($row->image != null)
                              @if($row->role == 'provider')
                                <img src="{{ Helper::providerImagesUrls().'id-'.$row->user_id.'/'.$row->image }}" class="img-circle" alt="images" style="height: 50px; width:50px;"></img>
                              @endif
                              @if($row->role == 'consumer')
                                <img src="{{ Helper::consumerImagesUrls().'id-'.$row->user_id.'/'.$row->image }}" class="img-circle" alt="images" style="height: 50px; width:50px;"></img>
                              @endif
                              @else
                                  <span class="text-center">N/A</span>
                          @endif
                          </td>
                      <td>
                          <!-- <a href="" class="btn btn-xs btn-success" >Edit</a> -->
                          <!-- Button trigger modal -->
                          <!-- <a href="{{ URL('/subadmin/consumers/edit-consumer/').'/'.$row->user_id }}" class="btn btn-xs bg-navy">Edit</a> -->
                          <!-- <a href="{{ URL('/subadmin/consumers/view-consumer/').'/'.$row->user_id }}" class="btn btn-xs btn-success">View</a> -->

                          <div class="btn-group" style="width:80px;">
                          @if(Auth::guard('subadmin')->user()->edit_consumer_permission == 'on')
                            <a href="{{ URL('/subadmin/consumers/edit-consumer/').'/'.$row->user_id }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                          @endif
                            <a href="{{ URL('/subadmin/consumers/view-consumer/').'/'.$row->user_id }}" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success btn-xs"><i class="fa  fa-eye"></i></a>
                            <a type="button" data-toggle="modal" data-target="#blockModal{{$row->id}}"  data-placement="top" title="Block" class="btn btn-danger btn-xs"><i class="fa fa-user-times"></i></a>
                          </div>

                            @if($row->is_blocked === '0')
                                <!-- Button trigger modal -->
                                <!-- <a data-toggle="modal" data-target="#blockModal{{$row->id}}" class="btn btn-xs bg-navy">Block</a> -->
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
                                      <a href="{{ URL('/subadmin/users/user-management/block-user').'/'.$row->user_id }}" class="btn bg-navy"> Block user</a>
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