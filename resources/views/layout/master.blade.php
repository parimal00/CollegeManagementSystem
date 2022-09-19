<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plain Page | LMS </title>


    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet"type="text/css">
    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet"type="text/css">
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet"type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title"><i class="fa fa-book"></i> <span>LMS</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>

                            <h2>{{session('accountant')}}</h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="{{ url('/lol') }}"><i class="fa fa-home"></i> Insert scholarship info
                                        <span class="fa fa-chevron-down"></span></a>

                                </li>
                                <li><a href="{{ url('bus_manage') }}"><i class="fa fa-edit"></i>Insert bus fee <span
                                            class="fa fa-chevron-down"></span></a>

                                </li>
                                <li><a href="{{url('delete_bus_fee')}}"><i class="fa fa-desktop"></i> Delete bus fee <span
                                    class="fa fa-chevron-down"></span></a>

                            </li>
                                <li><a href="{{ url('get_amount') }}"><i class="fa fa-table"></i> Get Amount <span
                                            class="fa fa-chevron-down"></span></a>

                                </li>
                                {{-- <li><a href="{{url('update')}}"><i class="fa fa-bar-chart-o"></i>Update all the information<span
                                    class="fa fa-chevron-down"></span></a>

                            </li> --}}
                                {{-- <li><a href="{{url('view_due')}}"><i class="fa fa-bar-chart-o"></i>Due balance students<span
                                class="fa fa-chevron-down"></span></a>

                        </li> --}}
                                <li><a href="{{ url('payment_history') }}"><i class="fa fa-bar-chart-o"></i>Payment
                                        History<span class="fa fa-chevron-down"></span></a>

                                </li>
                                <li><a href="{{ url('update') }}"><i class="fa fa-bar-chart-o"></i>Upgrade Students<span class="fa fa-chevron-down"></span></a>

                                </li>

                            </ul>
                        </div>


                    </div>

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="images/img.jpg" alt="">{{ session('accountant') }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log
                                            Out</a></li>
                                </ul>
                            </li>

                            {{-- <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>

                            </li> --}}
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content area main -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Accountant Management</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">

                                    {{-- <form action="{{ route('search') }}" method="post">
                                        @csrf
                                        <input type="text" class="form-control" name="roll_no"
                                            placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default">Go!</button>
                                        </span>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="row" style="min-height:500px">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Accountant management</h2>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    @if (Session::has('success'))
                                        <script>
                                            toastr.success('{{ session('success') }}')
                                        </script>
                                    @endif
                                    @if (Session::has('failure'))
                                        <script>
                                            toastr.error('{{ session('failure') }}')
                                        </script>
                                    @endif
                                    @yield('body')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->


            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Library Management System
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="js/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="js/custom.min.js"></script>
</body>

</html>
