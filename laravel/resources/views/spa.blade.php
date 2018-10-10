<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel - CoreUI Example</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">



    <script>
        window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
    </script>

    <!-- BODY options, add following classes to body to change options
    // Header options
    1. '.header-fixed'					- Fixed Header
    // Sidebar options
    1. '.sidebar-fixed'					- Fixed Sidebar
    2. '.sidebar-hidden'				- Hidden Sidebar
    3. '.sidebar-off-canvas'		- Off Canvas Sidebar
    4. '.sidebar-compact'				- Compact Sidebar Navigation (Only icons)
    // Aside options
    1. '.aside-menu-fixed'			- Fixed Aside Menu
    2. '.aside-menu-hidden'			- Hidden Aside Menu
    3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu
    // Footer options
    1. '.footer-fixed'						- Fixed footer
    -->
</head>
<body class="app sidebar-lg-show header-fixed sidebar-fixed aside-menu-fixed aside-menu-off-canvas">

@include('panel.navbar')

<div class="app-body">
@include('panel.sidebar')
<!-- Main content -->
    <main class="main">

        <!-- Breadcrumb -->
    @include('panel.breadcrumb')

        <div id="app">
            <app></app>
        </div>

    <!-- /.container-fluid -->
    </main>

    @include('panel.asidemenu')

</div>

@include('panel.footer')

@include('panel.scripts')
<?php /***@yield('myscript')***/ ?>


<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
