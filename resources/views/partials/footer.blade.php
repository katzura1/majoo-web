<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 0.1
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="{{ url('') }}">SMART v2</a>.</strong> All rights reserved.
</footer>


<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('js/demo.js') }}"></script> --}}
<script>
    var url = "{{ URL::to('/') }}";
    var url_segment1 = "{{ Request::segment(1) }}";
    var url_segment2 = "{{ Request::segment(2) }}";
    var url_segment3 = "{{ Request::segment(3) }}";
</script>
<script src="{{ asset('js/master.js') }}"></script>
