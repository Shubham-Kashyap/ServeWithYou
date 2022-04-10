@extends('subadmin.index')

@section('content')
<style>
    .loader {
      border: 10px solid #f3f3f3;
      border-radius: 50%;
      border-top: 10px solid #3498db;
      width: 50px;
      height: 50px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>
@if(Auth::guard('subadmin')->user()->add_provider_permission == 'off' and Auth::guard('subadmin')->user()->edit_provider_permission == 'off')
    <?php
      echo "<h1>Unauthorized access</h1>";
      exit();
    ?>
@endif
<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Add Provider
        <small>Add a new provider to the list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL::to('subadmin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Providers</a></li>
        <li class="active">Add Provider</li>
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
              <h3 class="box-title">Add Provider</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ URL::to('/subadmin/providers/add-providers') }}" method="post" class="add_agent" enctype="multipart/form-data" class="add_agent">
              <div class="box-body">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <input name="add_provider_permission" type="hidden" value="on"/>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" name="first_name" id="last_name" placeholder="Enter first name" value="{{ old('first_name') }}">
                </div>
                <div class="form-group">
                  <label for="first_name">Last Name</label>
                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name" value="{{ old('last_name') }}">
                </div>
                <div class="form-group">
                  <label for="phone_no">Phone Number</label>
                  <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Enter phone number" value="{{ old('phone_no') }}">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="*************" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="*************" value="{{ old('confirm_passoword') }}">
                </div>
                <div class="form-group">
                  <label for="service">Service</label>
                  <select name="service" id="service" class="form-control select-2">
                  <option value="">Select service category</option>
                  @foreach(Helper::fetchingCategoryData() as $service)
                    <option value="{{$service->service_category}}">{{ $service->service_category }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="company">Assign Company</label>
                  <select name="company" id="company" class="form-control select-2">
                  <option value="">Select company name that you want to assign to this provider</option>
                  @foreach(Helper::fetchingCompaniesData() as $company)
                    <option value="{{$company->company_id}}">{{ $company->company_name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="company_name">Hourly rate</label>
                    <input type="number" class="form-control" name="rate" id="rate" placeholder="Enter hourly rate"  min="1">
                </div>
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter company name" value="{{ old('company_name') }}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="branch" placeholder="Enter Address" value="{{ old('address') }}" onkeyup="searchBranch();" required>
                    <div id="address"></div>

                  <input type="hidden" class="form-control"  id="lat" name="lat" value="">
                  <input type="hidden" class="form-control" id="long" name="long" value="">
                  <input type="hidden" class="form-control" id="administrative_area_level_1" name="state" value="">
                  <input type="hidden" class="form-control" id="administrative_area_level_2" name="city" value="">

                  <input type="hidden" class="form-control" id="administrative_area_level_3" name="subdistt" value="">
                  {{-- <input type="hidden" class="form-control" id="country" name="country" value=""> --}}
                  <input type="hidden" class="form-control" id="locality" name="locality" value="">
                  <input type="hidden" class="form-control" id="postal_code" name="postal_code" value="">
                    <div class="d-flex justify-content-center col-md-12">
                      <div id="setloader"></div>
                      </div>
                  </div>
                <div class="form-group">
                  <label for="state">State</label>
                  <input type="text" class="form-control" name="state" id="state" placeholder="Enter State" value="{{ old('state') }}">
                </div>
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" value="{{ old('country') }}">
                </div>
                <!-- <div class="form-group">
                  <label for="account_number">Account Number</label>
                  <input type="text" class="form-control" name="account_number" id="accpunt" placeholder="Enter account number" value="{{ old('account_number') }}">
                </div> -->
                <div class="form-group">
                  <label for="image">Image</label>
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

<script>
    async function searchBranch(){
document.getElementById("setloader").classList.add("loader");
const city = document.getElementById("branch").value;
if(city.length == 0){
    document.getElementById("setloader").classList.remove("loader");
    document.getElementById('address').innerHTML = ""
}
try{
    const response = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${city}&key=AIzaSyAI5m5Fy7Y7rppLxcQyLxzr4OuSbr_SsdM`);

const result = await response.json();
if(result.results.length > 0){
    document.getElementById("setloader").classList.remove("loader");
}


     document.getElementById('address').innerHTML = `<li style="list-style: none;
background: aliceblue;
padding: 10px;
font-size: 14px;cursor: pointer;
color: darkblue;" id="city_name" onmouseout="this.style.color ='black'" onmouseover="this.style.color ='#1677db'">${result.results[0].formatted_address}</li>`


                document.getElementById('city_name').addEventListener('click',(e)=>{
                    e.preventDefault();
                    let device_loc = {};
                    result.results[0].address_components.map((item, index) => {
                        if (item.types[0] == 'administrative_area_level_1') {
                        console.log('state', item.long_name);
                        device_loc.state  = item.long_name
                        } else if (item.types[0] == 'administrative_area_level_2') {
                        console.log('dist', item.long_name);
                        device_loc.distt = item.long_name
                        } else if (item.types[0] == 'administrative_area_level_3') {
                        device_loc.sub_distt = item.long_name
                        } else if (item.types[0] == 'country') {
                        //country
                        console.log('country', item.long_name);
                        device_loc.country = item.long_name
                        } else if (item.types[0] == 'locality') {
                        // City
                        console.log('city', item.long_name);
                        device_loc.city = item.long_name
                        } else if (item.types[0] == 'postal_code') {
                        // pincode
                        device_loc.postal = item.long_name
                        console.log('pincode', item.long_name);
                        }
                    });

                     document.getElementById('branch').value= result.results[0].formatted_address;
                     document.getElementById('lat').value = result.results[0].geometry.location.lat
                     document.getElementById('long').value = result.results[0].geometry.location.lng
                     document.getElementById('administrative_area_level_1').value = device_loc.state||null
                     document.getElementById('administrative_area_level_2').value = device_loc.distt||null
                     document.getElementById('administrative_area_level_3').value = device_loc.sub_distt||null
                     document.getElementById('country').value = device_loc.country||null
                     document.getElementById('locality').value = device_loc.city||null
                     document.getElementById('postal_code').value = device_loc.postal||null
                     document.getElementById('city_name').innerHTML = ""


                    //  save state and country information to input tags
                    document.getElementById('state').value =  device_loc.state||null
                    document.getElementById('country').value = device_loc.country||null



                })
// })
}catch(err){
    console.log(err.message)
}

}


</script>
@endsection
