<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-select/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Inputmask-->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.js') }}"></script>

<script src="{{ asset('js/date.js') }}"></script>

<script>
    var token = "{{ csrf_token() }}";
    var Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    });

    function formatRupiah(angka, prefix) {
        angka = angka + '';
        //console.log(angka);
        var number_string = angka.replace(/[^.\d]/g, '').toString(),
            split = number_string.split('.'),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        koma = parseFloat('0.' + split[1]);
        //console.log(koma);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }

        rupiah = split[1] != undefined ? rupiah + '.' + split[1].substring(0, 2) : rupiah;
        if (angka.includes('-')) {
            rupiah = '-' + rupiah;
        }
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).on('keyup', '.maskMoney, .mask-money', function() {
        var angka = $(this).val();
        $(this).val(formatRupiah(angka));
    });

    function tablenumber(id) {
        var table = document.getElementById(id),
            rows = table.getElementsByTagName('tr'),
            text = 'textContent' in document ? 'textContent' : 'innerText';

        for (var i = 1, len = rows.length; i < len; i++) {
            rows[i].children[0][text] = i;
        }
    };

    window.addEventListener('online',  updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    // Update the online status icon
    function updateOnlineStatus(event) {
        var condition = navigator.onLine;
        if(condition){
            // Toast.fire  ({
            //     icon: 'success',
            //     title: 'Your connection is back'
            // });
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Connected to internet',
                subtitle: 'Alert',
                body: 'Your connection is back.'
            })
        }else{
            // Toast.fire  ({
            //     icon: 'error',
            //     title: 'Your have lost your internet connection'
            // });
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Connection is lost',
                subtitle: 'Alert',
                body: 'Your have lost your internet connection.'
            })
        }
    }

    // convert string to title case
    function toTitleCase(words) {
        var separateWord = words.toLowerCase().split(' ');
        for (var i = 0; i < separateWord.length; i++) {
            separateWord[i] = separateWord[i].charAt(0).toUpperCase() +
            separateWord[i].substring(1);
        }
        return separateWord.join(' ');
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        const newColorScheme = event.matches ? "dark" : "light";
        if(newColorScheme == 'dark'){
            console.log('dark');
            $('body').addClass('dark-mode');
            $('aside.main-sidebar').removeClass('sidebar-light-danger');
            $('aside.main-sidebar').addClass('sidebar-dark-danger');
            $('nav.main-header').removeClass('navbar-light');
            $('nav.main-header').addClass('navbar-dark');
        }else{
            console.log('light');
            $('body').removeClass('dark-mode');
            $('aside.main-sidebar').removeClass('sidebar-dark-danger');
            $('aside.main-sidebar').addClass('sidebar-light-danger');
            $('nav.main-header').removeClass('navbar-dark');
            $('nav.main-header').addClass('navbar-light');
        }
    });

	$(document).ready(function () {
        // switch dark mode / light mode
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            console.log('dark auto');
            // dark mode
            $('body').addClass('dark-mode');
            $('aside.main-sidebar').removeClass('sidebar-light-danger');
            $('aside.main-sidebar').addClass('sidebar-dark-danger');
            $('nav.main-header').removeClass('navbar-light');
            $('nav.main-header').addClass('navbar-dark');
        }
    })
</script>
