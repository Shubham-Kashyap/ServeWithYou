
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{ config('app.name', 'FarmerApp') }} - admin dashboard</title>
	<link rel="shortcut icon" href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk9CkndiqIMYZbsXkLqjVBhVQJRMXPc6HiuA&usqp=CAU">
	<!-- Global stylesheets -->
	<link href="{{ URL::to('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('admin_files/assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ URL::to('/admin_files/global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>
	<!-- Theme datatable  files -->
	<script src="{{ URl::to('admin_files/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ URl::to('admin_files/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>

	<script src="{{ URl::to('admin_files/global_assets/js/demo_pages/datatables_advanced.js') }}"></script>
	<!-- /theme datatable files -->
	<!-- Theme file uploader -->
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/demo_pages/uploader_bootstrap.js') }}"></script>

	<!-- Theme JS forms -->
	
	<!-- Theme JS files -->
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/demo_pages/form_layouts.js') }}"></script>

	<!-- theme js modals  -->
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/notifications/bootbox.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/demo_pages/components_modals.js') }}"></script>
	<!-- theme js modals  -->

	<!-- theme js progress bar and spinners  -->
	<script src="{{ URL::to('admin_files/global_assets/js/plugins/loaders/progressbar.min.js') }}"></script>
	<script src="{{ URL::to('admin_files/global_assets/js/demo_pages/components_progress.js') }}"></script>
	<!-- theme js progress bar and spinners  -->

	<script src="{{ URL::to('/admin_files/assets/js/app.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/demo_pages/dashboard.js') }}"></script>
	<!-- /theme JS files -->

	<!-- gowl notify -->
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/notifications/noty.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/demo_pages/extra_jgrowl_noty.js') }}"></script>
	<!-- /.gowl notify -->

	<!-- galary image zoom view  -->
	<script src="{{ URL::to('/admin_files/global_assets/js/plugins/media/fancybox.min.js') }}"></script>
	<script src="{{ URL::to('/admin_files/global_assets/js/demo_pages/gallery_library.js') }}"></script>
	<!-- galary image zoom view  -->

	<!-- increa/decrease value input groups  -->
	
	<!-- <script src="{{ URL::to('admin_files/global_assets/js/plugins/forms/inputs/touchspin.min.js') }}"></script> -->
	<!-- <script src="{{ URL::to('admin_files/global_assets/js/demo_pages/form_input_groups.js') }}"></script> -->

	<!-- increa/decrease value input groups  -->

	<!-- date  range pickers   -->
	<script src="{{ url('/admin_files/global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/demo_pages/picker_date.js') }}"></script>
	<!-- date  range pickers   -->
	<!-- invoice page  -->
	<script src="{{ url('/admin_files/global_assets/js/plugins/editors/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ url('/admin_files/global_assets/js/demo_pages/invoice_template.js') }}"></script>
	<!-- invoice page  -->
	<!-- custom image delete icon css file  -->
	<link rel="stylesheet" href="{{ URL::to('admin_files/custom-loader.css') }}">

</head>

<body>
    @include('adminLayouts.navbar')

    
     <!-- page content  -->
    <div class="page-content">
        <!-- side bar  -->
        @include('adminLayouts.sidebar')
        <!-- side bar end  -->

        <!-- main content here  -->
		@yield('content')
        <!-- main content here  -->

        <!-- footer  -->
       
        <!-- footer end  -->

    </div>
     <!-- page contentend  -->
        

</boby>
<script>
	// my function to dummy videos 
	$('#add-videos-btn').click(function(){
    $('#videos_preview').append("<div class='wrapper-vid'><div class='container-box'><span class='btn btn-xs btn-danger x'>&times;</span><input type='file' name='videos[]' id='dummy-videos' accept='video/*' ></div></div>");
    $('input#add-videos-btn').prop('disabled',true);
    $('input#dummy-videos').change(function(){
      var y = document.getElementById('dummy-videos');
    
      if (event.target.files[0].size > 4000000){
        alert('File size is too large to upload ! Please upload file less than 4 MB' );
        $(this).closest('div').parent().remove();
      }
      $(this).closest('div').append("<video controls style='height:200px; width:278px; z-index:-1;' id='playback' ><source src='"+URL.createObjectURL(event.target.files[0])+"' >This browser doesnt support video tag.</video>");
      $('#add-videos-btn').prop('disabled',false);
      $(this).hide();
      $('#add-videos-btn').val('Add more videos');
    });
    $('div.wrapper-vid div.container-box span.x').click(function(){
      $(this).closest('div').parent().remove();
      $('input#add-videos-btn').prop('disabled',false);
      $('#add-videos-btn').val('Add videos');
    });

    // $(this).prop('disabled', true);
  });

	$("input#image,input#cover_image,input#product_image,input#doc_thumbnail").change(function(){
	  if (event.target.files[0].size > 20000000){
	    alert('File size is too large to upload ! Please upload file less than 20 MB' );
	    $(this).val(null);
	  }

	});
	$("input#doc_file").change(function(){
	  if (event.target.files[0].size > 20000000){
	    alert('File size is too large to upload ! Please upload file less than 20 MB' );
	    $(this).val(null);
	  }

	});
	

</script>
</html>