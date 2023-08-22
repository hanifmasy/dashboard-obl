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
        </style>
        <!-- CARDS TOP -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <a class="" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('top_1')]) }}" >
                    <div class="anchor-tebal1 card bg-gradient-danger text-white">
                        <div class="anchor-tebal2 card-header bg-gradient-danger p-3 pt-2">
                            <div class="text-end pt-1">
                                <p class="text-sm font-weight-bolder mb-0 text-capitalize">CANCEL</p>
                                <p class=" sz-h4 mb-0">{{ isset($arr_counted_dashboard) && $arr_counted_dashboard['top_1'] ? $arr_counted_dashboard['top_1'] : 0 }}</p>
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
                                <p class=" sz-h4 mb-0 ">{{ isset($arr_counted_dashboard) && $arr_counted_dashboard['top_2'] ? $arr_counted_dashboard['top_2'] : 0 }}</p>
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
                                  <p class=" sz-h3 text-white text-center font-weight-bolder">
                                    {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_1'] ? $arr_counted_dashboard['bottom_1'] : 0 }}
                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">WITEL</p>
                            <p class="text-sm ">TOTAL DATA WITEL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_1'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_1']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
                            </div>
                        </div>
                    </div></a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_2')]) }}">
                    <div class="anchor-bt-2a card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                              <div class=" anchor-bt-2b bg-gradient-info border-radius-lg py-3 pe-1">
                                  <p class=" sz-h3 text-white text-center font-weight-bolder">
                                    {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_2'] ? $arr_counted_dashboard['bottom_2'] : 0 }}
                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">OBL</p>
                            <p class="text-sm ">TOTAL DATA OBL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_2'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_2']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
                            </div>
                        </div>
                    </div></a>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_3')]) }}">
                    <div class="anchor-bt-3a card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                              <div class=" anchor-bt-3b bg-gradient-warning  border-radius-lg py-3 pe-1">
                                  <p class=" sz-h3 text-white text-center font-weight-bolder">
                                    {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_3'] ? $arr_counted_dashboard['bottom_3'] : 0 }}
                                  </p>
                              </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 font-weight-bolder">LEGAL</p>
                            <p class="text-sm ">TOTAL DATA LEGAL</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_3'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_3']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
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
                                <p class=" sz-h3 text-white text-center font-weight-bolder">
                                  {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_4'] ? $arr_counted_dashboard['bottom_4'] : 0 }}
                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                          <p class="mb-0 font-weight-bolder">MITRA OBL</p>
                          <p class="text-sm ">TOTAL DATA MITRA OBL</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_4'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_4']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
                          </div>
                      </div>
                  </div></a>
              </div>
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_5')]) }}">
                  <div class=" anchor-bt-5a card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                            <div class=" anchor-bt-5b bg-gradient-closesm border-radius-lg py-3 pe-1">
                                <p class=" sz-h3 text-white text-center font-weight-bolder">
                                  {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_5'] ? $arr_counted_dashboard['bottom_5'] : 0 }}
                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                        <p class="mb-0 font-weight-bolder">CLOSE SM</p>
                          <p class="text-sm ">TOTAL DATA CLOSE SM</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_5'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_5']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
                          </div>
                      </div>
                  </div></a>
              </div>
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <a class="anchor-merah" href="{{ route('obl.tables',['gdt'=>Crypt::encrypt('bottom_6')]) }}">
                  <div class="anchor-bt-6a card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">

                            <div class=" anchor-bt-6b bg-gradient-success  border-radius-lg py-3 pe-1">
                                <p class=" sz-h3 text-white text-center font-weight-bolder">
                                  {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['bottom_6'] ? $arr_counted_dashboard['bottom_6'] : 0 }}
                                </p>
                            </div>
                      </div>
                      <div class="card-body">
                          <p class="mb-0 font-weight-bolder">DONE</p>
                          <p class="text-sm ">TOTAL DATA DONE</p>
                          <hr class="dark horizontal">
                          <div class="d-flex ">
                              <i class="material-icons text-sm my-auto me-1">schedule</i>
                              <p class="mb-0 text-sm"> {{ isset($arr_counted_dashboard) && $arr_counted_dashboard['timed_bottom_6'] ? "Updated: " . \Carbon\Carbon::createFromTimeStamp(strtotime( $arr_counted_dashboard['timed_bottom_6']->tgl  ))->diffForHumans()  : "Belum Ada Update" }} </p>
                          </div>
                      </div>
                  </div></a>
              </div>
            </div>

            </div>


        </div>
    </main>
    </div>
</x-layout>
