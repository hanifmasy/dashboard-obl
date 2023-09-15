@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/logo_telkom.png">
    <title>
        Dashboard OBL by SDA
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets')}}/css/fonts_googleapis.css" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="{{ asset('assets') }}/js/fontawesome.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="{{ asset('assets') }}/css/materialicons.css" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/boot_table.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/DataTables/datatables.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/DataTables/Buttons-2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
</head>
<body class="{{ $bodyClass }}">
<style>
        .hidden-leaf,
        /* .filter-jenis-kontrak, */
        .filter-jenis-kontrak-kb,
        .filter-jenis-kontrak-lanjut,
        #f1_nama_mitra_lain,
        .filterKontrak,
        .filterAwal,
        #lanjutP2,
        .formP2,
        .formP3,
        .formP4,
        .formP5,
        .formP6,
        .formP7,
        .formSP,
        .formP8,
        .formWO,
        #backKontrak2,
        #tanggalFO,
        .formKL,
        .formP5-baru,
        .formP6-baru,
        .diatas-100,
        .dibawah-100,
        .status_rapat_pengadaan,
        #modal-obl-sukses,
        #modal-obl-gagal,
        #modal-input-obl,
        #btn-lanjut,
        .btn-loading
         {
                    display: none;
        }
        .text-black{
          color: #1e2124;
        }
        .bg-gradient-mitra{
          background:#1da2d8;
        }
        .bg-gradient-closesm{
          background: #d9534f;
        }
        .outline-input-merah {
          outline: 6px solid red;
        }
        .outline-input-merah-2 {
          outline: 2px solid red;
        }
        #table-input-obl,#table-input,#table-master-input {
          border: 0px #ffffff;
        }

        .dataTables_filter {
           float: left !important;
        }
        div.dataTables_filter input,div.dataTables_filter input:focus {
          outline: 1px ridge #bbbbbb;
          border-radius: 0.5em;
        }

        .modal-dialog {
            vertical-align: middle;
            text-align: center;
          }

        .lampiran-dialog {
            max-width: 90%;
            vertical-align: middle;
            text-align: center;
            margin-left: 12%;
            padding-left: 5%;
          }
          .lampiran{
            width: 90%;
          }

        .footer {
          width: 100%;
          background-image: none;
          background-repeat: repeat;
          background-attachment: scroll;
          background-position: 0% 0%;
          position: fixed;
          bottom: 0pt;
          z-index: -2;
        }
        /* .navbar-main {
          display: none;
          height: 300px;
          width: 100%;
          position: fixed;
          top: 0;
          z-index: -1;
        } */
</style>

{{ $slot }}
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/latest_boot.min.js"></script>
<script src="{{ asset('assets') }}/js/alertboot.min.js"></script>
<script src="{{ asset('assets') }}/js/boot_table.min.js"></script>
<script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
<script src="{{ asset('assets') }}/DataTables/datatables.min.js"></script>
<script src="{{ asset('assets') }}/DataTables/JSZip-3.10.1/jszip.min.js"></script>
<script src="{{ asset('assets') }}/DataTables/Buttons-2.4.1/js/buttons.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/DataTables/Buttons-2.4.1/js/buttons.html5.min.js"></script>
<script src="{{ asset('assets') }}/js/crypto-js.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
@stack('js')
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    $(function () {
      $('[data-toggle="popover"]').popover();

    })

</script>
<!-- Github buttons -->
<script async defer src="{{ asset('assets') }}/js/github_buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
</body>
</html>
