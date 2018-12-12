<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::to('public/frontend/images/favicon.png')}}">
    <title>Inventory  Management</title>

    <link href="{{asset('public/frontend/css/lib/chartist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lib/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/lib/owl.theme.default.min.css')}}" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('public/frontend/css/lib/dropzone/dropzone.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lib/bootstrap/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('public/frontend/css/helper.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lib/toastr/toastr.min.css')}}" rel="stylesheet">
    <!--calender-->
    <link href="{{asset('public/frontend/css/lib/calendar2/semantic.ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lib/calendar2/pignose.calendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="{{asset('public/frontend/css/custom.css')}}" rel="stylesheet">
</head>
<body>
@guest
    @else
	  @include ('include.inventory_headerfooter');
	  @endguest
	  <main class="py-4">
		@yield('inventory_content')
	  </main>

	  <script src="{{asset('public/frontend/js/lib/jquery/jquery.min.js')}}"></script>
	  <!-- Bootstrap tether Core JavaScript -->
	  <script src="{{asset('public/frontend/js/lib/bootstrap/js/popper.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/bootstrap/js/bootstrap.min.js')}}"></script>
	  <!-- slimscrollbar scrollbar JavaScript -->
	  <script src="{{asset('public/frontend/js/jquery.slimscroll.js')}}"></script>
	  <!--Menu sidebar -->
	  <script src="{{asset('public/frontend/js/sidebarmenu.js')}}"></script>
	  <!--stickey kit -->
	  <script src="{{asset('public/frontend/js/lib/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
	  <!--Custom JavaScript -->
	  <script src="{{asset('public/frontend/js/custom.min.js')}}"></script>
	  <!--data table-->
	  <script src="{{asset('public/frontend/js/lib/datatables/datatables.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/datatables/datatables-init.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/calendar-2/moment.latest.min.js')}}"></script>
	  <!-- scripit init-->
	  <script src="{{asset('public/frontend/js/lib/calendar-2/semantic.ui.min.js')}}"></script>
	  <!-- scripit init-->
	  <script src="{{asset('public/frontend/js/lib/calendar-2/prism.min.js')}}"></script>
	  <!-- scripit init-->
	  <script src="{{asset('public/frontend/js/lib/calendar-2/pignose.calendar.min.js')}}"></script>
	  <!-- scripit init-->
	  <script src="{{asset('public/frontend/js/lib/calendar-2/pignose.init.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/toastr/toastr.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/toastr/toastr.init.js')}}"></script>
	  <script src="{{asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/toastr/toastr.min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/toastr/toastr.init.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/morris-chart/raphael-min.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/morris-chart/morris.js')}}"></script>
	  <script src="{{asset('public/frontend/js/lib/morris-chart/morris-init.js')}}"></script>
	  <script src="{{asset('public/frontend/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>


	  @yield('script')
	  <script>
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true
            });
	  </script>

	  <script type="text/javascript">
            $(document).ready(function() {
                $('#check').click(function() {
                    $('.approve').toggle("slide");
                });
            });
	  </script>
	  <script type="text/javascript">
            $(document).ready(function(){

                $("#F").click(function(){
                    $(".force").show();
                    $("#department").show();
                    $(".civil").hide();
                });

                $("#C").click(function(){
                    $(".civil").show();
                    $("#department").hide();
                    $("#regiment").hide();
                    $("#flotilla").hide();
                    $("#squadron").hide();
                    $(".force").hide();
                });
                $("#Army").click(function(){
                    $("#regiment").show();
                    $("#flotilla").hide();
                    $("#squadron").hide();
                });
                $("#Naval").click(function(){
                    $("#flotilla").show();
                    $("#regiment").hide();
                    $("#squadron").hide();
                });
                $("#Air").click(function(){
                    $("#regiment").hide();
                    $("#flotilla").hide();
                    $("#squadron").show();
                });
            });
	  </script>
	  <script type="text/javascript">
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
	  </script>
	  <script>
			  @if(Session::has('messege'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('messege') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('messege') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('messege') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('messege') }}");
                    break;
            }
		@endif
	  </script>
	  <script>
            $(document).on("click", "#delete", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = link;
                        } else {
                            swal("Your imaginary file is safe!");
                        }
                    });
            });
	  </script>
</body>
</html>
