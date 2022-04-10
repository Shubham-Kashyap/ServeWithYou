@extends('admin.index')

@section('content')

<section class="content-header">
      <h1>
        Rejected Jobs
        <small>list of all Rejected jobs</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Jobs</a></li>
        <li class="active">Rejected Jobs</li>
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
              <h3 class="box-title">Users Table</h3>
              <div class="box-tools">
                <!-- <a href="{{ URL::to('admin/users/blocked-users') }}" class="btn btn bg-navy"> <i class="fa fa-user-times ">  </i> Check blocked Users</a> -->
              </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
              <div class="table-responsive">
                <!-- <table id="users" class="table table-hover"> -->
                <table id="jobs" class="table display table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <!-- <th>Consumer Id</th> -->
                    <!-- <th>Provider Id</th> -->
                    <th>Job Title</th>
                    <!-- <th>Description</th> -->
                    <th>Location</th>
                    <th>Acceptence Status</th>
                    <th>Completion Status</th>
                    <th>Job Date</th>
                    <th>Service Category</th>
                    <th>Job Time</th>
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <!-- <td>{{ $row->consumer_id }}</td> -->
                        <!-- <td>{{ $row->provider_id }}</td> -->
                        <td>
                          @if( $row->job_title == null )
                            N/A
                          @else
                          {{ $row->job_title }}
                          @endif
                        </td>
                        <!-- <td>{{ $row->job_description }}</td> -->
                        <td>
                          @if($row->job_location == null)
                            N/A
                          @else
                            {{ substr($row->job_location,0,20) }}....
                          @endif
                        </td>
                        <td>
                            @if($row->job_status == 'accepted')
                                <span class="label label-xs bg-olive">Accepted</span>
                            @endif
                            @if($row->job_status == 'rejected')
                                <span class="label label-xs bg-navy">Rejected</span>
                            @endif
                            @if($row->job_status == 'not_accepted')
                                <span class="label label-xs bg-navy">Not Accepted</span>
                            @endif
                        </td>
                        <td>
                            @if($row->job_done_status == 'done')
                                <span class="label label-xs bg-navy">Completed</span>
                                @else
                                <span class="label label-xs bg-olive">Pending</span>
                            @endif
                        </td>
                        <td style="width:70px;">{{ $row->job_date }}</td>
                        <td>
                          @if($row->job_category == null)
                            N/A
                          @else
                            {{ $row->job_category }}
                          @endif
                        </td>
                        <td>
                          @if($row->job_time == null)
                            N/A
                          @else
                            <?php
                            // $format = substr($row->job_time,0,50);
                            // dd(var_dump($row->job_time));
                            $date=date_create($row->job_time);
                            print_r(date_format($date,"H:i A"));
                            // dd(date_format($date,"H:i A"));
                            // dd('heloo');
                            ?>
                          @endif
                        </td>
                        <td>
                        <!-- <a href="{{ URL::to('admin/jobs/edit-job/'.$row->id) }}" class="btn btn-xs bg-navy" >Edit</a>
                        <a href="{{ URL::to('admin/jobs/view-job/'.$row->id) }}" class="btn btn-xs btn-success" >View</a>
                        <a type="button" data-toggle="modal" data-target="#{{ 'deleteJob-'.$row->id }}"  class="btn btn-xs btn-danger" >Delete</a> -->
                        
                        <div class="btn-group" style="width:80px;">
                          <a href="{{ URL::to('admin/jobs/edit-job/'.$row->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                          <a href="{{ URL::to('admin/jobs/view-job/'.$row->id) }}"  data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success btn-xs"><i class="fa  fa-eye"></i></a>
                          <a type="button" data-toggle="modal" data-target="#{{ 'deleteJob-'.$row->id }}" data-placement="top" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        </div>
                        
                        <div class="modal  fade " id="{{ 'deleteJob-'.$row->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to Delete this job?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <a href="{{ URL::to('admin/jobs/delete-job/'.$row->id) }}" class="btn bg-navy">Delete Job</a>
                                <!-- <a href="" class="btn btn-danger"> Delete property image</a> -->
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- <a href="{{ URL::to('admin/categories/edit-category/'.$row->id) }}" class="btn btn-xs btn-success" >Edit</a>
                        <a href="{{ URL::to('admin/categories/edit-category/'.$row->id) }}" class="btn btn-xs btn-success" >Edit</a>
                        <a href="{{ URL::to('admin/categories/edit-category/'.$row->id) }}" class="btn btn-xs btn-success" >Edit</a> -->
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