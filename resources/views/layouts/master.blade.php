<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gull - Laravel 6 + Bootstrap 4 admin template</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        @if (Session::get('layout')=="vertical")
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/styles/vendor/metisMenu.min.css') }}">

        @endif
        {{-- page specific css --}}
        @yield('page-css')
    </head>


    <body class="text-left">
        @php
        $layout = session('layout');
        @endphp

        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">

            <div class="loader spinner-bubble spinner-bubble-primary">


            </div>
        </div>
        <!-- Pre Loader end  -->







        <!-- ============ Compact Layout start ============= -->
        @if ($layout=="compact")

        <div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
            @include('layouts.compact-sidebar')

            <!-- ============ end of left sidebar ============= -->


            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap d-flex flex-column">
                @include('layouts.header-menu')

                <!-- ============ end of header menu ============= -->
                <div class="main-content">
                    @yield('content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->

        {{-- @include('layouts.compact-customizer') --}}



        <!-- ============ Compact Layout End ============= -->











        <!-- ============ Horizontal Layout start ============= -->

        @elseif($layout=="horizontal")

        <div class="app-admin-wrap layout-horizontal-bar clearfix">
            @include('layouts.header-menu')

            <!-- ============ end of header menu ============= -->



            @include('layouts.horizontal-bar')

            <!-- ============ end of left sidebar ============= -->

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap  d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->

        {{-- @include('layouts.horizontal-customizer') --}}


        <!-- ============ Horizontal Layout End ============= -->




        <!-- ============ Vetical SIdebar Layout start ============= -->
        @elseif($layout=="vertical")
        <div class="app-admin-wrap layout-sidebar-vertical sidebar-full">
            @include('layouts.vertical.sidebar')
            <div class="main-content-wrap  mobile-menu-content bg-off-white m-0">
                @include('layouts.vertical.header')

                <div class="main-content pt-4">
                    @yield('main-content')
                </div>

                @include('layouts.footer')

            </div>

            <div class="sidebar-overlay open"></div>
        </div>




        <!-- ============ Vetical SIdebar Layout End ============= -->












        <!-- ============ Large SIdebar Layout start ============= -->
        @elseif($layout=="normal")

        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @include('layouts.header-menu')

            <!-- ============ end of header menu ============= -->



            @include('layouts.sidebar')

            <!-- ============ end of left sidebar ============= -->

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap sidenav-open d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->




        <!-- ============ Large Sidebar Layout End ============= -->





        @else
        <!-- ============Deafult  Large SIdebar Layout start ============= -->

        {{-- normal layout --}}
        <div class="app-admin-wrap layout-sidebar-large clearfix">
            @include('layouts.header-menu')
            {{-- end of header menu --}}



            @include('layouts.sidebar')
            {{-- end of left sidebar --}}

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap sidenav-open d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->

        {{-- @include('layouts.large-sidebar-customizer') --}}


        <!-- ============ Large Sidebar Layout End ============= -->



        @endif

        @include('layouts.customizer')



        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
        {{-- page specific javascript --}}
        @yield('page-js')

        {{-- theme javascript --}}
        {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
        <script src="{{asset('assets/js/script.js')}}"></script>


        @if ($layout=='compact')
        <script src="{{asset('assets/js/sidebar.compact.script.js')}}"></script>


        @elseif($layout=='normal')
        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>


        @elseif($layout=='horizontal')
        <script src="{{asset('assets/js/sidebar-horizontal.script.js')}}"></script>
        @elseif($layout=='vertical')



        <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
        <script src="{{asset('assets/js/es5/script_2.js')}}"></script>
        <script src="{{asset('assets/js/vendor/feather.min.js')}}"></script>
        <script src="{{asset('assets/js/vendor/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/js/layout-sidebar-vertical.js')}}"></script>


        @else
        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>

        @endif



        <script src="{{asset('assets/js/customizer.script.js')}}"></script>

        {{-- laravel js --}}
        {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

        @yield('bottom-js')
    </body>

</html>