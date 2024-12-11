
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forever Medspa | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="{{url('/')}}/dist/css/deepak.css">
  <link rel="stylesheet" href="{{url('/')}}/dist/toastr/toastr.css">
  <link rel="stylesheet" href="{{url('/')}}/dist/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="{{url('/')}}/dist/summernote/summernote-bs4.min.css">

  <!-- for Font giftcardsale page -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css" integrity="sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=" crossorigin="anonymous">
  <!-- For Eiditor -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
    <x-topbar/>
  <!-- /.navbar -->

    <!-- Main Sidebar Container -->
       <x-sidebar/>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="overflow-x: auto; overflow-y: auto; max-height: 100vh; max-width: 100%;">
 
         @yield('body')
    </div>
      <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>

    <x-footer/>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <x-footerscript/>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
   
   
    @stack('script')
    <!--end::Script-->
</body><!--end::Body-->

</html>