<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="reward-witel-obl"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="REWARD WITEL"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <style media="screen">
              #btn_loading {
                display: none;
              }
            </style>

            <!-- modal alerts -->
            <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Submit Form Witel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="status-input-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- end modal alerts -->


            <div class="container-fluid py-4">

                <div class="row pb-4">
                    <div class="col-6 ">
                        <div class="btn-group p-1 d-flex align-items-center" role="group">
                          <label disabled for="" class="disabled btn btn-sm btn-group bg-gradient-secondary">Mulai</label> <input type="date" class="btn btn-sm btn-group bg-gradient-light" autocomplete="off" name="tgl_mulai" id="tgl_mulai" value="">
                          <label disabled for="" class="disabled btn btn-sm btn-group bg-gradient-secondary">Hingga</label> <input type="date" class="btn btn-sm btn-group bg-gradient-light" autocomplete="off" name="tgl_akhir" id="tgl_akhir" value="">
                          <button type="button" name="button" class="btn btn-sm btn-group bg-gradient-info" onclick="filterReward()" id="btn_filter">Filter</button>
                          <button class="btn btn-sm btn-group btn-gradient-info" type="button" disabled id="btn_loading">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                          </button>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 mx-auto">
                      <!-- START PRA LOP -->
                      <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          @if(isset($user_in_is))
                            @if($user_in_is->role_id === 4 || $user_in_is->role_id === 5)
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">REPORT PRA LOP</h6>
                            </div>
                            @elseif($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5)
                            <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class=" text-capitalize ps-3">REPORT PRA LOP</h6>
                            </div>
                            @endif
                          @endif
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="table-pra-lop" class="table align-items-center text-center mb-0" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr class="kepala">
                                            <th
                                                class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                WITEL
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL<br>SEMUA DATA
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                POIN<br>SOLUTION
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                POIN<br>LEGAL
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL POIN
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL PRA LOP<br>DI WITEL
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL PRA LOP<br>DI SOLUTION
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL PRA LOP<br>DI LEGAL
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL FINAL<br>PRA LOP
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL<br>DOKUMEN REVISI
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TOTAL<br>PROSES REVISI
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs" id="data-pra-lop">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                      </div>
                      <!-- END CARD PRA LOP -->
                      <br>
                      <!-- START OBL -->
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                @if(isset($user_in_is))
                                  @if($user_in_is->role_id === 4 || $user_in_is->role_id === 5)
                                  <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                      <h6 class="text-white text-capitalize ps-3">REPORT OBL</h6>
                                  </div>
                                  @elseif($user_in_is->role_id !== 4 && $user_in_is->role_id !== 5)
                                  <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                      <h6 class=" text-capitalize ps-3">REPORT OBL</h6>
                                  </div>
                                  @endif
                                @endif
                            </div>

                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="table-reward-witel" class="table align-items-center text-center mb-0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr class="kepala">
                                                <th
                                                    class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                    WITEL
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    TOTAL<br>SEMUA DATA
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    TOTAL<br>DATA CANCEL
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    TOTAL<br>DATA DONE
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    JUMLAH DOKUMEN<br>PROSES OBL
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    JUMLAH DOKUMEN<br>PROSES WITEL
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    JUMLAH DOKUMEN<br>DI WITEL
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    TOTAL<br>DOKUMEN REVISI
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    TOTAL<br>PROSES REVISI
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-xs" id="data-reward-witel">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- END OBL -->
                    </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script>
            function countRewardWitel(user_in_is,tgl_mulai,tgl_akhir){
              $('#btn_loading').show(); $('#btn_filter').hide();
              $.ajax({
                 type:'GET',
                 url:"{{ route('reward.witel_obl') }}",
                 data:{
                   tgl_mulai: tgl_mulai,
                   tgl_akhir: tgl_akhir
                 },
                 success:function(data){
                    console.log(tgl_mulai,tgl_akhir,data);
                    let result = ``;
                    let result2 = ``;
                    $.each(data.obl,function(index,value){
                      if( user_in_is.role_id !== 4 && user_in_is.role_id !== 5 ){
                          result+=`
                          <tr >
                            <td><b>`+value.f1_witel+`</b></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('a') }}" class="text-black">`+value.total+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('b') }}" class="text-black">`+value.total_cancel+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('c') }}" class="text-black">`+value.total_done+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('d') }}" class="text-black">`+value.total_obl+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('e') }}" class="text-black">`+value.total_witel+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('f') }}" class="text-black">`+value.total_rev_now+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('g') }}" class="text-black">`+value.total_doc_rev+`</a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('h') }}" class="text-black">`+value.total_prs_rev+`</a></td>
                          </tr>
                          `;
                      }
                      if( user_in_is.role_id === 4 || user_in_is.role_id === 5 ){
                        if( user_in_is.nama_witel && user_in_is.nama_witel !== '' && user_in_is.nama_witel === value.f1_witel ){
                          result+=`
                          <tr >
                            <td><b>`+value.f1_witel+`</b></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('a') }}" class="text-black"><b>`+value.total+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('b') }}" class="text-black"><b>`+value.total_cancel+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('c') }}" class="text-black"><b>`+value.total_done+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('d') }}" class="text-black"><b>`+value.total_obl+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('e') }}" class="text-black"><b>`+value.total_witel+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('f') }}" class="text-black"><b>`+value.total_rev_now+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('g') }}" class="text-black"><b>`+value.total_doc_rev+`</b></a></td>
                            <td><a href="{{ route('obl.tables') }}?wl=`+value.f1_witel+`&cl={{ Crypt::encryptstring('h') }}" class="text-black"><b>`+value.total_prs_rev+`</b></a></td>
                          </tr>
                          `;
                        }
                        else{
                          result+=`
                          <tr >
                            <td>`+value.f1_witel+`</td>
                            <td>`+value.total+`</td>
                            <td>`+value.total_cancel+`</td>
                            <td>`+value.total_done+`</td>
                            <td>`+value.total_obl+`</td>
                            <td>`+value.total_witel+`</td>
                            <td>`+value.total_rev_now+`</td>
                            <td>`+value.total_doc_rev+`</td>
                            <td>`+value.total_prs_rev+`</td>
                          </tr>
                          `;
                        }
                      }
                    });
                    $.each(data.pralop,function(index,value){
                      if( user_in_is.role_id !== 4 && user_in_is.role_id !== 5 ){
                          result2+=`
                          <tr >
                            <td><b>`+value.lop_witel+`</b></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('a') }}" class="text-black">`+value.total+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('j') }}" class="text-black">`+value.total_poin_sol+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('k') }}" class="text-black">`+value.total_poin_leg+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('m') }}" class="text-black">`+value.total_poin+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('b') }}" class="text-black">`+value.total_witel+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('c') }}" class="text-black">`+value.total_solution+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('d') }}" class="text-black">`+value.total_legal+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('e') }}" class="text-black">`+value.total_final_pralop+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('f') }}" class="text-black">`+value.total_doc_rev+`</a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('g') }}" class="text-black">`+value.total_prs_rev+`</a></td>
                          </tr>
                          `;
                      }
                      if( user_in_is.role_id === 4 || user_in_is.role_id === 5 ){
                        if( user_in_is.nama_witel && user_in_is.nama_witel !== '' && user_in_is.nama_witel === value.lop_witel ){
                          result2+=`
                          <tr >
                            <td><b>`+value.lop_witel+`</b></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('a') }}" class="text-black"><b>`+value.total+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('j') }}" class="text-black"><b>`+value.total_poin_sol+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('k') }}" class="text-black"><b>`+value.total_poin_leg+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('m') }}" class="text-black"><b>`+value.total_poin+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('b') }}" class="text-black"><b>`+value.total_witel+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('c') }}" class="text-black"><b>`+value.total_solution+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('d') }}" class="text-black"><b>`+value.total_legal+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('e') }}" class="text-black"><b>`+value.total_final_pralop+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('f') }}" class="text-black"><b>`+value.total_doc_rev+`</b></a></td>
                            <td><a href="{{ route('witels.pralop') }}?wl=`+value.lop_witel+`&cl={{ Crypt::encryptstring('g') }}" class="text-black"><b>`+value.total_prs_rev+`</b></a></td>
                          </tr>
                          `;
                        }
                        else{
                          result2+=`
                          <tr >
                            <td>`+value.lop_witel+`</td>
                            <td>`+value.total+`</td>
                            <td>`+value.total_poin_sol+`</td>
                            <td>`+value.total_poin_leg+`</td>
                            <td>`+value.total_poin+`</td>
                            <td>`+value.total_witel+`</td>
                            <td>`+value.total_solution+`</td>
                            <td>`+value.total_legal+`</td>
                            <td>`+value.total_final_pralop+`</td>
                            <td>`+value.total_doc_rev+`</td>
                            <td>`+value.total_prs_rev+`</td>
                          </tr>
                          `;
                        }
                      }
                    });
                    $('#data-reward-witel').empty(); $('#data-reward-witel').append(result);
                    $('#data-pra-lop').empty(); $('#data-pra-lop').append(result2);

                    $('#btn_filter').show(); $('#btn_loading').hide();
                 }
               });
            }

            function filterReward(tgl_mulai,tgl_akhir){
              if( tgl_mulai === undefined ){ tgl_mulai = $('#tgl_mulai').val(); }
              if( tgl_akhir === undefined ){ tgl_akhir = $('#tgl_akhir').val(); }
              var user_in_is = @json($user_in_is);
              countRewardWitel(user_in_is,tgl_mulai,tgl_akhir);
            }

            $( document ).ready(function() {
              var tgl_mulai = $('#tgl_mulai').val();
              var tgl_akhir = $('#tgl_akhir').val();
              filterReward(tgl_mulai,tgl_akhir);
            });

        </script>
        @endpush
</x-layout>
