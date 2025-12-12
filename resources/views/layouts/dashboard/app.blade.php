<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @include('layouts.dashboard.head')
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<!-- fixed-top-->
@include('layouts.dashboard.header')

<!-- ////////////////////////////////////////////////////////////////////////////-->

@include('layouts.dashboard.sidebar')

@yield('content')

<!-- ////////////////////////////////////////////////////////////////////////////-->

@include('layouts.dashboard.footer')

@include('layouts.dashboard.scripts')
</body>
</html>
