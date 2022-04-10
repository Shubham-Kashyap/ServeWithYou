@extends('subadmin.index')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Version 2.0</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ URL('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
</section>

<!-- Main content -->
<section class="content">
      
      <!-- Info boxes -->
      @include('subadminLayouts.widgets.infocardsv3')
      <!-- /.info boxes -->

</section>
<!-- /.Main content -->
@endsection