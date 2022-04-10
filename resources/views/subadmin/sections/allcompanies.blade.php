@extends('subadmin.index')

@if(Auth::guard('subadmin')->user()->add_company_permission == 'off' and Auth::guard('subadmin')->user()->edit_company_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif

@section('content')

<section class="content-header">
      <h1>
        All Companies
        <small>list of registered companies</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Companies</a></li>
        <li class="active">All Companies</li>
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
              <h3 class="box-title">Companies  Table</h3>
              <div class="box-tools">
                @if(Auth::guard('subadmin')->user()->add_company_permission == 'off')

                @else
                <a href="{{ URL::to('subadmin/companies/add-company') }}" class="btn btn bg-navy"> <i class="fa fa-plus ">  </i> Add Company</a>
                @endif
                <!-- <a href="{{ URL::to('subadmin/users/blocked-users') }}" class="btn btn bg-navy"> <i class="fa fa-user-times ">  </i> Check blocked Users</a> -->
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
                    <th>Company Name</th>
                    <th>Company ID</th>
                    <th>Company Description</th>
                    <!-- <th>Image</th> -->
                    <th>Update</th>
                  </tr>
                  </thead>
                  <tbody>
                
                  @foreach( $companies as $row)
                  
                  <tr>
                  
                      
                      <td>{{ $row->id }}</td>
                      <td>
                        @if($row->company_name == null)
                          N/A
                        @else
                          {{ $row->company_name }}
                        @endif
                      </td>
                      <td>
                        @if($row->company_id == null)
                          N/A
                        @else
                          {{ $row->company_id }}
                        @endif
                      </td>
                      <td>
                        @if($row->company_description == null)
                          N/A
                        @else
                          {{ Helper::shortIntro($row->company_description,25) }}
                        @endif
                      </td>
                     
                      
                        <td>
                          <div class="btn-group" style="width:80px;">
                            @if(Auth::guard('subadmin')->user()->edit_company_permission == 'off')
                            
                            @else
                            <a href="{{ URL('/subadmin/companies/edit-company/').'/'.$row->id }}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-xs bg-navy"><i class="fa fa-pencil "></i></a>
                            @endif
                            <a href="{{ URL('/subadmin/companies/view-company/').'/'.$row->id }}" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-success btn-xs"><i class="fa  fa-eye"></i></a>
                            <a href="{{ URL('/subadmin/companies/view-company-employes/').'/'.$row->id }}" data-toggle="tooltip" data-placement="top" title="Associated employees" class="btn btn-success btn-xs"><i class="ion ion-ios-people"></i></a>
                            <!-- <a type="button" data-toggle="modal" data-target="#deleteModal{{$row->id}}"  data-placement="top" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a> -->
                          </div>

                           
                                <!-- Button trigger modal -->
                                <!-- <a data-toggle="modal" data-target="#blockModal{{$row->id}}" class="btn btn-xs bg-navy">Block</a> -->
                                <!--block user Modal -->
                                <div class="modal  fade " id="deleteModal{{$row->id}}" role="dialog" aria-labelledby="blockModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Warning !!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Are you sure you want to delete this company ?  
                                    </div>
                                    <div class="modal-footer">

                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      <a href="{{ URL('/subadmin/companies/company-management/delete-company').'/'.$row->id }}" class="btn bg-navy"> Delete company</a>
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