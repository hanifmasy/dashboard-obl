<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="DASHBOARD"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <style media="screen">
        .sz-h4{
          font-size: 1.8em;
          font-weight: bolder;
          color: white;
        }
        .sz-h3{
          font-size: 2em;
          font-weight: bolder;
          color: white;
        }
        /* .sz-h4:hover{
          font-size: 1.8em;
          font-weight: bolder;
          color: black;
        } */
        .anchor-merah:hover{
          color: black !important;
        }

        .anchor-tebal1:hover{
          background: white !important;
          color: #cc3232 !important;
        }
        .anchor-tebal1:hover .anchor-tebal2,
        .anchor-tebal1:hover .sz-h4{
          background: white !important;
          color: #cc3232 !important;
        }

        .anchor-tebal1s:hover{
          background: white !important;
          color: #36802d !important;
        }
        .anchor-tebal1s:hover .anchor-tebal2s,
        .anchor-tebal1s:hover .sz-h4{
          background: white !important;
          color: #36802d !important;
        }

        .anchor-bt-1a:hover{
          background: #E91E63 !important;
          color: white !important;
        }
        .anchor-bt-1a:hover .anchor-bt-1b,
        .anchor-bt-1a:hover .sz-h3{
          background: white !important;
          color: #E91E63 !important;
        }

        .anchor-bt-2a:hover{
          background: #1A73E8 !important;
          color: white !important;
        }
        .anchor-bt-2a:hover .anchor-bt-2b,
        .anchor-bt-2a:hover .sz-h3{
          background: white !important;
          color: #1A73E8 !important;
        }
        .anchor-bt-3a:hover{
          background: #fb8c00 !important;
          color: white !important;
        }
        .anchor-bt-3a:hover .anchor-bt-3b,
        .anchor-bt-3a:hover .sz-h3{
          background: white !important;
          color: #fb8c00 !important;
        }

        .anchor-bt-4a:hover{
          background: #1da2d8 !important;
          color: white !important;
        }
        .anchor-bt-4a:hover .anchor-bt-4b,
        .anchor-bt-4a:hover .sz-h3{
          background: white !important;
          color: #1da2d8 !important;
        }

        .anchor-bt-5a:hover{
          background: #d9534f !important;
          color: white !important;
        }
        .anchor-bt-5a:hover .anchor-bt-5b,
        .anchor-bt-5a:hover .sz-h3{
          background: white !important;
          color: #d9534f !important;
        }

        .anchor-bt-6a:hover{
          background: #4CAF50 !important;
          color: white !important;
        }
        .anchor-bt-6a:hover .anchor-bt-6b,
        .anchor-bt-6a:hover .sz-h3{
          background: white !important;
          color: #4CAF50 !important;
        }

        .input-group-addon {
          border-left-width: 0;
          border-right-width: 0;
        }
        .input-group-addon:first-child {
          border-left-width: 1px;
        }
        .input-group-addon:last-child {
          border-right-width: 1px;
        }
        </style>
        @if( !$user_masuk->role_id )

        <div class="alert alert-danger alert-dismissible text-white" role="alert">
            <span class="text-md">HUBUNGI ADMIN UNTUK ROLE USER ANDA.</span>
        </div>
        @else
        <div class="container-fluid py-4">
          <!-- FILTER -->
          <form action="{{ route('dashboard.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                  <div class=" card z-index-2 ">

                    <div class="input-group p-1">

                      @if( $user_masuk->role_id === 4 || $user_masuk->role_id === 5 )
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_witel" name="fl_witel" disabled>
                        <option value="" selected>Pilih Witel</option>
                      </select>
                      @else
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_witel" name="fl_witel">
                        <option value="" selected>Pilih Witel</option>
                        @if( $witels )
                          @foreach( $witels as $key => $value )
                            <option value="{{ $value->nama_witel }}">{{ $value->nama_witel }}</option>
                          @endforeach
                        @endif
                      </select>
                      @endif

                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_tahun" name="fl_tahun">
                        <option value="" selected>Pilih Tahun</option>
                        @if( $tahuns )
                          @foreach( $tahuns as $key => $value )
                            <option value="{{ $value->tahun }}">{{ $value->tahun }}</option>
                          @endforeach
                        @endif
                      </select>

                      @if( $user_masuk->role_id === 6 )
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_mitra" name="fl_mitra" disabled>
                        <option value="" selected>Pilih Mitra</option>
                      </select>
                      @else
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_mitra" name="fl_mitra">
                        <option value="" selected>Pilih Mitra</option>
                        @if( $mitras )
                          @foreach( $mitras as $key => $value )
                            <option value="{{ $value->id }}">{{ $value->nama_mitra }}</option>
                          @endforeach
                        @endif
                      </select>
                      @endif

                    </div>
                    <div class="input-group p-1">
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_plggn" name="fl_plggn">
                        <option value="" selected>Pilih Pelanggan</option>
                        @if( $plggns )
                          @foreach( $plggns as $key => $value )
                            <option value="{{ $value->f1_nama_plggn }}">{{ $value->f1_nama_plggn }}</option>
                          @endforeach
                        @endif
                      </select>
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_segmen" name="fl_segmen">
                        <option value="" selected>Pilih Segmen</option>
                        @if( $segmens )
                          @foreach( $segmens as $key => $value )
                            <option value="{{ $value->f1_segmen }}">{{ $value->f1_segmen }}</option>
                          @endforeach
                        @endif
                      </select>
                      <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_status" name="fl_status">
                        <option value="" selected>Pilih Status</option>
                        @if( $statuses )
                          @foreach( $statuses as $key => $value )
                            <option value="{{ $value->f1_jenis_kontrak }}">{{ $value->jenis_kontrak }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>

            </div>
            <div class="row pt-2">
              <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                <div class="btn-group" role="group">
                  <button class="btn btn-md bg-gradient-info" type="button" name="button" id="cari">CARI</button>
                  <button class="btn btn-md bg-gradient-danger" type="button" name="button" id="reset">RESET</button>
                  <button class="btn btn-md bg-gradient-success" type="submit" name="submit" id="excel">EXCEL</button>
                </div>
              </div>
            </div>
          </form>
            <!-- END FILTER -->
            <br>
            <!-- CARDS TOP -->
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a class="" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('top_1')]) }}" >
                    <div class="anchor-tebal1 card bg-gradient-danger text-white">
                        <div class="anchor-tebal2 card-header bg-gradient-danger p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm font-weight-bolder mb-0 text-capitalize">CANCEL</p>
                                <p class=" sz-h4 mb-0" id="top_1"> </p>
                            </div>
                        </div>
                        <div class="p-3">
                            <p class="mb-0"> TOTAL DATA CANCEL</p>
                        </div>
                    </div></a>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                  <a class="anchor-tebal" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('top_2')]) }}">
                    <div class=" anchor-tebal1s card bg-gradient-success text-white ">
                        <div class=" anchor-tebal2s card-header bg-gradient-success p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize font-weight-bolder">SEMUA DATA</p>
                                <p class=" sz-h4 mb-0 " id="top_2"> </p>
                            </div>
                        </div>
                        <div class="card-footer p-3">
                            <p class="mb-0"> TOTAL SEMUA DATA</p>
                        </div>
                    </div></a>
                </div>

            </div>
            <!-- END CARDS TOP -->

            <!-- MAIN MIDDLE CARDS -->
            <div class="row mt-4 ">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_1')]) }}">
                    <div class=" anchor-bt-1a card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                              <div class=" anchor-bt-1b  bg-gradient-primary  border-radius-lg py-3 pe-1">
                                  <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_1">

                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">WITEL</p>
                            <p class="text-sm ">TOTAL DATA WITEL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm" id="timed_bottom_1"> </p>
                            </div>
                        </div>
                    </div></a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_2')]) }}">
                    <div class="anchor-bt-2a card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                              <div class=" anchor-bt-2b bg-gradient-info border-radius-lg py-3 pe-1">
                                  <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_2">

                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">OBL</p>
                            <p class="text-sm ">TOTAL DATA OBL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm" id="timed_bottom_2"> </p>
                            </div>
                        </div>
                    </div></a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_3')]) }}">
                    <div class="anchor-bt-3a card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                              <div class=" anchor-bt-3b bg-gradient-warning  border-radius-lg py-3 pe-1">
                                  <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_3">

                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">LEGAL</p>
                            <p class="text-sm ">TOTAL DATA LEGAL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm" id="timed_bottom_3"> </p>
                            </div>
                        </div>
                    </div></a>
                </div>
            </div>
            <!-- END MIDDLE CARDS -->

            <div class="row mt-4 ">
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_4')]) }}">
                  <div class=" anchor-bt-4a card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                            <div class=" anchor-bt-4b bg-gradient-mitra border-radius-lg py-3 pe-1">
                                <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_4">

                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                          <p class="mb-0 font-weight-bolder">MITRA OBL</p>
                          <p class="text-sm ">TOTAL DATA MITRA OBL</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm" id="timed_bottom_4"> </p>
                          </div>
                      </div>
                  </div></a>
              </div>
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_5')]) }}">
                  <div class=" anchor-bt-5a card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                            <div class=" anchor-bt-5b bg-gradient-closesm border-radius-lg py-3 pe-1">
                                <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_5">

                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                        <p class="mb-0 font-weight-bolder">CLOSE SM</p>
                          <p class="text-sm ">TOTAL DATA CLOSE SM</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm" id="timed_bottom_5"> </p>
                          </div>
                      </div>
                  </div></a>
              </div>
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_6')]) }}">
                  <div class="anchor-bt-6a card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                            <div class=" anchor-bt-6b bg-gradient-success  border-radius-lg py-3 pe-1">
                                <p class=" sz-h3 text-white text-center font-weight-bolder" id="bottom_6">

                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                          <p class="mb-0 font-weight-bolder">DONE</p>
                          <p class="text-sm ">TOTAL DATA DONE</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm" id="timed_bottom_6"> </p>
                          </div>
                      </div>
                  </div></a>
              </div>
            </div>

            </div>
        @endif



    </main>
