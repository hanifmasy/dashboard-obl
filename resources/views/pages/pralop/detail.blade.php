<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="witels-pralop-detail"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="PRA LOP DETAIL"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <style media="screen">
            textarea {
              max-width: 200%;
            }

            input[type="radio"]:disabled {
              accent-color : #696;
            }

        </style>

        <!-- modal alerts -->
        <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Status Submit PRA LOP</h5>
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

        <div class="modal fade" id="modal-status-table-obl-delete" tabindex="-1" aria-labelledby="modal-status-table-obl-delete" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Hapus Layanan:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="">
                    <div class="text-center">
                        <h5 class="">Anda Yakin Hapus Layanan?</h5>
                    </div>
                </div>
              </div>
              <form action="{{ route('witels.pralop.detail.layanan.delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-footer" id="modal-pilihan-table-obl-hapus">
                </div>
                <input type="text" name="encrypted" value="{{ $encrypted }}" hidden>
              </form>
            </div>
          </div>
        </div>

        <!-- end modal alerts -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8">
                  <div class="row">
                      <div class="col-lg-12 ms-1 d-flex align-items-center">
                        <a href="{{ route('witels.pralop') }}" role="button" class="btn btn-md bg-gradient-dark text-white" >KEMBALI</a>

                        <form class="" action="{{ route('witels.pralop.langkah') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          @if( $user_pralop )
                            @if( $user_pralop->role_id === 4 )
                            <button type="submit" name="submit_verifikasi" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-info text-white" >LANJUT VERIFIKASI</button>
                            @elseif( $user_pralop->role_id === 5 || $user_pralop->role_id === 7 )
                            @elseif( $user_pralop->role_id === 13 )
                            <button type="submit" name="submit_solution" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE SOLUTION</button>
                            <button type="submit" name="submit_final" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-danger text-white" >FINAL VERIFIKASI</button>
                            @elseif( $user_pralop->role_id === 8 )
                            <button type="submit" name="submit_witel" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE WITEL</button>
                            <button type="submit" name="submit_legal" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-warning text-white" >LANJUT KE LEGAL</button>
                            @elseif($user_pralop->role_id === 9 )
                            <div class="row d-flex align-items-center">
                              <div class="col d-flex ">
                                <button type="submit" name="submit_verifikasi" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-info text-white" >LANJUT VERIFIKASI</button>
                              </div>
                            </div>
                            <div class="row d-flex align-items-center">
                              <div class="col d-flex ">
                                <button type="submit" name="submit_witel" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE WITEL</button>
                                <button type="submit" name="submit_legal" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-warning text-white" >LANJUT KE LEGAL</button>
                              </div>
                            </div>
                            <div class="row d-flex align-items-center">
                              <div class="col d-flex ">
                                <button type="submit" name="submit_solution" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE SOLUTION</button>
                                <button type="submit" name="submit_final" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-danger text-white" >FINAL VERIFIKASI</button>
                              </div>
                            </div>

                            @endif
                          @endif
                        </form>

                      </div>
                  </div>

                  <!-- start attachment and checklist -->
                  @if( $user_pralop->role_id === 4 )

                  @if( $pralop->cl_list === true )
                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 bg-warning text-white text-center">REVIEW KB - CHECKLIST LEGAL</h5>

                        <div class="table-responsive">
                          <table class="table thead-dark table-striped text-center">
                            <thead>
                              <tr>
                                <th rowSpan="2">No.</th>
                                <th rowSpan="2">Checklist</th>
                                <th colSpan="2">Check</th>
                                <th rowSpan="2">Remark</th>
                              </tr>
                              <tr>
                                <th>OK</th>
                                <th>NOK</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Para Pihak /<br>Kecakapan Penandatangan</td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="ok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="nok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><textarea disabled name="cl_remark_cakap_ttd" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cakap_ttd ? $pralop->cl_remark_cakap_ttd : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Jangka Waktu</td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="ok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'ok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="nok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'nok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><textarea disabled name="cl_remark_jangka_waktu" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_jangka_waktu ? $pralop->cl_remark_jangka_waktu : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Skema Bisnis</td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'ok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'nok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><textarea disabled name="cl_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_skema_bisnis ? $pralop->cl_remark_skema_bisnis : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Cara Pembayaran</td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="ok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="nok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><textarea disabled name="cl_remark_cara_bayar" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cara_bayar ? $pralop->cl_remark_cara_bayar : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>MOM / Dokumen Pengantar<br>sebelum Kontrak / BA Nego</td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_mom" name="cl_mom" value="ok" autocomplete="off" {{ $pralop->cl_mom === 'ok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><input disabled class="form-check-input" type="radio" id="cl_mom" name="cl_mom" value="nok" autocomplete="off" {{ $pralop->cl_mom === 'nok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><textarea disabled name="cl_remark_mom" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_mom ? $pralop->cl_remark_mom : '' }} </textarea> </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                  </div>
                  @endif

                    @if( $pralop->cs_list === true )
                    <div class="row mt-2">
                      <div class="card h-50">
                        <div class="card-body p-2">
                          <h5 class="text-sm bg-success text-white text-center">REVIEW KB - CHECKLIST SOLUTION</h5>
                          <div class="table-responsive">
                            <table class="table thead-dark table-striped text-center">
                              <thead>
                                <tr>
                                  <th rowSpan="2">No.</th>
                                  <th rowSpan="2">Checklist</th>
                                  <th colSpan="2">Check</th>
                                  <th rowSpan="2">Remark</th>
                                  <th rowSpan="2">Guidance</th>
                                </tr>
                                <tr>
                                  <th>OK</th>
                                  <th>NOK</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Jenis Kontrak</td>
                                  <td><input class="form-check-input" type="radio" id="cs_jenis_kontrak" name="cs_jenis_kontrak" value="ok" autocomplete="off" disabled {{ $pralop->cs_jenis_kontrak === 'ok' ? " checked " : "" }}>
                                    <label for="cs_jenis_kontrak"></label></td>
                                  <td><input class="form-check-input" type="radio" id="jenis_kontrak" name="cs_jenis_kontrak" value="nok" autocomplete="off" disabled {{ $pralop->cs_jenis_kontrak === 'nok' ? " checked " : "" }}>
                                    <label for="cs_jenis_kontrak"></label></td>
                                  <td><textarea name="cs_remark_jenis_kontrak" rows="1" cols="15" autocomplete="off" disabled> {{ $pralop->cs_remark_jenis_kontrak ? $pralop->cs_remark_jenis_kontrak : '' }} </textarea> </td>
                                  <td>PSB, Renewal,<br>Amandemen Perpanjangan,<br>Amandemen</td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Nomor Kontrak</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'ok' ? " checked " : "" }}>
                                    <label for="cs_nomor_kontrak"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'nok' ? " checked " : "" }}>
                                    <label for="cs_nomor_kontrak"></label></td>
                                  <td><textarea disabled name="cs_remark_nomor_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_nomor_kontrak ? $pralop->cs_remark_nomor_kontrak : '' }} </textarea> </td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>Jangka Waktu<br>Instalasi</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="ok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'ok' ? " checked " : "" }}>
                                    <label for="cs_waktu_instal"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="nok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'nok' ? " checked " : "" }}>
                                    <label for="cs_waktu_instal"></label></td>
                                  <td><textarea disabled name="cs_remark_waktu_instal" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_instal ? $pralop->cs_remark_waktu_instal : '' }} </textarea> </td>
                                  <td>Sesuaikan dengan SPH<br>atau Komitmen dari Mitra,<br>Koordinasi dengan Unit<br>POQA</td>
                                </tr>
                                <tr>
                                  <td>4</td>
                                  <td>Jangka Waktu<br>Layanan</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="ok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'ok' ? " checked " : "" }}>
                                    <label for="cs_waktu_layanan"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="nok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'nok' ? " checked " : "" }}>
                                    <label for="cs_waktu_layanan"></label></td>
                                  <td><textarea disabled name="cs_remark_waktu_layanan" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_layanan ? $pralop->cs_remark_waktu_layanan : '' }} </textarea> </td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>5</td>
                                  <td>Jangka Waktu<br>Kontrak</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'ok' ? " checked " : "" }}>
                                    <label for="cs_waktu_kontrak"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'nok' ? " checked " : "" }}>
                                    <label for="cs_waktu_kontrak"></label></td>
                                  <td><textarea disabled name="cs_remark_waktu_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_kontrak ? $pralop->cs_remark_waktu_kontrak : '' }} </textarea> </td>
                                  <td>Jangka Waktu Instalasi<br>+ Jangka Waktu Layanan</td>
                                </tr>
                                <tr>
                                  <td>6</td>
                                  <td>Cara Pembayaran<br>OTC</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="ok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'ok' ? " checked " : "" }}>
                                    <label for="cs_bayar_otc"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="nok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'nok' ? " checked " : "" }}>
                                    <label for="cs_bayar_otc"></label></td>
                                  <td><textarea disabled name="cs_remark_bayar_otc" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_bayar_otc ? $pralop->cs_remark_bayar_otc : '' }} </textarea> </td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>7</td>
                                  <td>Term Of Payment</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_term_pay" name="cs_term_pay" value="ok" autocomplete="off" {{ $pralop->cs_term_pay === 'ok' ? " checked " : "" }}>
                                    <label for="cs_term_pay"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_term_pay" name="cs_term_pay" value="nok" autocomplete="off" {{ $pralop->cs_term_pay === 'nok' ? " checked " : "" }}>
                                    <label for="cs_term_pay"></label></td>
                                  <td><textarea disabled name="cs_remark_term_pay" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_term_pay ? $pralop->cs_remark_term_pay : '' }} </textarea> </td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>8</td>
                                  <td>Kesesuaian TOP<br>Telkom dengan Mitra</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'ok' ? " checked " : "" }}>
                                    <label for="cs_sesuai_top"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'nok' ? " checked " : "" }}>
                                    <label for="cs_sesuai_top"></label></td>
                                  <td><textarea disabled name="cs_remark_sesuai_top" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_top ? $pralop->cs_remark_sesuai_top : '' }} </textarea> </td>
                                  <td>Sesuaikan dengan<br>SPH atau<br>Komitmen Mitra</td>
                                </tr>
                                <tr>
                                  <td>9</td>
                                  <td>Kesesuaian BoQ<br>Telkom dengan Mitra</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'ok' ? " checked " : "" }}>
                                    <label for="cs_sesuai_boq"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'nok' ? " checked " : "" }}>
                                    <label for="cs_sesuai_boq"></label></td>
                                  <td><textarea disabled name="cs_remark_sesuai_boq" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_boq ? $pralop->cs_remark_sesuai_boq : '' }} </textarea> </td>
                                  <td>Perhitungan Profitability</td>
                                </tr>
                                <tr>
                                  <td>10</td>
                                  <td>Skema Bisnis</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'ok' ? " checked " : "" }}>
                                    <label for="cs_skema_bisnis"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'nok' ? " checked " : "" }}>
                                    <label for="cs_skema_bisnis"></label></td>
                                  <td><textarea disabled name="cs_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_skema_bisnis ? $pralop->cs_remark_skema_bisnis : '' }} </textarea> </td>
                                  <td>Jual Beli/Sewa Menyewa<br>/Berlangganan<br>/Managed Service/Lainnya<br>Sesuai PK KB 511.02.02</td>
                                </tr>
                                <tr>
                                  <td>11</td>
                                  <td>Ruang Lingkup<br>Bisnis</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_ruang" name="cs_ruang" value="ok" autocomplete="off" {{ $pralop->cs_ruang === 'ok' ? " checked " : "" }}>
                                    <label for="cs_ruang"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_ruang" name="cs_ruang" value="nok" autocomplete="off" {{ $pralop->cs_ruang === 'nok' ? " checked " : "" }}>
                                    <label for="cs_ruang"></label></td>
                                  <td><textarea disabled name="cs_remark_ruang" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_ruang ? $pralop->cs_remark_ruang : '' }} </textarea> </td>
                                  <td>KAK, SSUK, MoM,<br>Proposal Layanan</td>
                                </tr>
                                <tr>
                                  <td>12</td>
                                  <td>Kesesuaian SLA/SLG<br>Layanan (Connectivity dan Mitra)</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sla_slg" name="cs_sla_slg" value="ok" autocomplete="off" {{ $pralop->cs_sla_slg === 'ok' ? " checked " : "" }}>
                                    <label for="cs_sla_slg"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_sla_slg" name="cs_sla_slg" value="nok" autocomplete="off" {{ $pralop->cs_sla_slg === 'nok' ? " checked " : "" }}>
                                    <label for="cs_sla_slg"></label></td>
                                  <td><textarea disabled name="cs_remark_sla_slg" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sla_slg ? $pralop->cs_remark_sla_slg : '' }} </textarea> </td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td>13</td>
                                  <td>Kesesuaian Layanan<br>KB dan BA Splitting</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="ok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'ok' ? " checked " : "" }}>
                                    <label for="cs_kb_ba_split"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="nok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'nok' ? " checked " : "" }}>
                                    <label for="cs_kb_ba_split"></label></td>
                                  <td><textarea disabled name="cs_remark_kb_ba_split" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_kb_ba_split ? $pralop->cs_remark_kb_ba_split : '' }} </textarea> </td>
                                  <td>Acuan Splitting</td>
                                </tr>
                                <tr>
                                  <td>14</td>
                                  <td>Format Kontrak</td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'ok' ? " checked " : "" }}>
                                    <label for="cs_format_kontrak"></label></td>
                                  <td><input class="form-check-input" disabled type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'nok' ? " checked " : "" }}>
                                    <label for="cs_format_kontrak"></label></td>
                                  <td><textarea disabled name="cs_remark_format_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_format_kontrak ? $pralop->cs_remark_format_kontrak : '' }} </textarea> </td>
                                  <td>KBFL</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                    </div>
                    @endif
                  <div class="row mt-2">

                    <div class="card h-75">
                      <div class="card-body p-3">

                        <form class="" action="{{ route('witels.pralop.review_kb') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="text" name="pralop_id" value="{{ $encrypted }}" hidden>

                          <div class="row d-flex align-items-center">
                            <div class="col-4">
                              <h6 class="">UPLOAD ATTACHMENT FILE:</h6>
                            </div>
                          </div>

                          <div class="row d-flex align-items-center">
                            <div class="col d-flex">

                              @if( $errors->has('file_draf_kb') )
                              <button class="btn btn-link px-3 mb-0 mt-2 " type="button" id="btn_clear_draf_kb" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_draf_kb" class="outline-input-merah px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_draf_kb"><span id="label_file_draf_kb">Draf KB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_draf_kb" name="file_draf_kb" type="file" ><p class="text-danger text-sm">*mandatory</p>
                              @else
                              <button class="btn btn-link px-3 mb-0 mt-2 " type="button" id="btn_clear_draf_kb" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_draf_kb" class=" px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_draf_kb"><span id="label_file_draf_kb">Draf KB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_draf_kb" name="file_draf_kb" type="file" >
                              @endif

                              @if( $errors->has('file_rab') )
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_rab" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_rab" class="outline-input-merah px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_rab"><span id="label_file_rab">RAB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_rab" name="file_rab" type="file" ><p class="text-danger text-sm">*mandatory</p>
                              @else
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_rab" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_rab" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_rab"><span id="label_file_rab">RAB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_rab" name="file_rab" type="file" >
                              @endif

                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex">
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_mom" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_mom" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_mom"><span id="label_file_mom">MOM</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_mom" name="file_mom" type="file">

                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_basplit" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_basplit" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_basplit"><span id="label_file_basplit">BA Splitting</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_basplit" name="file_basplit" type="file">

                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_skk" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_skk" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_skk"><span id="label_file_skk">SKK</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_skk" name="file_skk" type="file">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex">
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_attachment" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_attachment" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_attachment"><span id="label_file_attachment">File Tambahan</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_attachment" name="file_attachment[]" type="file" multiple>
                            </div>
                          </div>

                          <div class="row mt-4">
                            <div class="col">
                              <button type="submit" name="submit" value="review_kb" class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2">Upload Attachment</button>
                            </div>
                          </div>
                        </form>


                      </div>
                    </div>
                    <div class="card h-50 mt-3">
                      <div class="card-body p-2">
                        <h6 class=" ms-2">ATTACHMENT FILES: </h6>

                        <form id="formReviewKB" class="" action="" method="POST" enctype="multipart/form-data">
                          @csrf

                        <div class="row d-flex align-items-center mt-1 mb-1 p-1">
                          <div class="col-md-12">
                          @if( isset($pralop_files) )
                            @if( $pralop_files )
                              @foreach( $pralop_files as $key => $value )
                                <div class="btn-group ps-2" role="group">
                                  @if( $value->tipe_file === 'file_draf_kb' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> DRAF KB </button>
                                  @elseif( $value->tipe_file === 'file_rab' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> RAB </button>
                                  @elseif( $value->tipe_file === 'file_mom' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> MOM </button>
                                  @elseif( $value->tipe_file === 'file_basplit' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> BA Splitting </button>
                                  @elseif( $value->tipe_file === 'file_skk' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> SKK </button>
                                  @elseif( $value->tipe_file === 'file_attachment' )
                                  <button disabled type="button" name="" class="btn btn-link bg-gradient-secondary mt-1"> File Tambahan </button>
                                  @endif
                                  <button onclick="downloadKB( {{ $value->id }} )" type="button" class="mt-1 btn btn-link bg-gradient-secondary"> <i class="material-icons text-sm">download</i> {{ $value->nama_asli_files }}</button>
                                </div>
                              @endforeach
                            @else
                              <h5 class="text-danger text-xs">[ BELUM ADA FILE ]</h5>
                            @endif
                          @endif
                        </div>
                      </div>

                        </form>

                      </div>
                    </div>

                  </div>
                  @elseif( $user_pralop->role_id === 8 )

                    @if( $pralop->cl_list === true )
                    <div class="row mt-2">
                      <div class="card h-25">
                        <h5 class="text-sm mt-1 bg-warning text-white text-center">REVIEW KB - CHECKLIST LEGAL</h5>

                          <div class="table-responsive">
                            <table class="table thead-dark table-striped text-center">
                              <thead>
                                <tr>
                                  <th rowSpan="2">No.</th>
                                  <th rowSpan="2">Checklist</th>
                                  <th colSpan="2">Check</th>
                                  <th rowSpan="2">Remark</th>
                                </tr>
                                <tr>
                                  <th>OK</th>
                                  <th>NOK</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Para Pihak /<br>Kecakapan Penandatangan</td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="ok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'ok' ? " checked " : "" }}>
                                    <label for="cl_cakap_ttd"></label></td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="nok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'nok' ? " checked " : "" }}>
                                    <label for="cl_cakap_ttd"></label></td>
                                  <td><textarea disabled name="cl_remark_cakap_ttd" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cakap_ttd ? $pralop->cl_remark_cakap_ttd : '' }} </textarea> </td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Jangka Waktu</td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="ok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'ok' ? " checked " : "" }}>
                                    <label for="cl_jangka_waktu"></label></td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="nok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'nok' ? " checked " : "" }}>
                                    <label for="cl_jangka_waktu"></label></td>
                                  <td><textarea disabled name="cl_remark_jangka_waktu" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_jangka_waktu ? $pralop->cl_remark_jangka_waktu : '' }} </textarea> </td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>Skema Bisnis</td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'ok' ? " checked " : "" }}>
                                    <label for="cl_skema_bisnis"></label></td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'nok' ? " checked " : "" }}>
                                    <label for="cl_skema_bisnis"></label></td>
                                  <td><textarea disabled name="cl_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_skema_bisnis ? $pralop->cl_remark_skema_bisnis : '' }} </textarea> </td>
                                </tr>
                                <tr>
                                  <td>4</td>
                                  <td>Cara Pembayaran</td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="ok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'ok' ? " checked " : "" }}>
                                    <label for="cl_cara_bayar"></label></td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="nok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'nok' ? " checked " : "" }}>
                                    <label for="cl_cara_bayar"></label></td>
                                  <td><textarea disabled name="cl_remark_cara_bayar" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cara_bayar ? $pralop->cl_remark_cara_bayar : '' }} </textarea> </td>
                                </tr>
                                <tr>
                                  <td>5</td>
                                  <td>MOM / Dokumen Pengantar<br>sebelum Kontrak / BA Nego</td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_mom" name="cl_mom" value="ok" autocomplete="off" {{ $pralop->cl_mom === 'ok' ? " checked " : "" }}>
                                    <label for="cl_mom"></label></td>
                                  <td><input disabled class="form-check-input" type="radio" id="cl_mom" name="cl_mom" value="nok" autocomplete="off" {{ $pralop->cl_mom === 'nok' ? " checked " : "" }}>
                                    <label for="cl_mom"></label></td>
                                  <td><textarea disabled name="cl_remark_mom" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_mom ? $pralop->cl_remark_mom : '' }} </textarea> </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>
                    @endif

                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 bg-success text-white text-center">REVIEW KB - CHECKLIST SOLUTION</h5>
                      <form class="" action="{{ route('witels.pralop.review_kb.checklist_solution') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive">
                          <table class="table thead-dark table-striped text-center">
                            <thead>
                              <tr>
                                <th rowSpan="2">No.</th>
                                <th rowSpan="2">Checklist</th>
                                <th colSpan="2">Check</th>
                                <th rowSpan="2">Remark</th>
                                <th rowSpan="2">Guidance</th>
                              </tr>
                              <tr>
                                <th>OK</th>
                                <th>NOK</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Jenis Kontrak</td>
                                <td><input type="radio" id="cs_jenis_kontrak" name="cs_jenis_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_jenis_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_jenis_kontrak"></label></td>
                                <td><input type="radio" id="jenis_kontrak" name="cs_jenis_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_jenis_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_jenis_kontrak"></label></td>
                                <td><textarea name="cs_remark_jenis_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_jenis_kontrak ? $pralop->cs_remark_jenis_kontrak : '' }} </textarea> </td>
                                <td>PSB, Renewal,<br>Amandemen Perpanjangan,<br>Amandemen</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Nomor Kontrak</td>
                                <td><input type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_nomor_kontrak"></label></td>
                                <td><input type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_nomor_kontrak"></label></td>
                                <td><textarea name="cs_remark_nomor_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_nomor_kontrak ? $pralop->cs_remark_nomor_kontrak : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Jangka Waktu<br>Instalasi</td>
                                <td><input type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="ok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_instal"></label></td>
                                <td><input type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="nok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_instal"></label></td>
                                <td><textarea name="cs_remark_waktu_instal" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_instal ? $pralop->cs_remark_waktu_instal : '' }} </textarea> </td>
                                <td>Sesuaikan dengan SPH<br>atau Komitmen dari Mitra,<br>Koordinasi dengan Unit<br>POQA</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Jangka Waktu<br>Layanan</td>
                                <td><input type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="ok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_layanan"></label></td>
                                <td><input type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="nok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_layanan"></label></td>
                                <td><textarea name="cs_remark_waktu_layanan" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_layanan ? $pralop->cs_remark_waktu_layanan : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>Jangka Waktu<br>Kontrak</td>
                                <td><input type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_kontrak"></label></td>
                                <td><input type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_kontrak"></label></td>
                                <td><textarea name="cs_remark_waktu_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_kontrak ? $pralop->cs_remark_waktu_kontrak : '' }} </textarea> </td>
                                <td>Jangka Waktu Instalasi<br>+ Jangka Waktu Layanan</td>
                              </tr>
                              <tr>
                                <td>6</td>
                                <td>Cara Pembayaran<br>OTC</td>
                                <td><input type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="ok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'ok' ? " checked " : "" }}>
                                  <label for="cs_bayar_otc"></label></td>
                                <td><input type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="nok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'nok' ? " checked " : "" }}>
                                  <label for="cs_bayar_otc"></label></td>
                                <td><textarea name="cs_remark_bayar_otc" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_bayar_otc ? $pralop->cs_remark_bayar_otc : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>7</td>
                                <td>Term Of Payment</td>
                                <td><input type="radio" id="cs_term_pay" name="cs_term_pay" value="ok" autocomplete="off" {{ $pralop->cs_term_pay === 'ok' ? " checked " : "" }}>
                                  <label for="cs_term_pay"></label></td>
                                <td><input type="radio" id="cs_term_pay" name="cs_term_pay" value="nok" autocomplete="off" {{ $pralop->cs_term_pay === 'nok' ? " checked " : "" }}>
                                  <label for="cs_term_pay"></label></td>
                                <td><textarea name="cs_remark_term_pay" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_term_pay ? $pralop->cs_remark_term_pay : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>8</td>
                                <td>Kesesuaian TOP<br>Telkom dengan Mitra</td>
                                <td><input type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_top"></label></td>
                                <td><input type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_top"></label></td>
                                <td><textarea name="cs_remark_sesuai_top" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_top ? $pralop->cs_remark_sesuai_top : '' }} </textarea> </td>
                                <td>Sesuaikan dengan<br>SPH atau<br>Komitmen Mitra</td>
                              </tr>
                              <tr>
                                <td>9</td>
                                <td>Kesesuaian BoQ<br>Telkom dengan Mitra</td>
                                <td><input type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_boq"></label></td>
                                <td><input type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_boq"></label></td>
                                <td><textarea name="cs_remark_sesuai_boq" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_boq ? $pralop->cs_remark_sesuai_boq : '' }} </textarea> </td>
                                <td>Perhitungan Profitability</td>
                              </tr>
                              <tr>
                                <td>10</td>
                                <td>Skema Bisnis</td>
                                <td><input type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'ok' ? " checked " : "" }}>
                                  <label for="cs_skema_bisnis"></label></td>
                                <td><input type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'nok' ? " checked " : "" }}>
                                  <label for="cs_skema_bisnis"></label></td>
                                <td><textarea name="cs_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_skema_bisnis ? $pralop->cs_remark_skema_bisnis : '' }} </textarea> </td>
                                <td>Jual Beli/Sewa Menyewa<br>/Berlangganan<br>/Managed Service/Lainnya<br>Sesuai PK KB 511.02.02</td>
                              </tr>
                              <tr>
                                <td>11</td>
                                <td>Ruang Lingkup<br>Bisnis</td>
                                <td><input type="radio" id="cs_ruang" name="cs_ruang" value="ok" autocomplete="off" {{ $pralop->cs_ruang === 'ok' ? " checked " : "" }}>
                                  <label for="cs_ruang"></label></td>
                                <td><input type="radio" id="cs_ruang" name="cs_ruang" value="nok" autocomplete="off" {{ $pralop->cs_ruang === 'nok' ? " checked " : "" }}>
                                  <label for="cs_ruang"></label></td>
                                <td><textarea name="cs_remark_ruang" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_ruang ? $pralop->cs_remark_ruang : '' }} </textarea> </td>
                                <td>KAK, SSUK, MoM,<br>Proposal Layanan</td>
                              </tr>
                              <tr>
                                <td>12</td>
                                <td>Kesesuaian SLA/SLG<br>Layanan (Connectivity dan Mitra)</td>
                                <td><input type="radio" id="cs_sla_slg" name="cs_sla_slg" value="ok" autocomplete="off" {{ $pralop->cs_sla_slg === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sla_slg"></label></td>
                                <td><input type="radio" id="cs_sla_slg" name="cs_sla_slg" value="nok" autocomplete="off" {{ $pralop->cs_sla_slg === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sla_slg"></label></td>
                                <td><textarea name="cs_remark_sla_slg" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sla_slg ? $pralop->cs_remark_sla_slg : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>13</td>
                                <td>Kesesuaian Layanan<br>KB dan BA Splitting</td>
                                <td><input type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="ok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'ok' ? " checked " : "" }}>
                                  <label for="cs_kb_ba_split"></label></td>
                                <td><input type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="nok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'nok' ? " checked " : "" }}>
                                  <label for="cs_kb_ba_split"></label></td>
                                <td><textarea name="cs_remark_kb_ba_split" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_kb_ba_split ? $pralop->cs_remark_kb_ba_split : '' }} </textarea> </td>
                                <td>Acuan Splitting</td>
                              </tr>
                              <tr>
                                <td>14</td>
                                <td>Format Kontrak</td>
                                <td><input type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_format_kontrak"></label></td>
                                <td><input type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_format_kontrak"></label></td>
                                <td><textarea name="cs_remark_format_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_format_kontrak ? $pralop->cs_remark_format_kontrak : '' }} </textarea> </td>
                                <td>KBFL</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <input type="text" name="encrypted" value="{{ $encrypted }}" hidden>
                        <button type="submit" name="submit" value="checklist_solution" class="ms-2 btn btn-sm bg-gradient-primary">SIMPAN CHECKLIST</button>
                      </form>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 p-1">ATTACHMENT FILES:</h5> <br>
                      <form id="formReviewKB" class="" action="" method="POST" enctype="multipart/form-data">
                        @csrf

                      <div class="row d-flex align-items-center mt-1 mb-1 p-1">
                        <div class="col-md-12">
                        @if( isset($pralop_files) )
                          @if( $pralop_files )
                            @foreach( $pralop_files as $key => $value )
                              <button onclick="downloadKB( {{ $value->id }} )" type="button" class="mt-1 ms-1 btn btn-link bg-gradient-secondary px-3"> <i class="material-icons text-sm">download</i> {{ $value->nama_asli_files }}</button>
                            @endforeach
                          @endif
                        @endif
                      </div>
                    </div>

                      </form>
                    </div>
                  </div>

                  @elseif( $user_pralop->role_id === 13 )

                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 text-center bg-warning text-white">REVIEW KB - CHECKLIST LEGAL</h5>
                      <form class="" action="{{ route('witels.pralop.review_kb.checklist_legal') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive">
                          <table class="table thead-dark table-striped text-center">
                            <thead>
                              <tr>
                                <th rowSpan="2">No.</th>
                                <th rowSpan="2">Checklist</th>
                                <th colSpan="2">Check</th>
                                <th rowSpan="2">Remark</th>
                              </tr>
                              <tr>
                                <th>OK</th>
                                <th>NOK</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Para Pihak /<br>Kecakapan Penandatangan</td>
                                <td><input type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="ok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><input type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="nok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><textarea name="cl_remark_cakap_ttd" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cakap_ttd ? $pralop->cl_remark_cakap_ttd : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Jangka Waktu</td>
                                <td><input type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="ok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'ok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><input type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="nok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'nok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><textarea name="cl_remark_jangka_waktu" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_jangka_waktu ? $pralop->cl_remark_jangka_waktu : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Skema Bisnis</td>
                                <td><input type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'ok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><input type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'nok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><textarea name="cl_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_skema_bisnis ? $pralop->cl_remark_skema_bisnis : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Cara Pembayaran</td>
                                <td><input type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="ok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><input type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="nok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><textarea name="cl_remark_cara_bayar" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cara_bayar ? $pralop->cl_remark_cara_bayar : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>MOM / Dokumen Pengantar<br>sebelum Kontrak / BA Nego</td>
                                <td><input type="radio" id="cl_mom" name="cl_mom" value="ok" autocomplete="off" {{ $pralop->cl_mom === 'ok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><input type="radio" id="cl_mom" name="cl_mom" value="nok" autocomplete="off" {{ $pralop->cl_mom === 'nok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><textarea name="cl_remark_mom" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_mom ? $pralop->cl_remark_mom : '' }} </textarea> </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <input type="text" name="encrypted" value="{{ $encrypted }}" hidden>
                        <button type="submit" name="submit" value="checklist_legal" class="ms-2 btn btn-sm bg-gradient-primary">SIMPAN CHECKLIST</button>
                      </form>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 p-1">ATTACHMENT FILES:</h5> <br>
                      <form id="formReviewKB" class="" action="" method="POST" enctype="multipart/form-data">
                        @csrf

                      <div class="row d-flex align-items-center mt-1 mb-1 p-1">
                        <div class="col-md-12">
                        @if( isset($pralop_files) )
                          @if( $pralop_files )
                            @foreach( $pralop_files as $key => $value )
                              <button onclick="downloadKB( {{ $value->id }} )" type="button" class="mt-1 ms-1 btn btn-link bg-gradient-secondary px-3"> <i class="material-icons text-sm">download</i> {{ $value->nama_asli_files }}</button>
                            @endforeach
                          @endif
                        @endif
                      </div>
                    </div>

                      </form>
                    </div>
                  </div>

                  @elseif( $user_pralop->role_id === 9 )
                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 text-center bg-warning text-white">REVIEW KB - CHECKLIST LEGAL</h5>
                      <form class="" action="{{ route('witels.pralop.review_kb.checklist_legal') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive">
                          <table class="table thead-dark table-striped text-center">
                            <thead>
                              <tr>
                                <th rowSpan="2">No.</th>
                                <th rowSpan="2">Checklist</th>
                                <th colSpan="2">Check</th>
                                <th rowSpan="2">Remark</th>
                              </tr>
                              <tr>
                                <th>OK</th>
                                <th>NOK</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Para Pihak /<br>Kecakapan Penandatangan</td>
                                <td><input type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="ok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><input type="radio" id="cl_cakap_ttd" name="cl_cakap_ttd" value="nok" autocomplete="off" {{ $pralop->cl_cakap_ttd === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cakap_ttd"></label></td>
                                <td><textarea name="cl_remark_cakap_ttd" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cakap_ttd ? $pralop->cl_remark_cakap_ttd : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Jangka Waktu</td>
                                <td><input type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="ok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'ok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><input type="radio" id="cl_jangka_waktu" name="cl_jangka_waktu" value="nok" autocomplete="off" {{ $pralop->cl_jangka_waktu === 'nok' ? " checked " : "" }}>
                                  <label for="cl_jangka_waktu"></label></td>
                                <td><textarea name="cl_remark_jangka_waktu" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_jangka_waktu ? $pralop->cl_remark_jangka_waktu : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Skema Bisnis</td>
                                <td><input type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'ok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><input type="radio" id="cl_skema_bisnis" name="cl_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cl_skema_bisnis === 'nok' ? " checked " : "" }}>
                                  <label for="cl_skema_bisnis"></label></td>
                                <td><textarea name="cl_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_skema_bisnis ? $pralop->cl_remark_skema_bisnis : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Cara Pembayaran</td>
                                <td><input type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="ok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'ok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><input type="radio" id="cl_cara_bayar" name="cl_cara_bayar" value="nok" autocomplete="off" {{ $pralop->cl_cara_bayar === 'nok' ? " checked " : "" }}>
                                  <label for="cl_cara_bayar"></label></td>
                                <td><textarea name="cl_remark_cara_bayar" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_cara_bayar ? $pralop->cl_remark_cara_bayar : '' }} </textarea> </td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>MOM / Dokumen Pengantar<br>sebelum Kontrak / BA Nego</td>
                                <td><input type="radio" id="cl_mom" name="cl_mom" value="ok" autocomplete="off" {{ $pralop->cl_mom === 'ok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><input type="radio" id="cl_mom" name="cl_mom" value="nok" autocomplete="off" {{ $pralop->cl_mom === 'nok' ? " checked " : "" }}>
                                  <label for="cl_mom"></label></td>
                                <td><textarea name="cl_remark_mom" rows="1" cols="15" autocomplete="off"> {{ $pralop->cl_remark_mom ? $pralop->cl_remark_mom : '' }} </textarea> </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <input type="text" name="encrypted" value="{{ $encrypted }}" hidden>
                        <button type="submit" name="submit" value="checklist_legal" class="ms-2 btn btn-sm bg-gradient-primary">SIMPAN CHECKLIST</button>
                      </form>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="card h-25">
                      <h5 class="text-sm mt-1 text-center bg-success text-white ">REVIEW KB - CHECKLIST SOLUTION</h5>
                      <form class="" action="{{ route('witels.pralop.review_kb.checklist_solution') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive">
                          <table class="table thead-dark table-striped text-center">
                            <thead>
                              <tr>
                                <th rowSpan="2">No.</th>
                                <th rowSpan="2">Checklist</th>
                                <th colSpan="2">Check</th>
                                <th rowSpan="2">Remark</th>
                                <th rowSpan="2">Guidance</th>
                              </tr>
                              <tr>
                                <th>OK</th>
                                <th>NOK</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Jenis Kontrak</td>
                                <td><input type="radio" id="cs_jenis_kontrak" name="cs_jenis_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_jenis_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_jenis_kontrak"></label></td>
                                <td><input type="radio" id="jenis_kontrak" name="cs_jenis_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_jenis_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_jenis_kontrak"></label></td>
                                <td><textarea name="cs_remark_jenis_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_jenis_kontrak ? $pralop->cs_remark_jenis_kontrak : '' }} </textarea> </td>
                                <td>PSB, Renewal,<br>Amandemen Perpanjangan,<br>Amandemen</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Nomor Kontrak</td>
                                <td><input type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_nomor_kontrak"></label></td>
                                <td><input type="radio" id="cs_nomor_kontrak" name="cs_nomor_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_nomor_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_nomor_kontrak"></label></td>
                                <td><textarea name="cs_remark_nomor_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_nomor_kontrak ? $pralop->cs_remark_nomor_kontrak : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Jangka Waktu<br>Instalasi</td>
                                <td><input type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="ok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_instal"></label></td>
                                <td><input type="radio" id="cs_waktu_instal" name="cs_waktu_instal" value="nok" autocomplete="off" {{ $pralop->cs_waktu_instal === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_instal"></label></td>
                                <td><textarea name="cs_remark_waktu_instal" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_instal ? $pralop->cs_remark_waktu_instal : '' }} </textarea> </td>
                                <td>Sesuaikan dengan SPH<br>atau Komitmen dari Mitra,<br>Koordinasi dengan Unit<br>POQA</td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>Jangka Waktu<br>Layanan</td>
                                <td><input type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="ok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_layanan"></label></td>
                                <td><input type="radio" id="cs_waktu_layanan" name="cs_waktu_layanan" value="nok" autocomplete="off" {{ $pralop->cs_waktu_layanan === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_layanan"></label></td>
                                <td><textarea name="cs_remark_waktu_layanan" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_layanan ? $pralop->cs_remark_waktu_layanan : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>Jangka Waktu<br>Kontrak</td>
                                <td><input type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_waktu_kontrak"></label></td>
                                <td><input type="radio" id="cs_waktu_kontrak" name="cs_waktu_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_waktu_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_waktu_kontrak"></label></td>
                                <td><textarea name="cs_remark_waktu_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_waktu_kontrak ? $pralop->cs_remark_waktu_kontrak : '' }} </textarea> </td>
                                <td>Jangka Waktu Instalasi<br>+ Jangka Waktu Layanan</td>
                              </tr>
                              <tr>
                                <td>6</td>
                                <td>Cara Pembayaran<br>OTC</td>
                                <td><input type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="ok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'ok' ? " checked " : "" }}>
                                  <label for="cs_bayar_otc"></label></td>
                                <td><input type="radio" id="cs_bayar_otc" name="cs_bayar_otc" value="nok" autocomplete="off" {{ $pralop->cs_bayar_otc === 'nok' ? " checked " : "" }}>
                                  <label for="cs_bayar_otc"></label></td>
                                <td><textarea name="cs_remark_bayar_otc" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_bayar_otc ? $pralop->cs_remark_bayar_otc : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>7</td>
                                <td>Term Of Payment</td>
                                <td><input type="radio" id="cs_term_pay" name="cs_term_pay" value="ok" autocomplete="off" {{ $pralop->cs_term_pay === 'ok' ? " checked " : "" }}>
                                  <label for="cs_term_pay"></label></td>
                                <td><input type="radio" id="cs_term_pay" name="cs_term_pay" value="nok" autocomplete="off" {{ $pralop->cs_term_pay === 'nok' ? " checked " : "" }}>
                                  <label for="cs_term_pay"></label></td>
                                <td><textarea name="cs_remark_term_pay" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_term_pay ? $pralop->cs_remark_term_pay : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>8</td>
                                <td>Kesesuaian TOP<br>Telkom dengan Mitra</td>
                                <td><input type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_top"></label></td>
                                <td><input type="radio" id="cs_sesuai_top" name="cs_sesuai_top" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_top === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_top"></label></td>
                                <td><textarea name="cs_remark_sesuai_top" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_top ? $pralop->cs_remark_sesuai_top : '' }} </textarea> </td>
                                <td>Sesuaikan dengan<br>SPH atau<br>Komitmen Mitra</td>
                              </tr>
                              <tr>
                                <td>9</td>
                                <td>Kesesuaian BoQ<br>Telkom dengan Mitra</td>
                                <td><input type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="ok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_boq"></label></td>
                                <td><input type="radio" id="cs_sesuai_boq" name="cs_sesuai_boq" value="nok" autocomplete="off" {{ $pralop->cs_sesuai_boq === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sesuai_boq"></label></td>
                                <td><textarea name="cs_remark_sesuai_boq" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sesuai_boq ? $pralop->cs_remark_sesuai_boq : '' }} </textarea> </td>
                                <td>Perhitungan Profitability</td>
                              </tr>
                              <tr>
                                <td>10</td>
                                <td>Skema Bisnis</td>
                                <td><input type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="ok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'ok' ? " checked " : "" }}>
                                  <label for="cs_skema_bisnis"></label></td>
                                <td><input type="radio" id="cs_skema_bisnis" name="cs_skema_bisnis" value="nok" autocomplete="off" {{ $pralop->cs_skema_bisnis === 'nok' ? " checked " : "" }}>
                                  <label for="cs_skema_bisnis"></label></td>
                                <td><textarea name="cs_remark_skema_bisnis" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_skema_bisnis ? $pralop->cs_remark_skema_bisnis : '' }} </textarea> </td>
                                <td>Jual Beli/Sewa Menyewa<br>/Berlangganan<br>/Managed Service/Lainnya<br>Sesuai PK KB 511.02.02</td>
                              </tr>
                              <tr>
                                <td>11</td>
                                <td>Ruang Lingkup<br>Bisnis</td>
                                <td><input type="radio" id="cs_ruang" name="cs_ruang" value="ok" autocomplete="off" {{ $pralop->cs_ruang === 'ok' ? " checked " : "" }}>
                                  <label for="cs_ruang"></label></td>
                                <td><input type="radio" id="cs_ruang" name="cs_ruang" value="nok" autocomplete="off" {{ $pralop->cs_ruang === 'nok' ? " checked " : "" }}>
                                  <label for="cs_ruang"></label></td>
                                <td><textarea name="cs_remark_ruang" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_ruang ? $pralop->cs_remark_ruang : '' }} </textarea> </td>
                                <td>KAK, SSUK, MoM,<br>Proposal Layanan</td>
                              </tr>
                              <tr>
                                <td>12</td>
                                <td>Kesesuaian SLA/SLG<br>Layanan (Connectivity dan Mitra)</td>
                                <td><input type="radio" id="cs_sla_slg" name="cs_sla_slg" value="ok" autocomplete="off" {{ $pralop->cs_sla_slg === 'ok' ? " checked " : "" }}>
                                  <label for="cs_sla_slg"></label></td>
                                <td><input type="radio" id="cs_sla_slg" name="cs_sla_slg" value="nok" autocomplete="off" {{ $pralop->cs_sla_slg === 'nok' ? " checked " : "" }}>
                                  <label for="cs_sla_slg"></label></td>
                                <td><textarea name="cs_remark_sla_slg" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_sla_slg ? $pralop->cs_remark_sla_slg : '' }} </textarea> </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>13</td>
                                <td>Kesesuaian Layanan<br>KB dan BA Splitting</td>
                                <td><input type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="ok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'ok' ? " checked " : "" }}>
                                  <label for="cs_kb_ba_split"></label></td>
                                <td><input type="radio" id="cs_kb_ba_split" name="cs_kb_ba_split" value="nok" autocomplete="off" {{ $pralop->cs_kb_ba_split === 'nok' ? " checked " : "" }}>
                                  <label for="cs_kb_ba_split"></label></td>
                                <td><textarea name="cs_remark_kb_ba_split" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_kb_ba_split ? $pralop->cs_remark_kb_ba_split : '' }} </textarea> </td>
                                <td>Acuan Splitting</td>
                              </tr>
                              <tr>
                                <td>14</td>
                                <td>Format Kontrak</td>
                                <td><input type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="ok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'ok' ? " checked " : "" }}>
                                  <label for="cs_format_kontrak"></label></td>
                                <td><input type="radio" id="cs_format_kontrak" name="cs_format_kontrak" value="nok" autocomplete="off" {{ $pralop->cs_format_kontrak === 'nok' ? " checked " : "" }}>
                                  <label for="cs_format_kontrak"></label></td>
                                <td><textarea name="cs_remark_format_kontrak" rows="1" cols="15" autocomplete="off"> {{ $pralop->cs_remark_format_kontrak ? $pralop->cs_remark_format_kontrak : '' }} </textarea> </td>
                                <td>KBFL</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <input type="text" name="encrypted" value="{{ $encrypted }}" hidden>
                        <button type="submit" name="submit" value="checklist_solution" class="ms-2 btn btn-sm bg-gradient-primary">SIMPAN CHECKLIST</button>
                      </form>
                    </div>
                  </div>

                  <div class="row mt-2">

                    <div class="card h-75">
                      <div class="card-body p-3">

                        <form class="" action="{{ route('witels.pralop.review_kb') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="text" name="pralop_id" value="{{ $encrypted }}" hidden>

                          <div class="row d-flex align-items-center">
                            <div class="col-4">
                              <h6 class="">UPLOAD ATTACHMENT FILE:</h6>
                            </div>
                          </div>

                          <div class="row d-flex align-items-center">
                            <div class="col d-flex">

                              @if( $errors->has('file_draf_kb') )
                              <button class="btn btn-link px-3 mb-0 mt-2 " type="button" id="btn_clear_draf_kb" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_draf_kb" class="outline-input-merah px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_draf_kb"><span id="label_file_draf_kb">Draf KB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_draf_kb" name="file_draf_kb" type="file" ><p class="text-danger text-sm">*mandatory</p>
                              @else
                              <button class="btn btn-link px-3 mb-0 mt-2 " type="button" id="btn_clear_draf_kb" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_draf_kb" class=" px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_draf_kb"><span id="label_file_draf_kb">Draf KB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_draf_kb" name="file_draf_kb" type="file" >
                              @endif

                              @if( $errors->has('file_rab') )
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_rab" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_rab" class="outline-input-merah px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_rab"><span id="label_file_rab">RAB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_rab" name="file_rab" type="file" ><p class="text-danger text-sm">*mandatory</p>
                              @else
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_rab" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_rab" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_rab"><span id="label_file_rab">RAB</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_rab" name="file_rab" type="file" >
                              @endif

                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex">
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_mom" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_mom" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_mom"><span id="label_file_mom">MOM</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_mom" name="file_mom" type="file">

                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_basplit" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_basplit" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_basplit"><span id="label_file_basplit">BA Splitting</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_basplit" name="file_basplit" type="file">

                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_skk" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_skk" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_skk"><span id="label_file_skk">SKK</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_skk" name="file_skk" type="file">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex">
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_attachment" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_attachment" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_attachment"><span id="label_file_attachment">File Tambahan</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_attachment" name="file_attachment[]" type="file" multiple>
                            </div>
                          </div>

                          <div class="row mt-4">
                            <div class="col">
                              <button type="submit" name="submit" value="review_kb" class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2">Upload Attachment</button>
                            </div>
                          </div>
                        </form>


                      </div>
                    </div>
                    <div class="card h-50 mt-3">
                      <div class="card-body p-2">
                        <h6 class=" ms-2">ATTACHMENT FILES: </h6>

                        <form id="formReviewKB" class="" action="" method="POST" enctype="multipart/form-data">
                          @csrf

                        <div class="row d-flex align-items-center mt-1 mb-1 p-1">
                          <div class="col-md-12">
                          @if( isset($pralop_files) )
                            @if( $pralop_files )
                              @foreach( $pralop_files as $key => $value )
                                <button onclick="downloadKB( {{ $value->id }} )" type="button" class="mt-1 ms-1 btn btn-link bg-gradient-secondary px-3"> <i class="material-icons text-sm">download</i> {{ $value->nama_asli_files }}</button>
                              @endforeach
                            @else
                              <h5 class="text-danger text-xs">[ BELUM ADA FILE ]</h5>
                            @endif
                          @endif
                        </div>
                      </div>

                        </form>

                      </div>
                    </div>

                  </div>




                  @endif
                  <!-- end attachment and checklist -->

                    <div class="row mt-2">
                      <div class="card h-25">
                        <form id="formPraLop" class="" action="{{ route('witels.pralop.detail.update') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="card-header pb-0 p-3">
                              <div class="row">
                                  <div class="col-6 d-flex align-items-center">
                                      <h6 class="mb-0">PRA LOP DETAIL</h6>
                                  </div>
                                  <div class="col-6 text-end">
                                      @if( $user_pralop->role_id === 9 || $user_pralop->role_id === 8 )
                                      <button type="submit" name="submit" value="pralop_detail_{{ $pralop->id }}" class="btn bg-gradient-primary mb-0">SIMPAN</button>
                                      @elseif( $user_pralop->role_id === 4 )
                                      <button type="submit" name="submit" value="pralop_detail_{{ $pralop->id }}" class="btn bg-gradient-primary mb-0">SIMPAN</button>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="card-body p-3">
                              <div class="row">
                                  <div class="col-md-6 ">
                                      <div
                                          class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row overflow-auto">
                                          <table>
                                            <tbody>
                                              <tr>
                                                <td>Nama Projek:&nbsp;</td>
                                                <td>@if( $errors->has('lop_judul_projek') ) <textarea class="outline-input-merah" cols="20" type="text" name="lop_judul_projek"  autocomplete="off">{{ old('lop_judul_projek', $pralop->lop_judul_projek) }}</textarea>  @else <textarea cols="20" type="text" name="lop_judul_projek"  autocomplete="off">{{ old('lop_judul_projek', $pralop->lop_judul_projek) }}</textarea>  @endif</td>
                                              </tr>
                                              <tr>
                                                <td>Nama Pelanggan:&nbsp;</td>
                                                <td>@if( $errors->has('lop_nama_plggn') ) <textarea class="outline-input-merah" cols="20" type="text" name="lop_nama_plggn"  autocomplete="off">{{ old('lop_nama_plggn', $pralop->lop_nama_plggn) }}</textarea>  @else <textarea cols="20" type="text" name="lop_nama_plggn"  autocomplete="off">{{ old('lop_nama_plggn', $pralop->lop_nama_plggn) }}</textarea>  @endif</td>
                                              </tr>
                                              <tr>
                                                <td>Alamat Pelanggan:&nbsp;</td>
                                                <td><textarea cols="20" type="text" name="lop_alamat_plggn"  autocomplete="off">{{ old('lop_alamat_plggn', $pralop->lop_alamat_plggn) }}</textarea> </td>
                                              </tr>
                                              <tr>
                                                <td>PIC Pelanggan:&nbsp;</td>
                                                <td><textarea cols="20" type="text" name="lop_pic_plggn"  autocomplete="off">{{ old('lop_pic_plggn', $pralop->lop_pic_plggn) }}</textarea> </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div
                                          class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row overflow-auto">
                                          <table>
                                            <tbody>
                                              <tr>
                                                <td>ID LOP:&nbsp;</td>
                                                <td><textarea cols="20" rows="1" name="lop_id_mytens"  autocomplete="off"> {{ old('lop_id_mytens', $pralop->lop_id_mytens) }} </textarea> </td>
                                              </tr>
                                              <tr>
                                                <td>Nomor Akun:&nbsp;</td>
                                                <td><textarea cols="20" rows="1" name="lop_nomor_akun"  autocomplete="off"> {{ old('lop_nomor_akun', $pralop->lop_nomor_akun) }} </textarea> </td>
                                              </tr>
                                              <tr>
                                                <td>Estimasi Opportunity:&nbsp;</td>
                                                <td><textarea cols="20" rows="1" name="lop_nilai_kb" id="lop_nilai_kb"  autocomplete="off"> {{ old('lop_nilai_kb', $pralop->lop_nilai_kb) }} </textarea> </td>
                                              </tr>
                                              <tr>
                                                <td>Segmen:&nbsp;</td>
                                                <td><select name="lop_segmen" id="lop_segmen" autocomplete="off">
                                                    <option value="" disabled selected>Pilih Segmen</option>
                                                    <option value="DES" {{ old('lop_segmen', $pralop->lop_segmen) == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                                                    <option value="DGS" {{ old('lop_segmen', $pralop->lop_segmen) == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                                                    <option value="DBS" {{ old('lop_segmen', $pralop->lop_segmen) == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                                                </select> </td>
                                              </tr>
                                              <tr>
                                                <td>Skema Bayar<br>ke Pelanggan:&nbsp;</td>
                                                <td><select name="lop_skema_bayar" id="lop_skema_bayar" autocomplete="off">
                                                    <option value="" disabled selected>Pilih Skema</option>
                                                    <option value="otc" {{ old('lop_skema_bayar', $pralop->lop_skema_bayar) == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                                    <option value="recurring" {{ old('lop_skema_bayar', $pralop->lop_skema_bayar) == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                                    <option value="termin" {{ old('lop_skema_bayar', $pralop->lop_skema_bayar) == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                                    <option value="otc_recurring" {{ old('lop_skema_bayar', $pralop->lop_skema_bayar) == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
                                                </select> </td>
                                              </tr>
                                              <tr>
                                                <td>Status Order:&nbsp;</td>
                                                <td><select name="lop_status_order" id="lop_status_order" autocomplete="off" style="width:80%;">
                                                    <option value="" disabled selected>Pilih Status</option>
                                                    <option value="inprogress_provision_issued" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_provision_issued' ? ' selected="selected"' : '' }}>In Progress - Provision Issued</option>
                                                    <option value="inprogress_provision_start" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_provision_start' ? ' selected="selected"' : '' }}>In Progress - Provision Start</option>
                                                    <option value="inprogress_provision_failed" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_provision_failed' ? ' selected="selected"' : '' }}>In Progress - Provision Failed</option>
                                                    <option value="inprogress_provision_complete" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_provision_complete' ? ' selected="selected"' : '' }}>In Progress - Provision Complete</option>
                                                    <option value="inprogress_pending_billing" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_pending_billing' ? ' selected="selected"' : '' }}>In Progress - Pending Billing</option>
                                                    <option value="inprogress_tsq_start" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_tsq_start' ? ' selected="selected"' : '' }}>In Progress - TSQ Start</option>
                                                    <option value="inprogress_provision_designed" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_provision_designed' ? ' selected="selected"' : '' }}>In Progress - Provision Designed</option>
                                                    <option value="approval" {{ old('lop_status_order', $pralop->lop_status_order) == 'approval' ? ' selected="selected"' : '' }}>Approval</option>
                                                    <option value="submit" {{ old('lop_status_order', $pralop->lop_status_order) == 'submit' ? ' selected="selected"' : '' }}>Submit</option>
                                                    <option value="failed_provision_failed" {{ old('lop_status_order', $pralop->lop_status_order) == 'failed_provision_failed' ? ' selected="selected"' : '' }}>Failed - Provision Failed</option>
                                                    <option value="inprogress_fullfill_billing_start" {{ old('lop_status_order', $pralop->lop_status_order) == 'inprogress_fullfill_billing_start' ? ' selected="selected"' : '' }}>In Progress - Fullfill Billing Start</option>
                                                    <option value="pending_baso" {{ old('lop_status_order', $pralop->lop_status_order) == 'pending_baso' ? ' selected="selected"' : '' }}>Pending BASO</option>
                                                    <option value="failed_fullfill_billing_failed" {{ old('lop_status_order', $pralop->lop_status_order) == 'failed_fullfill_billing_failed' ? ' selected="selected"' : '' }}>Failed - Fullfill Billing Failed</option>
                                                    <option value="fullfill_billing_complete" {{ old('lop_status_order', $pralop->lop_status_order) == 'fullfill_billing_complete' ? ' selected="selected"' : '' }}>Fullfill Billing Complete</option>
                                                    <option value="abandoned" {{ old('lop_status_order', $pralop->lop_status_order) == 'abandoned' ? ' selected="selected"' : '' }}>Abandoned</option>
                                                    <option value="pending_cancel" {{ old('lop_status_order', $pralop->lop_status_order) == 'pending_cancel' ? ' selected="selected"' : '' }}>Pending Cancel</option>
                                                    <option value="complete" {{ old('lop_status_order', $pralop->lop_status_order) == 'complete' ? ' selected="selected"' : '' }}>Complete</option>
                                                    <option value="cancel" {{ old('lop_status_order', $pralop->lop_status_order) == 'cancel' ? ' selected="selected"' : '' }}>Cancel</option>
                                                    <option value="belum_input" {{ old('lop_status_order', $pralop->lop_status_order) == 'cancel' ? ' selected="selected"' : '' }}>Belum Input</option>
                                                </select> </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <br>
                    <!-- Sub Layanan -->
                    <div class="row">
                      <div class="card h-100">
                        <form id="formSubLayanan" class="" action="" method="POST" enctype="multipart/form-data">
                          @csrf

                          <div class="card-header pb-0 px-3">
                            <div class="row">
                              <div class="col-6 d-flex align-items-center">
                                  <h6 class="mb-0">LAYANAN</h6>
                              </div>
                              <div class="col ms-auto text-end float-right">
                                @if( isset($layanan) )
                                  @if( $layanan )

                                    @if( $user_pralop->role_id === 13 )
                                    @else
                                    <button type="button" class="btn btn-link bg-gradient-warning px-3 mb-0 mt-2" onclick="printLayanan({{ $pralop->id ? $pralop->id : '' }})">Print P1/P0</button>
                                    @endif

                                    @if( $layanan[0]->file_p1 )
                                    <button type="button" class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan({{ $pralop->id ? $pralop->id : '' }})">Download P1/P0</button><br>
                                    @else
                                    <button disabled type="button" class="btn bg-gradient-secondary px-3 mb-0 mt-2" >Download P1/P0</button><br>
                                    @endif

                                  @endif
                                @endif
                              </div>

                            </div>
                          </div>
                          <div class="card-body pt-4 p-3">
                              <ul class="list-group">
                                  @if( isset($layanan) )
                                    @if( $layanan )
                                        @foreach( $layanan as $key => $value )
                                          <li class="list-group-item border-0 d-flex p-3 mb-2 bg-gray-100 border-radius-lg">
                                              <div class="d-flex flex-column">
                                                  <h6 class="mb-3 text-sm">{{ $value->f1_judul_projek ? $value->f1_judul_projek : '-' }}</h6>
                                                  <span class="mb-2 text-xs">Nama Mitra: <span
                                                          class="text-dark font-weight-bold ms-sm-2">{{ $value->f1_mitra_id ? $value->f1_mitra_id : 'Belum Ada Input' }}</span></span>
                                                  <span class="mb-2 text-xs">Nama Folder: <span
                                                          class="text-dark ms-sm-2 font-weight-bold">{{ $value->f1_folder ? $value->f1_folder : 'Kosong' }}</span></span>
                                                  <span class="mb-2 text-xs">Nomor P1: <span
                                                          class="text-dark ms-sm-2 font-weight-bold">{{ $value->p1_nomor_p1 ? $value->p1_nomor_p1 : 'Belum Ada Input' }}</span></span>
                                                  @if( $value->p0_nomor_p0 )
                                                  <span class="mb-2 text-xs">Nomor P0: <span
                                                          class="text-dark ms-sm-2 font-weight-bold">{{ $value->p0_nomor_p0 ? $value->p0_nomor_p0 : 'Belum Ada Input' }}</span></span>
                                                  @endif
                                                  <span class="mb-2 text-xs">Total Nilai (P1): <span
                                                          class="text-dark ms-sm-2 font-weight-bold">{{ $value->p1_estimasi_harga ? $value->p1_estimasi_harga : 'Belum Ada Input' }}</span></span>
                                                  <span class="mb-2 text-xs">Saat Penggunaan (P1): <span
                                                          class="text-dark ms-sm-2 font-weight-bold">{{ $value->tgl_delivery_p1 ? \Carbon\Carbon::parse($value->tgl_delivery_p1)->translatedFormat('d F Y') : 'Belum Ada Input' }}</span></span>
                                              </div>

                                              @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 9 || $user_pralop->role_id === 8 )
                                              <div class="ms-auto text-end float-right">
                                                  <input name="encrypted[]" value="{{ $encrypted }}" hidden>
                                                  <button type="button" class="btn btn-link bg-gradient-primary px-3 mb-0" onclick="editLayanan( {{ $value->id ? $value->id : '' }} )">Edit</button>
                                                  <button type="button" class="btn btn-link bg-gradient-danger px-3 mb-0" onclick="deleteLayanan( {{ $value->id ? $value->id : '' }} )">Delete</button><br>

                                                  <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p1_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                  <label for="file_p1_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p1_{{ $value->id }}"><span id="label_file_p1_{{ $value->id }}">Pilih File P1</span></label>
                                                  <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p1_{{ $value->id }}" name="file_p1_{{ $value->id }}" type="file">

                                                  <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Upload</button><br>
                                                  @if( $value->p0_nomor_p0 )

                                                    <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p0_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                    <label for="file_p0_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p0_{{ $value->id }}"><span id="label_file_p0_{{ $value->id }}">Pilih File P0</span></label>
                                                    <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p0_{{ $value->id }}" name="file_p0_{{ $value->id }}" type="file">

                                                    <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Upload</button>
                                                  @endif

                                              </div>
                                              @elseif( $user_pralop->role_id === 13 )
                                              <div class="ms-auto text-end float-right">
                                                  <input name="encrypted[]" value="{{ $encrypted }}" hidden>
                                                  <button type="button" class="btn btn-link bg-gradient-primary px-3 mb-0" onclick="editLayanan( {{ $value->id ? $value->id : '' }} )">Edit</button><br>

                                              </div>
                                              @endif

                                          </li>
                                        @endforeach
                                    @else
                                      <h5 class="text-danger text-xs">[ BELUM ADA LAYANAN ]</h5>
                                    @endif
                                  @endif

                              </ul>
                          </div>

                        </form>
                      </div>
                    </div><br>
                    <!-- End Sub Layanan -->

                    <!-- Tambah Layanan -->
                    @if( $user_pralop->role_id === 4 )
                    <div class="row">
                      <div class="card h-100">
                        <form id="formLayanan" action="" method="POST" enctype="multipart/form-data">
                          @csrf

                          <div class="card-header pb-0 px-3">
                            <div class="row">
                              <div class="col-6 d-flex align-items-center">
                                  <h6 class="mb-0">TAMBAH LAYANAN</h6>
                              </div>
                                <div class="col-6 text-end">
                                    <button onclick="simpanLayanan( {{ $pralop->id ? $pralop->id : '' }} )" name="submit" value="pralop_detail_layanan" class="btn bg-gradient-primary mb-0">SIMPAN LAYANAN</button>
                                </div>

                            </div>
                          </div>
                          <div class="card-body pt-4 p-3">
                              <ul class="list-group">
                                    <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg">
                                      <div class="table-responsive col col-lg-12">
                                          <table class="table" id="table_layanan">
                                              <thead>
                                                  <tr>
                                                      <th scope="col"></th>
                                                      <th scope="col">#</th>
                                                      <th scope="col">Layanan</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                          </table>
                                      </div>
                                      <br>
                                      <button type="button" class="btn bg-gradient-info" id="insertRow"><i class="fa fa-plus-square"></i></button>
                                    </li>
                              </ul>
                          </div>

                        </form>
                      </div>
                    </div>
                    @endif
                    <!-- End Tambah Layanan -->

                </div>
                <div class="col-lg-4">
                  <div class="card vh-100 mb-4 overflow-auto mt-6">
                      <div class="card-header pb-0 px-3">
                          <div class="row">
                              <div class="col-md-6">
                                  <h6 class="mb-0">LOG HISTORI</h6>
                              </div>
                          </div>
                      </div>
                      <div class="card-body pt-4 p-3">
                          <ul class="list-group">

                            <li
                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column">
                                      <form class="" action="{{ route('witels.pralop.detail.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center">
                                            @if( $errors->has('lop_keterangan') )
                                            <textarea class="outline-input-merah" name="lop_keterangan" rows="5" cols="50" placeholder="INPUT KETERANGAN" autocomplete="off">{{ old('lop_keterangan') }}</textarea>
                                            @else
                                            <textarea name="lop_keterangan" rows="5" cols="30" placeholder="INPUT KETERANGAN" autocomplete="off">{{ old('lop_keterangan') }}</textarea>
                                            @endif
                                        </div>
                                        <div class="row mt-1">
                                          <div class="col-md-8 ">
                                            <button type="submit" class="btn btn-sm bg-gradient-primary" name="submit" value="lop_keterangan_{{ $pralop->id }}">SIMPAN KETERANGAN</button>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                </div>

                            </li>
                            <li class="">
                              <hr>
                            </li>

                            @if( isset($arr_log_histori) )
                              @if( $arr_log_histori )
                                @foreach( $arr_log_histori as $key => $value )
                                  @if( $value['tgl_keterangan'] )

                                      @if( $value['role_id'] === 8 || $value['role_id'] === 9 )
                                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-success" role="alert">
                                          <div class="d-flex align-items-center p-1 m-1">
                                              <div class="d-flex flex-column">
                                                  <div class="d-flex align-items-center text-white text-sm font-weight-bold">
                                                      {{ $value['keterangan'] }}
                                                  </div>
                                                  <div class="d-flex align-items-center text-white text-sm font-weight-bold">
                                                      <h6 class="d-flex align-items-center text-white text-sm mt-2">
                                                        <i class="material-icons text-sm">person</i> {{ $value['user_update'] }}

                                                        <i class="material-icons text-sm ps-2">schedule</i> {{ \Carbon\Carbon::parse($value['tgl_keterangan'])->translatedFormat('l, d F Y') }}</h6>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                      @elseif( $value['role_id'] === 4 )
                                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-primary" role="alert">
                                          <div class="d-flex align-items-center p-1 m-1">
                                              <div class="d-flex flex-column ">
                                                  <div class="d-flex align-items-center text-white text-xs font-weight-bold">
                                                      {{ $value['keterangan'] }}
                                                  </div>
                                                  <div class="d-flex align-items-center text-white  text-xs font-weight-bold">
                                                      <h6 class="d-flex align-items-center text-white text-xs mt-2">
                                                        <i class="material-icons text-xs ">person</i> {{ $value['user_update'] }}

                                                        <i class="material-icons text-xs ps-2  ">schedule</i> {{ \Carbon\Carbon::parse($value['tgl_keterangan'])->translatedFormat('l, d F Y') }}</h6>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                      @elseif( $value['role_id'] === 13 )
                                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-warning" role="alert">
                                          <div class="d-flex align-items-center p-1 m-1">
                                              <div class="d-flex flex-column ">
                                                  <div class="d-flex align-items-center text-white  text-xs font-weight-bold">
                                                      {{ $value['keterangan'] }}
                                                  </div>
                                                  <div class="d-flex align-items-center text-white  text-xs font-weight-bold">
                                                      <h6 class="d-flex align-items-center text-white  text-xs mt-2">
                                                        <i class="material-icons text-xs ">person</i> {{ $value['user_update'] }}

                                                        <i class="material-icons text-xs ps-2  ">schedule</i> {{ \Carbon\Carbon::parse($value['tgl_keterangan'])->translatedFormat('l, d F Y') }}</h6>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                      @endif

                                  @endif
                                @endforeach
                              @else
                                  <li
                                      class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-light">
                                      <div class="d-flex align-items-center p-3">
                                          <div class="d-flex flex-column">
                                              <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                                  <h6 class="mb-1 text-dark text-sm">[ BELUM ADA KETERANGAN ]</h6>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                              @endif
                            @endif

                          </ul>
                      </div>
                  </div>


                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mt-4">

                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    @push('js')

    @if( $user_pralop->role_id === 4 )
    <script type="text/javascript">

    function downloadKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_download")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    // button & input file attachment
    $('#file_draf_kb' ).val('');
    $('#label_file_draf_kb' ).empty(); $('#label_file_draf_kb' ).append(`Draf KB`);

    $('#btn_clear_draf_kb' ).on('click', function() {
      $('#file_draf_kb' ).val('');
      $('#label_file_draf_kb' ).empty(); $('#label_file_draf_kb' ).append(`Draf KB`);
      $('.label_draf_kb' ).removeClass('bg-gradient-secondary'); $('.label_draf_kb' ).addClass('bg-gradient-light');
    });
    $('#file_draf_kb' ).change(function() {
        $('.label_draf_kb' ).removeClass('bg-gradient-light');
        $('#label_file_draf_kb' ).empty();
        $('#label_file_draf_kb' ).append( this.files[0].name );
        $('.label_draf_kb' ).addClass('bg-gradient-secondary');
    });

    $('#file_rab' ).val('');
    $('#label_file_rab' ).empty(); $('#label_file_rab' ).append(`RAB`);

    $('#btn_clear_rab' ).on('click', function() {
      $('#file_rab' ).val('');
      $('#label_file_rab' ).empty(); $('#label_file_rab' ).append(`RAB`);
      $('.label_rab' ).removeClass('bg-gradient-secondary'); $('.label_rab' ).addClass('bg-gradient-light');
    });
    $('#file_rab' ).change(function() {
        $('.label_rab' ).removeClass('bg-gradient-light');
        $('#label_file_rab' ).empty();
        $('#label_file_rab' ).append( this.files[0].name );
        $('.label_rab' ).addClass('bg-gradient-secondary');
    });

    $('#file_mom' ).val('');
    $('#label_file_mom' ).empty(); $('#label_file_mom' ).append(`MOM`);

    $('#btn_clear_mom' ).on('click', function() {
      $('#file_mom' ).val('');
      $('#label_file_mom' ).empty(); $('#label_file_mom' ).append(`MOM`);
      $('.label_mom' ).removeClass('bg-gradient-secondary'); $('.label_mom' ).addClass('bg-gradient-light');
    });
    $('#file_mom' ).change(function() {
        $('.label_mom' ).removeClass('bg-gradient-light');
        $('#label_file_mom' ).empty();
        $('#label_file_mom' ).append( this.files[0].name );
        $('.label_mom' ).addClass('bg-gradient-secondary');
    });

    $('#file_basplit' ).val('');
    $('#label_file_basplit' ).empty(); $('#label_file_basplit' ).append(`BA Splitting`);

    $('#btn_clear_basplit' ).on('click', function() {
      $('#file_basplit' ).val('');
      $('#label_file_basplit' ).empty(); $('#label_file_basplit' ).append(`BA Splitting`);
      $('.label_basplit' ).removeClass('bg-gradient-secondary'); $('.label_basplit' ).addClass('bg-gradient-light');
    });
    $('#file_basplit' ).change(function() {
        $('.label_basplit' ).removeClass('bg-gradient-light');
        $('#label_file_basplit' ).empty();
        $('#label_file_basplit' ).append( this.files[0].name );
        $('.label_basplit' ).addClass('bg-gradient-secondary');
    });

    $('#file_skk' ).val('');
    $('#label_file_skk' ).empty(); $('#label_file_skk' ).append(`SKK`);

    $('#btn_clear_skk' ).on('click', function() {
      $('#file_skk' ).val('');
      $('#label_file_skk' ).empty(); $('#label_file_skk' ).append(`SKK`);
      $('.label_skk' ).removeClass('bg-gradient-secondary'); $('.label_skk' ).addClass('bg-gradient-light');
    });
    $('#file_skk' ).change(function() {
        $('.label_skk' ).removeClass('bg-gradient-light');
        $('#label_file_skk' ).empty();
        $('#label_file_skk' ).append( this.files[0].name );
        $('.label_skk' ).addClass('bg-gradient-secondary');
    });

    $('#file_attachment' ).val('');
    $('#label_file_attachment' ).empty(); $('#label_file_attachment' ).append(`File Tambahan`);

    $('#btn_clear_attachment' ).on('click', function() {
      $('#file_attachment' ).val('');
      $('#label_file_attachment' ).empty(); $('#label_file_attachment' ).append(`File Tambahan`);
      $('.label_attachment' ).removeClass('bg-gradient-secondary'); $('.label_attachment' ).addClass('bg-gradient-light');
    });
    $('#file_attachment' ).change(function() {
        let measure = 0;
        let hasil = "";
        if(this.files.length > 1){ measure = this.files.length;  hasil = measure + " files selected"; }
        if(this.files.length === 1){ hasil = this.files[0].name; }
        $('.label_attachment' ).removeClass('bg-gradient-light');
        $('#label_file_attachment' ).empty();
        $('#label_file_attachment' ).append(hasil);
        $('.label_attachment' ).addClass('bg-gradient-secondary');
    });
    // end button & input file attachment

    </script>
    @elseif( $user_pralop->role_id === 8 )
    <script type="text/javascript">
    function previewKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_preview")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    function downloadKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_download")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    </script>
    @elseif( $user_pralop->role_id === 13 )
    <script type="text/javascript">
    function previewKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_preview")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    function downloadKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_download")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    </script>
    @elseif( $user_pralop->role_id === 9 )
    <script type="text/javascript">

    function previewKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_preview")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    function downloadKB(var_pralop_files){
      $('#formReviewKB').attr('action', "");
      $("<input />").attr("type", "hidden")
        .attr("name", "file_download")
        .attr("value", var_pralop_files )
        .appendTo("#formReviewKB");
      $('#formReviewKB').attr('action', "{{ route('witels.pralop.review_kb.files') }}").submit();
    }

    $('#file_attachment' ).val('');
    $('#label_file_attachment' ).empty(); $('#label_file_attachment' ).append(`Attachment (Multi Files)`);

    $('#btn_clear_attachment' ).on('click', function() {
      $('#file_attachment' ).val('');
      $('#label_file_attachment' ).empty(); $('#label_file_attachment' ).append(`Attachment (Multi Files)`);
      $('.label_attachment' ).removeClass('bg-gradient-secondary'); $('.label_attachment' ).addClass('bg-gradient-light');
    });
    $('#file_attachment' ).change(function() {
        let measure = 0;
        let hasil = "";
        if(this.files.length > 1){ measure = this.files.length;  hasil = measure + " files selected"; }
        if(this.files.length === 1){ hasil = this.files[0].name; }
        $('.label_attachment' ).removeClass('bg-gradient-light');
        $('#label_file_attachment' ).empty();
        $('#label_file_attachment' ).append(hasil);
        $('.label_attachment' ).addClass('bg-gradient-secondary');
    });

    </script>
    @endif

    @if( isset($layanan) )
      @if( $layanan )
      <script type="text/javascript">
      var global_arr_index = [];
      </script>
          @foreach( $layanan as $key => $value )
          <script type="text/javascript">
            global_arr_index.push( '{{ $value->id }}' );
          </script>
          @endforeach

          <script type="text/javascript">
          $.each(global_arr_index,function(index,value){
            $('#file_p1_' + value ).val('');
            $('#label_file_p1_' + value ).empty(); $('#label_file_p1_' + value ).append(`Pilih File P1`);

            $('#btn_clear_p1_' + value ).on('click', function() {
              $('#file_p1_' + value ).val('');
              $('#label_file_p1_' + value ).empty(); $('#label_file_p1_' + value ).append(`Pilih File P1`);
              $('.label_p1_' + value ).removeClass('bg-gradient-secondary'); $('.label_p1_' + value ).addClass('bg-gradient-light');
            });
            $('#file_p1_' + value ).change(function() {
                $('.label_p1_' + value ).removeClass('bg-gradient-light');
                $('#label_file_p1_' + value ).empty();
                $('#label_file_p1_' + value ).append(this.files[0].name);
                $('.label_p1_' + value ).addClass('bg-gradient-secondary');
            });

            $('#file_p0_' + value ).val('');
            $('#label_file_p0_' + value ).empty(); $('#label_file_p0_' + value ).append(`Pilih File P0`);

            $('#btn_clear_p0_' + value ).on('click', function() {
              $('#file_p0_' + value ).val('');
              $('#label_file_p0_' + value ).empty(); $('#label_file_p0_' + value ).append(`Pilih File P0`);
              $('.label_p0_' + value ).removeClass('bg-gradient-secondary'); $('.label_p0_' + value ).addClass('bg-gradient-light');
            });
            $('#file_p0_' + value ).change(function() {
                $('.label_p0_' + value ).removeClass('bg-gradient-light');
                $('#label_file_p0_' + value ).empty();
                $('#label_file_p0_' + value ).append(this.files[0].name);
                $('.label_p0_' + value ).addClass('bg-gradient-secondary');
            });
          });
          </script>
      @endif
    @endif

    <script>
      function simpanLayanan(simpan_layanan_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "simpan_layanan_id")
          .attr("value", simpan_layanan_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.update') }}").submit();
      }



      function downloadLayanan(var_file){
        $('#formSubLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_download")
          .attr("value", var_file )
          .appendTo("#formSubLayanan");
        $('#formSubLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.download') }}").submit();
      }

      function uploadLayanan(var_file,var_obl_id){
        $('#formSubLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_upload")
          .attr("value", var_file + "_" + var_obl_id )
          .appendTo("#formSubLayanan");
        $('#formSubLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.upload') }}").submit();
      }

      function printLayanan(var_file){
        $('#formSubLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_print")
          .attr("value", var_file )
          .appendTo("#formSubLayanan");
        $('#formSubLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.print') }}").submit();
      }

      function editLayanan(forms_obl_id){
        $('#formSubLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "forms_obl_id")
          .attr("value", forms_obl_id )
          .appendTo("#formSubLayanan");
        $('#formSubLayanan').attr('action', "{{ route('witels.forms') }}").submit();
      }


      $("#modal-status-table-obl-delete").modal({show:false});
      function deleteLayanan(delete_id){
          if(delete_id && typeof delete_id !== undefined){
            $('#modal-pilihan-table-obl-hapus').empty();
              $('#modal-pilihan-table-obl-hapus').append(`
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TIDAK</button>
                <button type="submit" name="obl_doc_action" value="delete_`+delete_id+`" class="btn btn-danger">HAPUS</button>
              `);
              $('#modal-status-table-obl-delete').modal('show');
          }
      }

        $( document ).ready(function() {

            $("#modal-input-obl").modal({show:false});
            var session_status = "{{ session('status') }}";

            if(session_status && typeof session_status !== undefined){
              $('#status-input-obl').empty();
              if(session_status.includes('Sukses')){
                $('#status-input-obl').append(`
                  <div class="alert alert-success alert-dismissible">
                      <div class="text-center">
                          <h5 class="text-white">`+session_status+`</h5>
                      </div>
                  </div>
                `);
                $('#modal-input-obl').modal('show');
              }
              else if(session_status.includes('Oops')){
                $('#status-input-obl').append(`
                  <div class="alert alert-danger alert-dismissible">
                      <div class="text-center">
                          <h5 class="text-white">`+session_status+`</h5>
                      </div>
                  </div>
                `);
                $('#modal-input-obl').modal('show');
              }
              else{
                $('#status-input-obl').append(`
                  <div class="alert alert-warning alert-dismissible">
                      <div class="text-center">
                          <h5 class="text-white">`+session_status+`</h5>
                      </div>
                  </div>
                `);
                $('#modal-input-obl').modal('show');
              }
            }

            // STARTLINE: FORMAT RUPIAH
            var rupiah = document.getElementById('lop_nilai_kb');
            rupiah.addEventListener('keyup', function(e){
                rupiah.value = formatRupiah(this.value, 'Rp. ');
            });

            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
            // ENDLINE: FORMAT RUPIAH

            // Start dd rows table
            var counter = 1;
            $("#insertRow").on("click", function (event) {
                event.preventDefault();
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><button type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>';
                cols += '<th scrope="row">' + counter + '</th>';
                cols += '<td><input style="width:100%" type="text" name="f1_judul_projek[]" placeholder="Input Layanan" autocomplete="off"></td>';
                newRow.append(cols);
                $("#table_layanan").append(newRow);
                counter++;
            });
            $("#table_layanan").on("click", "#deleteRow", function (event) {
                $(this).closest("tr").remove();
                counter -= 1
            });
            // end add rows table

        });

    </script>
    @endpush

</x-layout>
