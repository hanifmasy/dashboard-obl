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
        <!-- end modal alerts -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8">
                  <div class="row">
                      <div class="col-md-12 ms-2 d-flex align-items-center">
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
                            <button type="submit" name="submit_verifikasi" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-info text-white" >LANJUT VERIFIKASI</button>
                            <button type="submit" name="submit_witel" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE WITEL</button>
                            <button type="submit" name="submit_legal" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-warning text-white" >LANJUT KE LEGAL</button>
                            <button type="submit" name="submit_solution" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-secondary text-white" >KEMBALI KE SOLUTION</button>
                            <button type="submit" name="submit_final" value="{{ $encrypted }}" role="button" class="ms-2 btn btn-md bg-gradient-danger text-white" >FINAL VERIFIKASI</button>
                            @endif
                          @endif
                        </form>

                      </div>
                  </div>

                  <!-- start attachment and checklist -->
                  @if( $user_pralop->role_id === 4 && $pralop->lop_review_kb === true )
                  <div class="row mt-2">
                    <div class="card h-50">
                      <div class="card-body p-3">

                        <form class="" action="{{ route('witels.pralop.review_kb') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="row d-flex align-items-center">
                            Attachment File KB dan lainnya:
                            <div class="col d-flex">
                              <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_attachment" ><i class="material-icons opacity-7">backspace</i></button>
                              <label for="file_attachment" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_attachment"><span id="label_file_attachment">Attachment (Multi files)</span></label>
                              <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_attachment" name="file_attachment[]" type="file" multiple>

                              <button type="submit" name="submit" value="review_kb" class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2">Upload</button>
                            </div>
                          </div>
                        </form>


                      </div>
                    </div>
                  </div>
                  @elseif( $user_pralop->role_id === 8 && $pralop->lop_review_kb === true)
                  <div class="row mt-2">
                    <div class="card h-25">
                      TEST.
                    </div>
                  </div>
                  @elseif( $user_pralop->role_id === 13 && $pralop->lop_review_kb === true)
                  <div class="row mt-2">
                    <div class="card h-25">
                      TEST.
                    </div>
                  </div>
                  @elseif( $user_pralop->role_id === 9 )
                  <div class="row mt-2">
                    <div class="card h-25">
                      TEST.
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
                                      @elseif( $user_pralop->role_id === 4 && $pralop->lop_review_kb === false )
                                      <button type="submit" name="submit" value="pralop_detail_{{ $pralop->id }}" class="btn bg-gradient-primary mb-0">SIMPAN</button>
                                      @elseif( $user_pralop->role_id === 4 && $pralop->lop_review_kb === true )
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
                                                <td>@if( $errors->has('lop_judul_projek') ) <textarea class="outline-input-merah" cols="35" type="text" name="lop_judul_projek"  autocomplete="off">{{ old('lop_judul_projek', $pralop->lop_judul_projek) }}</textarea>  @else <textarea cols="35" type="text" name="lop_judul_projek"  autocomplete="off">{{ old('lop_judul_projek', $pralop->lop_judul_projek) }}</textarea>  @endif</td>
                                              </tr>
                                              <tr>
                                                <td>Nama Pelanggan:&nbsp;</td>
                                                <td>@if( $errors->has('lop_nama_plggn') ) <textarea class="outline-input-merah" cols="35" type="text" name="lop_nama_plggn"  autocomplete="off">{{ old('lop_nama_plggn', $pralop->lop_nama_plggn) }}</textarea>  @else <textarea cols="35" type="text" name="lop_nama_plggn"  autocomplete="off">{{ old('lop_nama_plggn', $pralop->lop_nama_plggn) }}</textarea>  @endif</td>
                                              </tr>
                                              <tr>
                                                <td>Alamat Pelanggan:&nbsp;</td>
                                                <td><textarea cols="35" type="text" name="lop_alamat_plggn"  autocomplete="off">{{ old('lop_alamat_plggn', $pralop->lop_alamat_plggn) }}</textarea> </td>
                                              </tr>
                                              <tr>
                                                <td>PIC Pelanggan:&nbsp;</td>
                                                <td><textarea cols="35" type="text" name="lop_pic_plggn"  autocomplete="off">{{ old('lop_pic_plggn', $pralop->lop_pic_plggn) }}</textarea> </td>
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
                                                <td><input style="width:100%;" type="text" name="lop_id_mytens" value="{{ old('lop_id_mytens', $pralop->lop_id_mytens) }}" autocomplete="off"> </td>
                                              </tr>
                                              <tr>
                                                <td>Nomor Akun:&nbsp;</td>
                                                <td><input  style="width:100%;" type="text" name="lop_nomor_akun" value="{{ old('lop_nomor_akun', $pralop->lop_nomor_akun) }}" autocomplete="off"> </td>
                                              </tr>
                                              <tr>
                                                <td>Estimasi Opportunity:&nbsp;</td>
                                                <td><input  style="width:100%;" type="text" name="lop_nilai_kb" id="lop_nilai_kb" value="{{ old('lop_nilai_kb', $pralop->lop_nilai_kb) }}" autocomplete="off"> </td>
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
                                                <td><select name="lop_status_order" id="lop_status_order" autocomplete="off">
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
                    <div class="row">
                      <div class="card h-100">
                        <form id="formLayanan" action="" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="card-header pb-0 px-3">
                            <div class="row">
                              <div class="col-6 d-flex align-items-center">
                                  <h6 class="mb-0">LAYANAN</h6>
                              </div>
                              @if( isset($layanan) )
                                @if( $layanan )
                                @else
                                <div class="col-6 text-end">
                                    <button onclick="simpanLayanan( {{ $pralop->id ? $pralop->id : '' }} )" name="submit" value="pralop_detail_layanan" class="btn bg-gradient-primary mb-0">SIMPAN LAYANAN</button>
                                </div>
                                @endif
                              @endif

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

                                              @if( $user_pralop->role_id === 4 && $pralop->lop_review_kb === false )
                                              <div class="ms-auto text-end float-right">
                                                  <input name="encrypted[]" value="{{ $encrypted }}" hidden>
                                                  <button class="btn btn-link bg-gradient-primary px-3 mb-0" onclick="editLayanan( {{ $value->id ? $value->id : '' }} )">Edit</button><br>
                                                  @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )
                                                      <button class="btn btn-link bg-gradient-warning px-3 mb-0 mt-2" onclick="printLayanan('p1', {{ $value->id ? $value->id : '' }} )">Print P1</button>
                                                      @if( $value->p0_nomor_p0 )
                                                      <button class="btn btn-link bg-gradient-warning px-3 mb-0 mt-2" onclick="printLayanan('p0', {{ $value->id ? $value->id : '' }} )">Print P0</button><br>
                                                      @else
                                                      <br>
                                                      @endif
                                                  @endif
                                                  @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )

                                                  <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p1_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                  <label for="file_p1_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p1_{{ $value->id }}"><span id="label_file_p1_{{ $value->id }}">Pilih File P1</span></label>
                                                  <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p1_{{ $value->id }}" name="file_p1_{{ $value->id }}" type="file">

                                                  <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Upload</button>
                                                      @if( $value->file_p1 )
                                                      <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                      @else
                                                      <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                      @endif
                                                  @else
                                                      @if( $value->file_p1 )
                                                      <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Download P1</button><br>
                                                      @else
                                                      <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Download P1</button><br>
                                                      @endif
                                                  @endif
                                                  @if( $value->p0_nomor_p0 )
                                                    @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )

                                                    <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p0_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                    <label for="file_p0_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p0_{{ $value->id }}"><span id="label_file_p0_{{ $value->id }}">Pilih File P0</span></label>
                                                    <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p0_{{ $value->id }}" name="file_p0_{{ $value->id }}" type="file">

                                                    <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Upload</button>
                                                        @if( $value->file_p0 )
                                                        <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                        @else
                                                        <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                        @endif
                                                    @else
                                                        @if( $value->file_p0 )
                                                        <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Download P0</button><br>
                                                        @else
                                                        <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Download P0</button><br>
                                                        @endif
                                                    @endif
                                                  @endif

                                              </div>
                                              @elseif( $user_pralop->role_id === 4 && $pralop->lop_review_kb === true )
                                              @elseif( $user_pralop->role_id === 9 || $user_pralop->role_id === 8 || $user_pralop->role_id === 13 )
                                              <div class="ms-auto text-end float-right">
                                                  <input name="encrypted[]" value="{{ $encrypted }}" hidden>
                                                  <button class="btn btn-link bg-gradient-primary px-3 mb-0" onclick="editLayanan( {{ $value->id ? $value->id : '' }} )">Edit</button><br>
                                                  @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )
                                                      <button class="btn btn-link bg-gradient-warning px-3 mb-0 mt-2" onclick="printLayanan('p1', {{ $value->id ? $value->id : '' }} )">Print P1</button>
                                                      @if( $value->p0_nomor_p0 )
                                                      <button class="btn btn-link bg-gradient-warning px-3 mb-0 mt-2" onclick="printLayanan('p0', {{ $value->id ? $value->id : '' }} )">Print P0</button><br>
                                                      @else
                                                      <br>
                                                      @endif
                                                  @endif
                                                  @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )

                                                  <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p1_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                  <label for="file_p1_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p1_{{ $value->id }}"><span id="label_file_p1_{{ $value->id }}">Pilih File P1</span></label>
                                                  <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p1_{{ $value->id }}" name="file_p1_{{ $value->id }}" type="file">

                                                  <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Upload</button>
                                                      @if( $value->file_p1 )
                                                      <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                      @else
                                                      <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                      @endif
                                                  @else
                                                      @if( $value->file_p1 )
                                                      <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Download P1</button><br>
                                                      @else
                                                      <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p1', {{ $value->id ? $value->id : '' }} )">Download P1</button><br>
                                                      @endif
                                                  @endif
                                                  @if( $value->p0_nomor_p0 )
                                                    @if( $user_pralop->role_id === 4 || $user_pralop->role_id === 8 || $user_pralop->role_id === 9 )

                                                    <button class="btn btn-link px-3 mb-0 mt-2" type="button" id="btn_clear_p0_{{ $value->id }}" ><i class="material-icons opacity-7">backspace</i></button>
                                                    <label for="file_p0_{{ $value->id }}" class="px-3 mb-0 mt-2 btn btn-sm bg-gradient-light label_p0_{{ $value->id }}"><span id="label_file_p0_{{ $value->id }}">Pilih File P0</span></label>
                                                    <input style="width:10px;height:6px;visibility:hidden;" class="" id="file_p0_{{ $value->id }}" name="file_p0_{{ $value->id }}" type="file">

                                                    <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="uploadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Upload</button>
                                                        @if( $value->file_p0 )
                                                        <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                        @else
                                                        <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )"><i class="material-icons opacity-7">download</i></button><br>
                                                        @endif
                                                    @else
                                                        @if( $value->file_p0 )
                                                        <button class="btn btn-link bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Download P0</button><br>
                                                        @else
                                                        <button disabled class="btn bg-gradient-secondary px-3 mb-0 mt-2" onclick="downloadLayanan('p0', {{ $value->id ? $value->id : '' }} )">Download P0</button><br>
                                                        @endif
                                                    @endif
                                                  @endif

                                              </div>
                                              @endif

                                          </li>
                                        @endforeach
                                    @else
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
                                    @endif
                                  @endif

                              </ul>
                          </div>
                        </form>
                      </div>
                    </div>

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
                                            <textarea name="lop_keterangan" rows="5" cols="50" placeholder="INPUT KETERANGAN" autocomplete="off">{{ old('lop_keterangan') }}</textarea>
                                            @endif
                                        </div>
                                        <div class="row mt-1">
                                          <div class="col-md-6 ">
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
                                  @if($key === 0)
                                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-success" role="alert">
                                      <div class="d-flex align-items-center p-3">
                                          <div class="d-flex flex-column">
                                              <div class="d-flex align-items-center text-white text-md font-weight-bold">
                                                  {{ $value['keterangan'] }}
                                              </div>
                                              <div class="d-flex align-items-center text-white text-md font-weight-bold">
                                                  <h6 class="d-flex align-items-center text-white text-md">
                                                    <i class="material-icons text-md">person</i> {{ $value['user_update'] }}

                                                    <i class="material-icons text-md ps-2">schedule</i> {{ \Carbon\Carbon::parse($value['tgl_keterangan'])->translatedFormat('l, d F Y') }}</h6>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                  @else
                                  <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg alert alert-light" role="alert">
                                      <div class="d-flex align-items-center p-3">
                                          <div class="d-flex flex-column opacity-7">
                                              <div class="d-flex align-items-center text-black opacity-7 text-xs font-weight-bold">
                                                  {{ $value['keterangan'] }}
                                              </div>
                                              <div class="d-flex align-items-center text-black opacity-7 text-xs font-weight-bold">
                                                  <h6 class="d-flex align-items-center text-black opacity-7 text-xs">
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

    @if( $user_pralop->role_id === 4 && $pralop->lop_review_kb === true )
    <script type="text/javascript">

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
    @elseif( $user_pralop->role_id === 8 && $pralop->lop_review_kb === true )
    @elseif( $user_pralop->role_id === 13 && $pralop->lop_review_kb === true )
    @elseif( $user_pralop->role_id === 9 )
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
      @endif
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

    <script>
      function simpanLayanan(simpan_layanan_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "simpan_layanan_id")
          .attr("value", simpan_layanan_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.update') }}").submit();
      }

      function editLayanan(forms_obl_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "forms_obl_id")
          .attr("value", forms_obl_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.forms') }}").submit();
      }

      function downloadLayanan(var_file,var_obl_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_download")
          .attr("value", var_file + "_" + var_obl_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.download') }}").submit();
      }

      function uploadLayanan(var_file,var_obl_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_upload")
          .attr("value", var_file + "_" + var_obl_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.upload') }}").submit();
      }

      function printLayanan(var_file,var_obl_id){
        $('#formLayanan').attr('action', "");
        $("<input />").attr("type", "hidden")
          .attr("name", "file_print")
          .attr("value", var_file + "_" + var_obl_id )
          .appendTo("#formLayanan");
        $('#formLayanan').attr('action', "{{ route('witels.pralop.detail.layanan.print') }}").submit();
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
              else if(session_status.includes('Draf')){
                $('#status-input-obl').append(`
                  <div class="alert alert-warning alert-dismissible">
                      <div class="text-center">
                          <h5 class="text-white">`+session_status+`</h5>
                      </div>
                  </div>
                `);
                $('#modal-input-obl').modal('show');
              }
              else{
                $('#status-input-obl').append(`
                  <div class="alert alert-danger alert-dismissible">
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
