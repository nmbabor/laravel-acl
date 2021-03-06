<?php $info = MyHelper::info(); ?>
        <!DOCTYPE html>
<html lang="en">

<head>
    @if(Session::has('title'))
        <?php
            $title =Session::get('title').' | '.$info->company_name;
            Session::forget('title');
        ?>
    @else
        <?php $title = $info->company_name;  ?>
    @endif
    <title>{{$title}}</title>
    <link rel="shortcut icon" type="image/png" href="{{asset($info->favicon)}}"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Enterprise resource planning (ERP)" />
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="LEAM TECH" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required Fremwork -->
    {{--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>--}}
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/icon/feather/css/feather.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/icon/icofont/css/icofont.css')}}">
    <!-- Style.css')}}' -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/widget.css')}}">
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/component.css')}}">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/pages/data-table/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/pages/advance-elements/css/bootstrap-datetimepicker.css')}}">
        <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/bootstrap-daterangepicker/css/daterangepicker.css')}}" />
        <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/datedropper/css/datedropper.min.css')}}" />

    <link rel="stylesheet" href="{{asset('public/css/chosen.css')}}" />
    <link href="{{asset('public/assets/css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/pages/j-pro/css/j-pro-modern.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/pages.css')}}">
        @yield('style')
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/custom.css')}}">
    {{-- <style>
      body {
          background: url('images/landing-bg.jpg')no-repeat;
          background-size: cover;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          -ms-background-size: cover;
          background-position: center;
          background-attachment: fixed;
          font-family: 'Open Sans', sans-serif;
          font-size: 100%;
        }
    </style> --}}
</head>

<body>

    <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-block">
      <div class="preloader6">
        <hr>
     </div>
   </div>
</div>
    <!-- [ Pre-loader ] end -->
<div id="pcoded" class="pcoded">
  <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

      @include('layouts.header_sidebar')
      <!-- [ navigation menu ] end -->
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                            <!-- Toggler/collapsibe Button -->
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <!-- Navbar links -->
                            <div class="collapse navbar-collapse" id="collapsibleNavbar">

                                @include('layouts.subMenu')
                                @if(isset($companyModules))
                                    <ul class="navbar-nav">
                                    @foreach($companyModules as $module)
                                        <li class="nav-item"><a  class="nav-link" href='{{URL::to("module-dashboard/$module->company_id/$module->module_id")}}'> <i class="{{($module->icon_class)?$module->icon_class:'fa fa-folder-o'}}"></i> {{$module->name}} </a></li>
                                    @endforeach

                                    </ul>
                                @endif
                                    @if(isset($moduleDropDown))
                                    <ul class="navbar-nav">
                                        <li class="nav-item"> <a href="#" class="nav-link"> <h5>{{$module->name}} </h5></a> </li>
                                        <li class="nav-item dropdown pull-right" >
                                            <a href="#" class="nav-link dropdown-toggle"id="navbardrop" data-toggle="dropdown">
                                                <span>Modules</span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                @foreach($moduleDropDown as $module)
                                                    <a class="dropdown-item" href='{{URL::to("module-dashboard/$module->company_id/$module->module_id")}}'> <i class="{{($module->icon_class)?$module->icon_class:'fa fa-folder-o'}}"></i> {{$module->name}} </a>
                                                @endforeach
                                            </div>
                                        </li>
                                    </ul>
                                @endif

                            </div>
                        </nav>
                    </div>


                </div>
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            @yield('breadcrumb')

                        </div>

                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">

                        <!-- Page body start -->
                        <div class="page-body">

                        @yield('content')
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>


    <!-- Required Jquery -->
    <script type="text/javascript" src="{{asset('public/bower_components/jquery/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/popper.js/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('public/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>


    <!-- amchart js -->
    <script src="{{asset('public/assets/pages/widget/amchart/amcharts.js')}}"></script>
    <script src="{{asset('public/assets/pages/widget/amchart/serial.js')}}"></script>
   <!--vertical layout-->
   <script  src="{{asset('public/assets/js/vertical/vertical-layout.min.js')}}"></script>
    <!-- Custom js -->
    <script src="{{asset('public/assets/js/pcoded.min.js')}}"></script>


    <!--this is for login page upper text-->
     <script src="{{asset('public/assets/pages/waves/js/waves.min.js')}}"></script>
    <script src="{{asset('public/assets/js/sweetalert2.all.min.js')}}"></script>
    <!-- data-table js -->
    <script src="{{asset('public/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/assets/pages/data-table/js/data-table-custom.js')}}"></script>
    <script src="{{asset('public/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    @if(Request::path()=='/')
    <script type="text/javascript" src="{{asset('public/assets/pages/dashboard/custom-dashboard.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/pages/j-pro/js/custom/booking.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/pages/dashboard/analytic-dashboard.min.js')}}"></script>
    @endif
    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript" src="{{asset('public/assets/pages/advance-elements/moment-with-locales.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('public/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/pages/advance-elements/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="{{asset('public/bower_components/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="{{asset('public/bower_components/datedropper/js/datedropper.min.js')}}"></script>
    <!-- Custom js -->
    {{--<script type="text/javascript" src="{{asset('public/assets/pages/advance-elements/custom-picker.js')}}"></script>--}}




    <script src="{{asset('public/js/tinymce/tinymce.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/js/script.min.js')}}"></script>
    <script src="{{asset('public/assets/js/custom.js')}}"></script>
    <!-- data-table end -->
    <script>
        $(".datepicker").dateDropper( {
            dropWidth: 200,
            format: "d-m-Y",
            dropPrimaryColor: "#1abc9c",
            dropBorder: "1px solid #1abc9c"
        });
        $(".timepicker").datetimepicker( {
            format:'LT'
        });
        function confirmDelete(){
            return confirm("Do You Sure Want To Delete This Data ?");
        }

        function loadSubMenu(id,url){
            if(url=='#'){
                url='';
            }
            $('#collapsibleNavbar').load("{{URL::to('sub-menu-load')}}/"+id);
            //setTimeout(function(){ window.location = '{{URL::to('')}}/'+url; }, 300);

        }
    </script>
    @if(Session::has('success'))
        <script type="text/javascript">
            swal({
                type: 'success',
                title: '{{Session::get("success")}}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if(Session::has('error'))
        <script type="text/javascript">
            swal({
                type: 'error',
                title: '{{Session::get("error")}}',
                showConfirmButton: true
            })
        </script>
    @endif
    <script type="text/javascript">
        function deleteConfirm(id){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                $("#"+id).submit();
            }
        })
        }

    </script>
    @yield('script')
    <script type="text/javascript">
        $(document).ready( function($) {
            $('#success-text').delay(1000).fadeOut();
        });
    </script>


  </body>

</html>
