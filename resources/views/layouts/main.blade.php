@include('partials.head')
@stack('after-styles')
@include('partials.topmenu')
@include('partials.js')
@include('partials.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @yield('content')

    <div id="loader" class="lds-dual-ring hidden overlay"></div>
</div>
<!-- /.content-wrapper -->

@include('partials.footer')
@stack('after-scripts')
</body>

</html>