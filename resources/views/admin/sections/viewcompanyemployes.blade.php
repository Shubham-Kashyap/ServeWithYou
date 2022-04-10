@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        All Providers
        <small>list of all registered providers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Providers</a></li>
        <li class="active">All Providers</li>
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
              <h3 class="box-title">Providers Table</h3>
              <div class="box-tools">
                <a href="{{ URL::to('admin/providers/add-associated-providers/'.$company_id) }}" class="btn btn bg-navy"> <i class="fa fa-plus ">  </i> Add Provider</a>
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <div class="table table-hover table-responsive">
                <!-- <table id="users" class="table table-hover"> -->
                <table id="providers" class="table display table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Employee ID</th>
                    <th>Email</th>
                    <th>Onboarding</th>
                    <th>Phone Number</th>
                    <th>Blocked Status</th>
                    <th>Company name</th>
                    <th>Service</th>
                    
                    <!-- <th>Experience</th> -->
                    <!-- <th>Rate</th> -->
                    <!-- <th>Working Start Date</th>
                    <th>Working End Date</th>
                    <th>Working Start At</th>
                    <th>Working End At</th> -->
                    <!-- <th>Company Description</th> -->
                    <th>Image</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  @foreach( $providers as $row)
                  @if($row->role === 'provider' and $row->is_blocked === '0')
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
                      <td>{{ $row->employee_id }}</td>
                      <td>
                        @if($row->email == null)
                          N/A
                        @else
                          {{ $row->email }}
                        @endif
                      </td>
                      <td>
                        @if($row->onboarding_status == '0')
                          <span class="label label bg-navy">Pending</span>
                        @else
                          <span class="label  label-success">Completed</span>
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

                      <td>
                        @if($row->company_name == null)
                          N/A
                        @else
                              {{ $row->company_name }}
                          <!-- {{ substr($row->company_name,0,35) }}.... -->
                        @endif
                      </td>

                      <td>
                        @if($row->service != '' )
                            <span class="label label bg-navy text-capitalize">{{$row->service}}</span>
                          @else
                            <span class="text-center">N/A</span>
                        @endif
                      </td>
                      <!-- <td>{{$row->experience}}</td> -->
                      <!-- <td>{{ $row->rate }}</td> -->
                      <!-- <td>{{$row->working_start}}</td>
                      <td>{{$row->working_end}}</td>
                      <td>{{$row->work_start_time}}</td>
                      <td>{{$row->work_end_time}}</td> -->
                      <!-- <td>{{$row->company_description}}</td> -->
                        
                      <td>
                          @if ($row->image != null)
                              @if($row->role == 'provider')
                                <img src="{{ Helper::providerImagesUrls().'id-'.$row->user_id.'/'.$row->image }}" class="img-circle" alt="images" style="height: 50px; width:50px;"></img>
                              @endif
                              @else
                                  <span> </span>
                          @endif
                          </td>
                      <td>
                          <!-- <a href="{{ URL('admin/providers/edit-provider/'.$row->user_id) }}" class="btn btn-xs bg-navy" >Edit</a>
                          <a href="{{ URL('/admin/providers/view-provider/').'/'.$row->user_id }}" class="btn btn-xs btn-success">View</a> -->

                          <div class="btn-group" style="width:80px;">
                            <a href="{{ URL('admin/providers/edit-provider/'.$row->user_id) }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                            <a href="{{ URL('/admin/providers/view-provider/').'/'.$row->user_id }}" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success btn-xs"><i class="fa  fa-eye"></i></a>
                            <a type="button" data-toggle="modal" data-target="#blockModal{{$row->id}}"  data-placement="top" title="Block" class="btn btn-danger btn-xs"><i class="fa fa-user-times"></i></a>
                          </div>

                            
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
                                      <a href="{{ URL('/admin/users/user-management/block-user').'/'.$row->user_id }}" class="btn bg-navy"> Block user</a>
                                      <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                    </div>
                                  </div>
                                </div>
                                </div>
                                             
                            
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