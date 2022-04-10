@extends('admin.index')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Edit subadmin
        <small>Edit & manage subadmin permissions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Subadmins</a></li>
        <li class="active">Edit Subadmin</li>
      </ol>
</section>

    <!-- Main content -->
<section class="content">
      <div class="row">
        <!-- session alerts -->
        <div class="col-md-8 col-md-offset-2 ">
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
              <h3 class="box-title">Edit Subadmin -- {{ $data->id }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ URL::to('/admin/subadmins/edit-subadmin/'.$data->id) }}" method="post" class="add_agent" enctype="multipart/form-data" class="add_agent">
              <div class="box-body">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="form-group">
                  <label for="name">Subadmin Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ $data->name }}">
                </div>
                 
                <div class="form-group">
                  <label for="email">Subadmin Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ $data->email }}" disabled>
                </div> 
                <div class="form-group">
                  <label for="password">Set Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="*************" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirm password</label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="*************" value="{{ old('confirm_password') }}">
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Categories Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add/edit categories to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->add_category_permission == 'on')
                                      <input type="checkbox" name="add_category_permission" checked>
                                    @else
                                      <input type="checkbox" name="add_category_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Add permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->edit_category_permission == 'on')
                                      <input type="checkbox" name="edit_category_permission" checked>
                                    @else
                                      <input type="checkbox" name="edit_category_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Edit permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->delete_category_permission == 'on')
                                      <input type="checkbox" name="delete_category_permission" checked>
                                    @else
                                      <input type="checkbox" name="delete_category_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Delete permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Consumers Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add/edit consumers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->add_consumer_permission == 'on')
                                      <input type="checkbox" name="add_consumer_permission" checked>
                                    @else
                                      <input type="checkbox" name="add_consumer_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Add permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->edit_consumer_permission == 'on')
                                      <input type="checkbox" name="edit_consumer_permission" checked>
                                    @else
                                      <input type="checkbox" name="edit_consumer_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Edit permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Providers Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add/edit providers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->add_provider_permission == 'on')
                                      <input type="checkbox" name="add_provider_permission" checked>
                                    @else
                                      <input type="checkbox" name="add_provider_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Add permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->edit_provider_permission == 'on')
                                      <input type="checkbox" name="edit_provider_permission" checked>
                                    @else
                                      <input type="checkbox" name="edit_provider_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Edit permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Jobs Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add/edit jobs to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->delete_job_permission == 'on')
                                      <input type="checkbox" name="delete_job_permission" checked>
                                    @else
                                      <input type="checkbox" name="delete_job_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Delete permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->edit_job_permission == 'on')
                                      <input type="checkbox"  name="edit_job_permission" checked>
                                    @else
                                      <input type="checkbox"  name="edit_job_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Edit permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Company Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add/edit company to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->add_company_permission == 'on')
                                      <input type="checkbox"  name="add_company_permission" checked>
                                    @else
                                      <input type="checkbox"  name="add_company_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Add permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                              <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->edit_company_permission == 'on')
                                      <input type="checkbox"  name="edit_company_permission" checked>
                                    @else
                                      <input type="checkbox"  name="edit_company_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Edit permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>
                <div class="form-group">
                  <!-- <div class="col-md-12"> -->
                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title">Associated Providers Module</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                        <!-- /.box-tools -->
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <label for="add_permission">Permission for add associated providers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                    @if($data->add_assoc_provider_permission == 'on')
                                      <input type="checkbox"  name="add_assoc_provider_permission" checked>
                                    @else
                                      <input type="checkbox"  name="add_assoc_provider_permission">
                                    @endif
                                    </span>
                                <input type="text" class="form-control" value="Add permission" readonly>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>
                      </div>
                     
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  <!-- </div> -->
                </div>

                <!-- <div class="form-group">
                  <label for="add_permission">Add_Permission for adding new categories/consumers/providers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                  <select id="add_permission" name="add_permission" class="form-control">
                    <option value="{{$data->add_permission}}">Current permission -- 
                    @if($data->add_permission == '1')
                        Yes
                    @else
                        No
                    @endif
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div> 

                <div class="form-group">
                  <label for="edit_permission">Edit_Permission for updating or editing exsisted categories/consumers/providers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                  <select id="edit_permission" name="edit_permission" class="form-control">
                  <option value="{{$data->edit_permission}}">Current permission -- 
                    @if($data->edit_permission == '1')
                        Yes
                    @else
                        No
                    @endif
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div> 

                <div class="form-group">
                  <label for="delete_permission">Delete_Permission for deleting exsisted categories/consumers/providers to the databse ( Yes/No )<span class="text-danger">*</span></label>
                  <select id="delete_permission" name="delete_permission" class="form-control">
                  <option value="{{$data->delete_permission}}">Current permission -- 
                    @if($data->delete_permission == '1')
                        Yes
                    @else
                        No
                    @endif
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>  -->
                
                <div class="form-group">
                  <label for="image">Subadmin Image</label>
                  <!-- <input type="file" name='image' id="agent_image" onclick="preview_agent_image();" accept="image/*" > -->
                  <input type="file"  class="form-control" name="image" id="image" onchange="preview_image();"  accept="image/*"  >

                  <div id="preview_image"></div>

                    <!-- zoom effect of an image  -->
                    <div id="overlay"></div>
                    <div id="overlayContent">
                        <img id="imgBig" src="" alt="" width="600" height="600" style="margin-right:500px;" />
                    </div>
                    <!-- ./zoom in effect of an image -->

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