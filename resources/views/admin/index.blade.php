<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('admin_files/bootstrap/css/bootstrap.min.css ') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ url('admin_files/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('admin_files/plugins/datatables/dataTables.bootstrap.css')}}">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin_files/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ url('admin_files/dist/css/skins/_all-skins.min.css') }}">
  <!-- custom image delete icon css file  -->
  <link rel="stylesheet" href="{{ url('admin_files/dist/css/custom-delete-image-icon.css') }}">
  <!-- toaster side alerts  -->
  <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{ URL::to('admin/dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>ON</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Serve</b> On</span>
    </a>

    <!-- navabr -->
    @include('adminLayouts.navbar')
    <!-- ./navbar -->
  </header>
  <!-- sidebar column. contains the logo and sidebar -->
    @include('adminLayouts.sidebar')
  <!-- /.sidebar column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- all the dashboard pages links are update here -->
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!-- <b>Version</b> 2.3.6 -->
    </div>
    <strong>Copyright &copy; 2021 <a >team@dev.cts</a>.</strong> All rights
    reserved.
  </footer>

  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ url('admin_files/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('admin_files/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('admin_files/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('admin_files/dist/js/app.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('admin_files/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

<!-- DataTables -->
<script src="{{url('admin_files/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ url('admin_files/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ url('admin_files/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ url('admin_files/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ url('admin_files/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ url('admin_files/plugins/chartjs/Chart.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ url('admin_files/dist/js/pages/dashboard2.js') }}"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="{{ url('admin_files/dist/js/demo.js') }}"></script>
<!-- sweet alerts library  -->
<script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@10') }}"></script>
<!-- <script src="{{ url('https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}"></script> -->
<!-- side alerts toaster  -->
<script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>


<script>
$(function () {
    // $("#users").DataTable();
    $("#users").DataTable({});
    $("#providers").DataTable({
      //34589
      'columnDefs': [ {
        'targets': [5,7,8,9], // column index (start from 0)
        'orderable': false, // set orderable false for selected columns
     }]
    });
    $('#categories').DataTable({});
    $('#jobs').DataTable({});
  });
  $('.block_btn').click(function(){
    swal({
      title: "Are you sure you want to block this user?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        swal("User is successfully blocked !", {
          icon: "success",
        });
      } else {
        swal("Your imaginary file is safe!");
      }
    });
  });
  $('.logout_btn').click(function(){
    Swal.fire({
      title: 'Are you sure you want to logout?',
      // text: "You won't be able to revert this!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, logout!'
    }).then((result) => {
      if (result.isConfirmed) {
        // window.location.href="/public/admin/logout";
        window.location.href="/public/admin/logout";
      }
    })
  });
  function preview_image(){
    var img = document.getElementById('image');
    // alert(img);
    if(img.files[0].size >1000000){
      alert('File size is too large to upload ! Please select file less than 1MB');
      $('input#category_image').val('');
    }
    else{
      $('div#preview_image').append("<div class='wrapper-img'><div  class='container-box'><span class='btn btn-xs btn-danger x'>&times;</span><img src='"+URL.createObjectURL(event.target.files[0])+"' style='height: 100px; width:120px;  '></div></div>");
      $('input#image').hide();
      $('span.x').click(function(){
      $(this).closest('div').parent().remove();
      $('input[type=file]').val('');
      $('input#image').show();
    });
    }

  }
  // my function to dummy images 
  $('#add-images-btn').click(function(){
    $('#images_preview').append("<div class='wrapper-img' ><div  class='container-box'><span  class='btn btn-xs btn-danger x'>&times;</span><input name='images[]' id='dummy' type='file' accept='image/*' ></div>");
    $('#add-images-btn').prop('disabled', true);
    $('input#dummy').change(function(){
      
      var x = document.getElementById('dummy');
      if (event.target.files[0].size > 1000000){
        alert('File size is too large to upload ! Please upload file less than 1 MB' );
        $(this).closest('div').parent().remove();
      }
      // for(var i = 0; i<= x.files.lenght){}
      $(this).closest('div').append("<img src='"+URL.createObjectURL(event.target.files[0])+"' style='height: 100px; width:120px; ' accept='image/*'>");
      var img = $(this).closest('div').find('img');
      // console.log(img);
      img.click(function(){
        //it works 
        $("#imgBig").attr("src", $(this).closest('div').find('img').attr("src"));
        $("#overlay").show();
        $("#overlayContent").show();
      })
      $('#imgBig').click(function(){
        $("#overlay").hide();
        $("#overlayContent").hide();
      });
      $('#add-images-btn').prop('disabled', false);
      $(this).hide();
      $('#add-images-btn').val('Add more images');
      // alert(x.files[0].name);
    });
    $('div.wrapper-img div.container-box span.x').click(function(){
      $(this).closest('div').parent().remove(); 
      $('#add-images-btn').val('Add images');
      $('#add-images-btn').prop('disabled', false);
    });
  });
  
</script>
</body>
</html>