@push('js')
<script type="text/javascript">

function countDashboard(fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status){
  if( fl_witel === undefined ){ fl_witel = ''; }
  if( fl_tahun === undefined ){ fl_tahun = ''; }
  if( fl_mitra === undefined ){ fl_mitra = ''; }
  if( fl_plggn === undefined ){ fl_plggn = ''; }
  if( fl_segmen === undefined ){ fl_segmen = ''; }
  if( fl_status === undefined ){ fl_status = ''; }
  $.ajax({
     type:'GET',
     url:"{{ route('dashboard') }}",
     data:{
       fl_witel:fl_witel,
       fl_tahun:fl_tahun,
       fl_mitra:fl_mitra,
       fl_plggn:fl_plggn,
       fl_segmen:fl_segmen,
       fl_status:fl_status
     },
     success:function(data){
        // console.log(data);
        let top_1 = data.top_1;
        let top_2 = data.top_2;
        let bottom_1 = data.bottom_1;
        let timed_bottom_1 = data.timed_bottom_1;
        let bottom_2 = data.bottom_2;
        let timed_bottom_2 = data.timed_bottom_2;
        let bottom_3 = data.bottom_3;
        let timed_bottom_3 = data.timed_bottom_3;
        let bottom_4 = data.bottom_4;
        let timed_bottom_4 = data.timed_bottom_4;
        let bottom_5 = data.bottom_5;
        let timed_bottom_5 = data.timed_bottom_5;
        let bottom_6 = data.bottom_6;
        let timed_bottom_6 = data.timed_bottom_6;

        if( top_1 === '' || top_1 === null ){ top_1 = 0; }
        if( top_2 === '' || top_2 === null ){ top_2 = 0; }
        if( bottom_1 === '' || bottom_1 === null ){ bottom_1 = 0; }
        if( timed_bottom_1 === '' || timed_bottom_1 === null ){ timed_bottom_1 = 'Belum Ada Update'; }else{ timed_bottom_1 = data.timed_bottom_1.tgl; }
        if( bottom_2 === '' || bottom_2 === null ){ bottom_2 = 0; }
        if( timed_bottom_2 === '' || timed_bottom_2 === null ){ timed_bottom_2 = 'Belum Ada Update'; }else{ timed_bottom_2 = data.timed_bottom_2.tgl; }
        if( bottom_3 === '' || bottom_3 === null ){ bottom_3 = 0; }
        if( timed_bottom_3 === '' || timed_bottom_3 === null ){ timed_bottom_3 = 'Belum Ada Update'; }else{ timed_bottom_3 = data.timed_bottom_3.tgl; }
        if( bottom_4 === '' || bottom_4 === null ){ bottom_4 = 0; }
        if( timed_bottom_4 === '' || timed_bottom_4 === null ){ timed_bottom_4 = 'Belum Ada Update'; }else{ timed_bottom_4 = data.timed_bottom_4.tgl; }
        if( bottom_5 === '' || bottom_5 === null ){ bottom_5 = 0; }
        if( timed_bottom_5 === '' || timed_bottom_5 === null ){ timed_bottom_5 = 'Belum Ada Update'; }else{ timed_bottom_5 = data.timed_bottom_5.tgl; }
        if( bottom_6 === '' || bottom_6 === null ){ bottom_6 = 0; }
        if( timed_bottom_6 === '' || timed_bottom_6 === null ){ timed_bottom_6 = 'Belum Ada Update'; }else{ timed_bottom_6 = data.timed_bottom_6.tgl; }

        $('#top_1').empty();
        $('#top_2').empty();
        $('#bottom_1').empty();
        $('#timed_bottom_1').empty();
        $('#bottom_2').empty();
        $('#timed_bottom_2').empty();
        $('#bottom_3').empty();
        $('#timed_bottom_3').empty();
        $('#bottom_4').empty();
        $('#timed_bottom_4').empty();
        $('#bottom_5').empty();
        $('#timed_bottom_5').empty();
        $('#bottom_6').empty();
        $('#timed_bottom_6').empty();

        $('#top_1').append(top_1);
        $('#top_2').append(top_2);
        $('#bottom_1').append(bottom_1);
        $('#timed_bottom_1').append(timed_bottom_1);
        $('#bottom_2').append(bottom_2);
        $('#timed_bottom_2').append(timed_bottom_2);
        $('#bottom_3').append(bottom_3);
        $('#timed_bottom_3').append(timed_bottom_3);
        $('#bottom_4').append(bottom_4);
        $('#timed_bottom_4').append(timed_bottom_4);
        $('#bottom_5').append(bottom_5);
        $('#timed_bottom_5').append(timed_bottom_5);
        $('#bottom_6').append(bottom_6);
        $('#timed_bottom_6').append(timed_bottom_6);
     }
  });
}

$(document).ready(function () {
  var fl_witel = $('#fl_witel').val();
  var fl_tahun = $('#fl_tahun').val();
  var fl_mitra = $('#fl_mitra').val();
  var fl_plggn = $('#fl_plggn').val();
  var fl_segmen = $('#fl_segmen').val();
  var fl_status = $('#fl_status').val();
  countDashboard();

  $("#cari").click(function(){
    fl_witel = $('#fl_witel').val();
    fl_tahun = $('#fl_tahun').val();
    fl_mitra = $('#fl_mitra').val();
    fl_plggn = $('#fl_plggn').val();
    fl_segmen = $('#fl_segmen').val();
    fl_status = $('#fl_status').val();
    countDashboard(fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);
  });
  $("#reset").click(function(){
    fl_witel = $('#fl_witel').val('');
    fl_tahun = $('#fl_tahun').val('');
    fl_mitra = $('#fl_mitra').val('');
    fl_plggn = $('#fl_plggn').val('');
    fl_segmen = $('#fl_segmen').val('');
    fl_status = $('#fl_status').val('');
    countDashboard();
  });
  // $("#excel").click(function(){
  //   alert("The paragraph was clicked.");
  // });

});

</script>
@endpush
</x-layout>
