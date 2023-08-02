<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="inputs"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="OBL / Input Form"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <!-- modal alerts -->
            <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Submit Form OBL</h5>
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
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Input Form OBL</h6>
                                </div>
                            </div>

                            @if($errors->any())
                            <div class="card">
                              <div class="card-body">
                                <div class="border-radius-sm">
                                  <div class="alert alert-danger alert-dismissible text-align-center">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <div style="color:white;" class="text-center">
                                          <strong>INPUTAN BELUM VALID. CEK KEMBALI INPUTAN ANDA.</strong>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endif

                            <form id="formObl" action="{{ route('inputs.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="table-input-obl" class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr class="kepala">
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Inputan
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Isian Inputan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- filter kontrak -->
                                            <tr class="filterKontrak"><td colspan="2"><br></td></tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pelanggan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('f1_nama_plggn'))
                                                      <input style="width:450px;" class="outline-input-merah" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn','') }}"><br><br>
                                                    @else
                                                      <input style="width:450px;" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn','') }}"><br><br>
                                                    @endif
                                                    <textarea cols="50" rows="2" id="f1_alamat_plggn" name="f1_alamat_plggn" placeholder="ALAMAT PELANGGAN">{{ old('f1_alamat_plggn','') }}</textarea>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Witel</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <select name="f1_witel" id="f1_witel">
                                                            <option value="" disabled selected>Pilih Witel</option>
                                                            <option value="BALIKPAPAN" {{ old('f1_witel') == 'BALIKPAPAN' ? ' selected="selected"' : '' }}>BALIKPAPAN</option>
                                                            <option value="KALBAR" {{ old('f1_witel') == 'KALBAR' ? ' selected="selected"' : '' }}>KALBAR</option>
                                                            <option value="KALTENG" {{ old('f1_witel') == 'KALTENG' ? ' selected="selected"' : '' }}>KALTENG</option>
                                                            <option value="KALSEL" {{ old('f1_witel') == 'KALSEL' ? ' selected="selected"' : '' }}>KALSEL</option>
                                                            <option value="KALTARA" {{ old('f1_witel') == 'KALTARA' ? ' selected="selected"' : '' }}>KALTARA</option>
                                                            <option value="SAMARINDA" {{ old('f1_witel') == 'SAMARINDA' ? ' selected="selected"' : '' }}>SAMARINDA</option>
                                                        </select>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Judul Projek</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('f1_judul_projek'))
                                                      <textarea type="text" cols="50" rows="2" class="outline-input-merah" name="f1_judul_projek" id="f1_judul_projek">{{ old('f1_judul_projek','') }}</textarea>
                                                    @else
                                                      <textarea type="text" cols="50" rows="2" name="f1_judul_projek" id="f1_judul_projek">{{ old('f1_judul_projek','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Segmen</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="f1_segmen" id="f1_segmen">
                                                        <option value="" disabled selected>Pilih Segmen</option>
                                                        <option value="DES" {{ old('f1_segmen') == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                                                        <option value="DGS" {{ old('f1_segmen') == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                                                        <option value="DBS" {{ old('f1_segmen') == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nilai KB</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('f1_nilai_kb'))
                                                        <input class="rupiahs outline-input-merah" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb','') }}">
                                                    @else
                                                      <input class="rupiahs" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb','') }}">
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">No. KFS / SPK</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:350px;" type="text" name="f1_no_kfs_spk" id="f1_no_kfs_spk" value="{{ old('f1_no_kfs_spk','') }}">
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Quote</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:350px;" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak','') }}">
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Akun</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:350px;" type="text" name="f1_nomor_akun" id="f1_nomor_akun" value="{{ old('f1_nomor_akun','') }}">
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jenis Kontrak</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('f1_jenis_kontrak'))
                                                    <input type="radio" id="f1_jenis_kontrak" name="f1_jenis_kontrak" value="perpanjangan" value="{{ old('f1_jenis_kontrak') == 'perpanjangan' ? "checked" : "" }}">
                                                    <label class="outline-input-merah" for="jenis_kontrak"> Amandemen</label><br>
                                                    <input type="radio" id="f1_jenis_kontrak" name="f1_jenis_kontrak" value="baru" value="{{ old('f1_jenis_kontrak') == 'baru' ? "checked" : "" }}">
                                                    <label class="outline-input-merah" for="jenis_kontrak"> Pasang Baru</label><br>
                                                    @else
                                                    <input type="radio" id="f1_jenis_kontrak" name="f1_jenis_kontrak" value="perpanjangan" value="{{ old('f1_jenis_kontrak') == 'perpanjangan' ? "checked" : "" }}">
                                                    <label for="jenis_kontrak"> Amandemen</label><br>
                                                    <input type="radio" id="f1_jenis_kontrak" name="f1_jenis_kontrak" value="baru" value="{{ old('f1_jenis_kontrak') == 'baru' ? "checked" : "" }}">
                                                    <label for="jenis_kontrak"> Pasang Baru</label><br>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Masa Kontrak Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" name="f1_masa_layanan" id="f1_masa_layanan" min="0" style="width:80px;" value="{{ old('f1_masa_layanan','') }}">
                                                    <select name="f1_satuan_masa_layanan" id="f1_satuan_masa_layanan">
                                                        <option value="" disabled selected>Pilih Satuan Masa</option>
                                                        <option value="hari" {{ old('f1_satuan_masa_layanan') == 'hari' ? ' selected="selected"' : '' }}>hari</option>
                                                        <option value="bulan" {{ old('f1_satuan_masa_layanan') == 'bulan' ? ' selected="selected"' : '' }}>bulan</option>
                                                        <option value="tahun" {{ old('f1_satuan_masa_layanan') == 'tahun' ? ' selected="selected"' : '' }}>tahun</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Bayar</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <select name="f1_skema_bayar" id="f1_skema_bayar">
                                                            <option value="" disabled selected>Pilih Skema</option>
                                                            <option value="otc" {{ old('f1_skema_bayar') == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                                            <option value="recurring" {{ old('f1_skema_bayar') == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                                            <option value="termin" {{ old('f1_skema_bayar') == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                                            <option value="otc_recurring" {{ old('f1_skema_bayar') == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
                                                        </select>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Status Order</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <select name="f1_status_order" id="f1_status_order">
                                                            <option value="" disabled selected>Pilih Status</option>
                                                            <option value="inprogress_provision_issued" {{ old('f1_status_order') == 'inprogress_provision_issued' ? ' selected="selected"' : '' }}>In Progress - Provision Issued</option>
                                                            <option value="inprogress_provision_start" {{ old('f1_status_order') == 'inprogress_provision_start' ? ' selected="selected"' : '' }}>In Progress - Provision Start</option>
                                                            <option value="inprogress_provision_failed" {{ old('f1_status_order') == 'inprogress_provision_failed' ? ' selected="selected"' : '' }}>In Progress - Provision Failed</option>
                                                            <option value="inprogress_provision_complete" {{ old('f1_status_order') == 'inprogress_provision_complete' ? ' selected="selected"' : '' }}>In Progress - Provision Complete</option>
                                                            <option value="inprogress_pending_billing" {{ old('f1_status_order') == 'inprogress_pending_billing' ? ' selected="selected"' : '' }}>In Progress - Pending Billing</option>
                                                            <option value="inprogress_tsq_start" {{ old('f1_status_order') == 'inprogress_tsq_start' ? ' selected="selected"' : '' }}>In Progress - TSQ Start</option>
                                                            <option value="inprogress_provision_designed" {{ old('f1_status_order') == 'inprogress_provision_designed' ? ' selected="selected"' : '' }}>In Progress - Provision Designed</option>
                                                            <option value="approval" {{ old('f1_status_order') == 'approval' ? ' selected="selected"' : '' }}>Approval</option>
                                                            <option value="submit" {{ old('f1_status_order') == 'submit' ? ' selected="selected"' : '' }}>Submit</option>
                                                            <option value="failed_provision_failed" {{ old('f1_status_order') == 'failed_provision_failed' ? ' selected="selected"' : '' }}>Failed - Provision Failed</option>
                                                            <option value="inprogress_fullfill_billing_start" {{ old('f1_status_order') == 'inprogress_fullfill_billing_start' ? ' selected="selected"' : '' }}>In Progress - Fullfill Billing Start</option>
                                                            <option value="pending_baso" {{ old('f1_status_order') == 'pending_baso' ? ' selected="selected"' : '' }}>Pending BASO</option>
                                                            <option value="failed_fullfill_billing_failed" {{ old('f1_status_order') == 'failed_fullfill_billing_failed' ? ' selected="selected"' : '' }}>Failed - Fullfill Billing Failed</option>
                                                            <option value="fullfill_billing_complete" {{ old('f1_status_order') == 'fullfill_billing_complete' ? ' selected="selected"' : '' }}>Fullfill Billing Complete</option>
                                                            <option value="abandoned" {{ old('f1_status_order') == 'abandoned' ? ' selected="selected"' : '' }}>Abandoned</option>
                                                            <option value="pending_cancel" {{ old('f1_status_order') == 'pending_cancel' ? ' selected="selected"' : '' }}>Pending Cancel</option>
                                                            <option value="complete" {{ old('f1_status_order') == 'complete' ? ' selected="selected"' : '' }}>Complete</option>
                                                            <option value="cancel" {{ old('f1_status_order') == 'cancel' ? ' selected="selected"' : '' }}>Cancel</option>
                                                        </select>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Keterangan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea cols="50" rows="2" name="f1_keterangan" id="f1_keterangan">{{ old('f1_keterangan') }}</textarea>
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak"><td colspan="2"><br></td></tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Anak Perusahaan / Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:450px;" type="text" name="f1_nama_mitra" id="f1_nama_mitra" value="{{ old('f1_nama_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">PIC Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:450px;" type="text" name="f1_pic_mitra" id="f1_pic_mitra" value="{{ old('f1_pic_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="filterKontrak"><td colspan="2"><br></td></tr>
                                            <tr class="filterKontrak"><td colspan="2"><h6 class="ps-2">SKEMA OBL</h6></td></tr>
                                            <tr class="filterKontrak"><td colspan="2">
                                                <button type="button" id="lanjutWO2" class="btn bg-gradient-success"><h6 class="mb-0 text-sm" style="color:white;">Work Order ( WO ) </h6></button>
                                                <button type="button" id="lanjutFilter" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Kontrak Layanan ( KL ) </h6></button>
                                                <button type="submit" name="submit" value="draf_filter_kontrak" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <tr class="filterAwal"><td colspan="2"><br></td></tr>
                                            <tr class="filterAwal"><td colspan="2" id="judulFilter"><h6 class="ps-2">FILTER KL</h6></td></tr>
                                            <tr class="filterAwal">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nilai Kontrak</h6>
                                                            <!-- <p class="text-xs text-secondary mb-0">
                                                                laurent@creative-tim.com</p> -->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <input type="radio" id="f2_nilai_kontrak" name="f2_nilai_kontrak" value="dibawah_100" {{ old('f2_nilai_kontrak') == 'dibawah_100' ? "checked" : "" }}>
                                                        <label for="f2_nilai_kontrak"> < 100 Juta</label><br>
                                                        <input type="radio" id="f2_nilai_kontrak" name="f2_nilai_kontrak" value="diatas_100" {{ old('f2_nilai_kontrak') == 'diatas_100' ? "checked" : "" }}>
                                                        <label for="f2_nilai_kontrak"> > 100 Juta</label><br>
                                                </td>
                                            </tr>
                                            <tr class="filterAwal hide-filterkl">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Form P1</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  @if($errors->has('f2_tgl_p1'))
                                                    <input class="outline-input-merah" type="date" name="f2_tgl_p1" id="f2_tgl_p1" value="{{ old('f2_tgl_p1') }}">
                                                  @else
                                                    <input type="date" name="f2_tgl_p1" id="f2_tgl_p1" value="{{ old('f2_tgl_p1') }}">
                                                  @endif
                                                </td>
                                            </tr>
                                            <tr class="filterAwal"><td colspan="2"><br></td></tr>
                                            <tr class="filterAwal"><td colspan="2">
                                                <button type="button" id="backKontrak" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Filter Kontrak</h6></button>
                                                <button type="button" id="lanjutP2" class="btn bg-gradient-info hide-filterkl"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P2</h6></button>
                                                <button type="submit" name="submit" value="draf_filter_kl" id="saveDraf" class="hide-filterkl save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P2 -->
                                            <tr class="formP2"><td colspan="2"><br></td></tr>
                                            <tr class="formP2"><td colspan="2"><h6 class="ps-2">FORM P2 – EVALUASI DAN PENETAPAN BAKAL CALON MITRA PELAKSANA </h6></td></tr>

                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lingkup pekerjaan yang membutuhkan Anak Perusahaan/Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea type="text" cols="50" rows="2" name="p2_lingkup_kerja" id="p2_lingkup_kerja">{{ old('p2_lingkup_kerja') }}</textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Justifikasi Kebutuhan Penyedia Jasa dan Barang</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="p2_tgl_justifikasi" id="p2_tgl_justifikasi" value="{{ old('p2_tgl_justifikasi') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Dievaluasi Oleh</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p2_dievaluasi_oleh" id="p2_dievaluasi_oleh">
                                                        <option value="" disabled selected>Pilih dievaluasi oleh</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p2_dievaluasi_oleh') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p2_dievaluasi_oleh') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p2_dievaluasi_oleh') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Disetujui Oleh</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p2_disetujui_oleh" id="p2_disetujui_oleh">
                                                        <option value="" disabled selected>Pilih disetujui oleh</option>
                                                        <option value="Hariyadi_800031" {{ old('p2_disetujui_oleh') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Subroto Marzuki - 740130</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p2_disetujui_oleh') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Taufik - 730206</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Catatan Pejabat yang Berwenang</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="setuju" {{ old('p2_pilihan_catatan') == 'setuju' ? "checked" : "" }}>
                                                        <label for="p2_pilihan_catatan"> Setuju</label><br>
                                                        <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="setuju_dgn_catatan" {{ old('p2_pilihan_catatan') == 'setuju_dgn_catatan' ? "checked" : "" }}>
                                                        <label for="p2_pilihan_catatan"> Setuju dengan Catatan</label><br>
                                                        <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="tidak_setuju" {{ old('p2_pilihan_catatan') == 'tidak_setuju' ? "checked" : "" }}>
                                                        <label for="p2_pilihan_catatan"> Tidak Setuju</label><br>
                                                        <textarea name="p2_catatan" id="p2_catatan" cols="50" rows="2">{{ old('p2_catatan') }}</textarea>

                                                </td>
                                            </tr>
                                            <tr class="formP2"><td colspan="2"><br></td></tr>
                                            <tr class="formP2"><td colspan="2">
                                                <button type="button" id="backFilter" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Filter KL</h6></button>
                                                <button type="button" id="lanjutP3" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P3</h6></button>
                                                <button type="submit" name="submit" value="draf_p2" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P3 -->
                                            <tr class="formP3"><td colspan="2"><br></td></tr>
                                            <tr class="formP3"><td colspan="2"><h6 class="ps-2">FORM P3 – UNDANGAN PERMINTAAN DAN PENAWARAN HARGA</h6></td></tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Perwakilan Anak Perusahaan / Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="p3_pejabat_mitra_nama" id="p3_pejabat_mitra_nama" style="width:350px;" placeholder="NAMA PEJABAT" value="{{ old('p3_pejabat_mitra_nama') }}"><br>
                                                    <textarea cols="50" rows="2" name="p3_pejabat_mitra_alamat" id="p3_pejabat_mitra_alamat" style="width:350px;" placeholder="ALAMAT">{{ old('p3_pejabat_mitra_alamat') }}</textarea><br>
                                                    <input type="text" name="p3_pejabat_mitra_telepon" id="p3_pejabat_mitra_telepon" style="width:350px;" placeholder="TELEPON" value="{{ old('p3_pejabat_mitra_telepon') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Rapat Penjelasan Pengadaan</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                Undangan untuk menghadiri rapat dari Telkom ke Mitra</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="radio" name="p3_status_rapat_pengadaan" id="p3_status_rapat_pengadaan" value="ada" {{ old('p3_status_rapat_pengadaan') == 'ada' ? "checked" : "" }}><label for="p3_status_rapat_pengadaan">Ada</label><br>
                                                    <input type="radio" name="p3_status_rapat_pengadaan" id="p3_status_rapat_pengadaan" value="nada" {{ old('p3_status_rapat_pengadaan') == 'nada' ? "checked" : "" }}><label for="p3_status_rapat_pengadaan">Tidak Ada</label><br>
                                                    <div class="status_rapat_pengadaan"><input type="datetime-local" name="p3_tgl_rapat_pengadaan" id="p3_tgl_rapat_pengadaan" style="width:350px;" value="{{ old('p3_tgl_rapat_pengadaan') }}"> WIB</div>
                                                    <input class="status_rapat_pengadaan" type="text" name="p3_tmpt_rapat_pengadaan" id="p3_tmpt_rapat_pengadaan" style="width:350px;" placeholder="TEMPAT RAPAT" value="{{ old('p3_tmpt_rapat_pengadaan') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Surat Penawaran Mitra</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                Tenggat Waktu Surat Penawaran Mitra ke Telkom</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="datetime-local" name="p3_tgl_terima_sp" id="p3_tgl_terima_sp" style="width:350px;" value="{{ old('p3_tgl_terima_sp') }}"> WIB<br>
                                                    <input type="text" name="p3_alamat_terima_sp" id="p3_alamat_terima_sp" style="width:350px;" placeholder="ALAMAT PENYERAHAN DOKUMEN" value="{{ old('p3_alamat_terima_sp') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Manager</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p3_manager_obl" id="p3_manager_obl">
                                                        <option value="" disabled selected>Pilih manager</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p3_manager_obl') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p3_manager_obl') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p3_manager_obl') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP3"><td colspan="2"><br></td></tr>
                                            <tr class="formP3"><td colspan="2">
                                                <button type="button" id="backP2" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P2</h6></button>
                                                <button type="button" id="lanjutP4" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P4</h6></button>
                                                <button type="submit" name="submit" value="draf_p3" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P4 -->
                                            <tr class="formP4"><td colspan="2"><br></td></tr>
                                            <tr class="formP4"><td colspan="2"><h6 class="ps-2">FORM P4 – BERITA ACARA RAPAT PENJELASAN</h6></td></tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal SPH</h6>
                                                            <!-- <p class="text-xs text-secondary mb-0">
                                                                Perwakilan yang Hadir Rapat Penjelasan Pengadaan</p> -->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="p4_tgl_sph" id="p4_tgl_sph" value="{{ old('p4_tgl_sph') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Waktu Delivery Layanan <i>(Ready for Service)</i></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="p4_waktu_layanan" id="p4_waktu_layanan" value="{{ old('p4_waktu_layanan') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Bisnis</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p4_skema_bisnis" id="p4_skema_bisnis">
                                                        <option value="" disabled selected>Pilih Skema Bisnis</option>
                                                        <option value="sewa_murni" {{ old('p4_skema_bisnis') == 'sewa_murni' ? ' selected="selected"' : '' }}>Sewa Murni</option>
                                                        <option value="sewa_beli" {{ old('p4_skema_bisnis') == 'sewa_beli' ? ' selected="selected"' : '' }}>Sewa Beli</option>
                                                        <option value="beli_putus" {{ old('p4_skema_bisnis') == 'beli_putus' ? ' selected="selected"' : '' }}>Pengadaan Beli Putus</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Mekanisme Pembayaran</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p4_mekanisme_pembayaran" id="p4_mekanisme_pembayaran">
                                                        <option value="" disabled selected>Pilih Mekanisme</option>
                                                        <option value="back_to_back" {{ old('p4_mekanisme_pembayaran') == 'back_to_back' ? ' selected="selected"' : '' }}>Back To Back</option>
                                                        <option value="non_back_to_back" {{ old('p4_mekanisme_pembayaran') == 'non_back_to_back' ? ' selected="selected"' : '' }}>Non Back To Back</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Service Level Guarantee (SLG)</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="p4_slg" id="p4_slg" style="width:100px;" value="{{ old('p4_slg') }}"> %
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Fasilitator</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p4_fasilitator" id="p4_fasilitator">
                                                        <option value="" disabled selected>Pilih Fasilitator</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p4_fasilitator') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p4_fasilitator') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p4_fasilitator') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pengesahan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p4_pengesahan" id="p4_pengesahan">
                                                        <option value="" disabled selected>Pilih Pengesahan</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p4_pengesahan') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p4_pengesahan') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p4_pengesahan') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Attendees</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formP4"><td colspan="2">
                                                <div class="table-responsive">
                                                    <table class="table" id="p4_attendees">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Attendees</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                          @if( old('p4_attendees') )
                                                            @for( $i = 0; $i < count(old('p4_attendees')); $i++ )
                                                              <th scrope="row"> {{ ($i+1) }} </th>
                                                              <td><input style="width:500px;" type="text" name="p4_attendees[]" id="p4_attendees" placeholder="Masukkan Attendees" value="{{ old('p4_attendees.'.$i) }}"></td>
                                                              <td><button style="float:left;margin-left:-250%;" type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>
                                                            @endfor
                                                          @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <button type="button" class="btn bg-gradient-info" id="insertRow"><i class="fa fa-plus-square"></i></button>
                                            </td></tr>
                                            <tr class="formP4"><td colspan="2"><br></td></tr>
                                            <tr class="formP4"><td colspan="2">
                                                <button type="button" id="backP3" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P3</h6></button>
                                                <button type="button" id="lanjutP5" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P5</h6></button>
                                                <button type="submit" name="submit" value="draf_p4" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P5 -->
                                            <tr class="formP5"><td colspan="2"><br></td></tr>
                                            <tr class="formP5"><td colspan="2"><h6 class="ps-2">FORM P5 – BERITA ACARA EVALUASI <i>INDICATIVE OFFERING</i></h6></td></tr>
                                            <tr class="formP5">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Harga Penawaran Total (Sebelum PPN)</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p5_harga_penawaran" id="p5_harga_penawaran" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('p5_harga_penawaran') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP5">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">TTD Tim Evaluator</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p5_ttd_evaluator" id="p5_ttd_evaluator">
                                                        <option value="" disabled selected>Pilih Evaluator</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p5_ttd_evaluator') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p5_ttd_evaluator') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p5_ttd_evaluator') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP5"><td colspan="2"><br></td></tr>
                                            <tr class="formP5"><td colspan="2">
                                                <button type="button" id="backP4" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P4</h6></button>
                                                <button type="button" id="lanjutP6" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P6</h6></button>
                                                <button type="submit" name="submit" value="draf_p5" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P6 -->
                                            <tr class="formP6"><td colspan="2"><br></td></tr>
                                            <tr class="formP6"><td colspan="2"><h6 class="ps-2">FORM P6 – BERITA ACARA KLARIFIKASI DAN NEGOSIASI</h6></td></tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Penandatangan BAST Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" id="p6_ttd_bast_telkom" name="p6_ttd_bast_telkom" style="width:350px;" value="{{ old('p6_ttd_bast_telkom') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Penandatangan BAST Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" id="p6_ttd_bast_mitra" name="p6_ttd_bast_mitra" style="width:350px;" value="{{ old('p6_ttd_bast_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Harga Negosiasi</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p6_harga_negosiasi" id="p6_harga_negosiasi" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('p6_harga_negosiasi') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Peserta Rapat Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="p6_nama_peserta_mitra" id="p6_nama_peserta_mitra" style="width:350px;" placeholder="NAMA PESERTA MITRA" value="{{ old('p6_nama_peserta_mitra') }}"><br>
                                                    <input type="text" style="width:350px;" placeholder="JABATAN PESERTA MITRA" id="p6_jabatan_peserta_mitra" name="p6_jabatan_peserta_mitra" value="{{ old('p6_jabatan_peserta_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Peserta Rapat Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p6_peserta_rapat_telkom" id="p6_peserta_rapat_telkom">
                                                        <option value="" disabled selected>Pilih Peserta</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p6_peserta_rapat_telkom') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p6_peserta_rapat_telkom') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p6_peserta_rapat_telkom') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pengesahan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p6_pengesahan" id="p6_pengesahan">
                                                        <option value="" disabled selected>Pilih Pengesahan</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p6_pengesahan') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p6_pengesahan') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p6_pengesahan') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP6"><td colspan="2"><br></td></tr>
                                            <tr class="formP6"><td colspan="2">
                                                <button type="button" id="backKontrak2" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Filter Kontrak</h6></button>
                                                <button type="button" id="backP5" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P5</h6></button>
                                                <button type="button" id="lanjutP7" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P7</h6></button>
                                                <button type="button" id="lanjutWO3" class="btn bg-gradient-success"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form WO</h6></button>
                                                <button type="submit" name="submit" value="draf_p6" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P7 -->
                                            <tr class="formP7"><td colspan="2"><br></td></tr>
                                            <tr class="formP7"><td colspan="2"><h6 class="ps-2">FORM P7 – PENETAPAN CALON MITRA PELAKSANA</h6></td></tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lampiran Berkas</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" name="p7_lampiran_berkas" id="p7_lampiran_berkas" style="width:100px;" min="0" placeholder="" value="{{ old('p7_lampiran_berkas') }}">
                                                </td>
                                            </tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jumlah Harga Pekerjaan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p7_harga_pekerjaan" id="p7_harga_pekerjaan" style="width:350px;" placeholder="RP xxx.xxx.xxx.-" value="{{ old('p7_harga_pekerjaan') }}"><br>
                                                </td>
                                            </tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">OTC</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p7_otc" id="p7_otc" style="width:350px;" placeholder="RP xxx.xxx.xxx.-" value="{{ old('p7_otc') }}"><br>
                                                </td>
                                            </tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nominal Rincian Bulanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p7_rincian_bulanan" id="p7_rincian_bulanan" style="width:350px;" placeholder="RP xxx.xxx.xxx.-" value="{{ old('p7_rincian_bulanan') }}"><br>
                                                </td>
                                            </tr>
                                            <tr class="formP7"><td colspan="2"><br></td></tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pemeriksa</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="p7_pemeriksa" id="p7_pemeriksa">
                                                        <option value="" disabled selected>Pilih Pemeriksa</option>
                                                        <option value="Didik_Kurniawan_Hadi_860113" {{ old('p7_pemeriksa') == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                                                        <option value="Hariyadi_800031" {{ old('p7_pemeriksa') == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                                                        <option value="Yayan_Nuryana_710516" {{ old('p7_pemeriksa') == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tembusan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="p7_tembusan" id="p7_tembusan" style="width:350px;" placeholder="Contoh: GM Witel Balikpapan" value="{{ old('p7_tembusan') }}"><br>
                                                </td>
                                            </tr>
                                            <tr class="formP7"><td colspan="2"><br></td></tr>
                                            <tr class="formP7"><td colspan="2">
                                                <button type="button" id="backP6" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P6</h6></button>
                                                <button type="button" id="lanjutP8" class="diatas-100 btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P8</h6></button>
                                                <button type="button" id="lanjutSP" class="dibawah-100 btn bg-gradient-info" ><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form SP</h6></button>
                                                <button type="submit" name="submit" value="draf_p7" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- P8 -->
                                            <tr class="formP8"><td colspan="2"><br></td></tr>
                                            <tr class="formP8"><td colspan="2"><h6 class="ps-2">FORM P8</h6></td></tr>
                                            <tr class="formP8">
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <div id="suksesIsi" class="alert alert-success opacity-7" role="alert">
                                                                <h5 class="text-white mb-0 text-lg">INPUTAN FORM P8 SUDAH TERISI ✅</h5>
                                                                <p class="text-xs text-secondary mb-0 text-white">
                                                                SILAHKAN LANJUT KE FORM WO</p>
                                                            </div>
                                                            <div id="gagalIsi" class="alert alert-danger opacity-7" role="alert">
                                                                <h5 class="text-white mb-0 text-lg">INPUTAN FORM P8 BELUM TERISI ❌</h5>
                                                                <p class="text-xs text-secondary mb-0 text-white">
                                                                SILAHKAN KEMBALI KE FORM P7</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formP8"><td colspan="2"><br></td></tr>
                                            <tr class="formP8"><td colspan="2">
                                                <button type="button" id="backP7" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P7</h6></button>
                                                <button type="button" id="lanjutKL" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form KL</h6></button>
                                                <button type="submit" name="submit" value="draf_p8" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- WO -->
                                            <tr class="formWO"><td colspan="2"><br></td></tr>
                                            <tr class="formWO"><td colspan="2"><h6 class="ps-2">WORK ORDER ( WO )</h6></td></tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal FO (P1)</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  @if($errors->has('wo_tgl_fo'))
                                                    <input class="outline-input-merah" type="date" name="wo_tgl_fo" id="wo_tgl_fo" value="{{ old('wo_tgl_fo') }}">
                                                  @else
                                                    <input type="date" name="wo_tgl_fo" id="wo_tgl_fo" value="{{ old('wo_tgl_fo') }}">
                                                  @endif

                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor KB</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="wo_nomor_kb" id="wo_nomor_kb" style="width:350px;" value="{{ old('wo_nomor_kb') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jenis Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="wo_jenis_layanan" id="wo_jenis_layanan" style="width:350px;" value="{{ old('wo_jenis_layanan') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jumlah Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" name="wo_jumlah_layanan" id="wo_jumlah_layanan" min="0" style="width:100px;" value="{{ old('wo_jumlah_layanan') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO"><td colspan="2"><br></td></tr>
                                            <tr class="formWO">
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Total Harga ( Ke Pelanggan) </h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                format: Rp. xxx.xxx.-</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Total Harga</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="wo_harga_ke_plggn" id="wo_harga_ke_plggn" style="width:350px;" placeholder="RP xxx.xxx.-" value="{{ old('wo_harga_ke_plggn') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">OTC</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="wo_onetime_charge_plggn" id="wo_onetime_charge_plggn" style="width:350px;" placeholder="RP xxx.xxx.-" value="{{ old('wo_onetime_charge_plggn') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Monthly</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="wo_monthly_plggn" id="wo_monthly_plggn" style="width:350px;" placeholder="RP xxx.xxx.-" value="{{ old('wo_monthly_plggn') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                    <td colspan="2"><br></td>
                                            </tr>
                                            <tr class="formWO">
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm opacity-7">Hak Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">One Time Charge</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="wo_onetime_charge_telkom" id="wo_onetime_charge_telkom" style="width:350px;" placeholder="Rp xxx.xxx.-" value="{{ old('wo_onetime_charge_telkom') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Monthly</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="wo_persen_telkom" id="wo_persen_telkom" placeholder="PERSEN" style="width:100px;" value="{{ old('wo_persen_telkom') }}"> % atau sebesar
                                                    <input type="text" name="wo_monthly_telkom" id="wo_monthly_telkom" placeholder="Rp xxx.xxx.-" style="width:300px;" value="{{ old('wo_monthly_telkom') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                    <td colspan="2"><br></td>
                                            </tr>
                                            <tr class="formWO">
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm opacity-7">Hak Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">One Time Charge</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="wo_onetime_charge_mitra" id="wo_onetime_charge_mitra" style="width:350px;" placeholder="Rp xxx.xxx.-" value="{{ old('wo_onetime_charge_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Monthly</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="wo_persen_mitra" id="wo_persen_mitra" placeholder="PERSEN" style="width:100px;" value="{{ old('wo_persen_mitra') }}"> % atau sebesar
                                                    <input type="text" name="wo_monthly_mitra" id="wo_monthly_mitra" placeholder="Rp xxx.xxx.-" style="width:300px;" value="{{ old('wo_monthly_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formWO"><td colspan="2"><br></td></tr>
                                            <tr class="formWO"><td colspan="2">
                                                <button type="button" id="backP62" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P6</h6></button>
                                                <button type="submit" name="submit" value="submit_wo" class="btn bg-gradient-success"><h6 class="mb-0 text-sm" style="color:white;">Submit Skema WO</h6></button>
                                                <button type="submit" name="submit" value="draf_wo" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- SP -->
                                            <tr class="formSP"><td colspan="2"><br></td></tr>
                                            <tr class="formSP"><td colspan="2"><h6 class="ps-2">Surat Pesanan (SP)</h6></td></tr>
                                            <tr class="formSP">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Kontrak Berlangganan (KB) </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="sp_nomor_kb" id="sp_nomor_kb" style="width:300px;" value="{{ old('sp_nomor_kb') }}">
                                                </td>
                                            </tr>
                                            <tr class="formSP"><td colspan="2"><br></td></tr>
                                            <tr class="formSP"><td colspan="2">
                                                <button type="button" id="backP72" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P7</h6></button>
                                                <button type="submit" name="submit" value="submit_sp" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit Skema SP</h6></button>
                                                <button type="submit" name="submit" value="draf_sp" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>
                                            <!-- KL -->
                                            <tr class="formKL"><td colspan="2"><br></td></tr>
                                            <tr class="formKL"><td colspan="2"><h6 class="ps-2">KONTRAK LAYANAN ( KL )</h6></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Kontrak Berlangganan (KB) </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_nomor_kb" id="kl_nomor_kb" style="width:300px;" value="{{ old('kl_nomor_kb') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor KL Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_no_kl_mitra" id="kl_no_kl_mitra" style="width:300px;" value="{{ old('kl_no_kl_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tempat ditandatanganinya KL</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_tempat_ttd_kl" id="kl_tempat_ttd_kl" style="width:300px;" value="{{ old('kl_tempat_ttd_kl') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Notaris</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_notaris" id="kl_notaris" style="width:300px;" value="{{ old('kl_notaris') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Akta Notaris</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_akta_notaris" id="kl_akta_notaris" style="width:300px;" value="{{ old('kl_akta_notaris') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Akta Notaris</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="kl_tgl_akta_notaris" id="kl_tgl_akta_notaris" style="width:300px;" value="{{ old('kl_tgl_akta_notaris') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Pejabat Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_nama_pejabat_telkom" id="kl_nama_pejabat_telkom" style="width:300px;" value="{{ old('kl_nama_pejabat_telkom') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jabatan Pejabat Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_jabatan_pejabat_telkom" id="kl_jabatan_pejabat_telkom" style="width:300px;" value="{{ old('kl_jabatan_pejabat_telkom') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><br></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">NPWP Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_npwp_mitra" id="kl_npwp_mitra" style="width:300px;" value="{{ old('kl_npwp_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Anggaran Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_no_anggaran_mitra" id="kl_no_anggaran_mitra" style="width:300px;" value="{{ old('kl_no_anggaran_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Anggaran Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="kl_tgl_anggaran_mitra" id="kl_tgl_anggaran_mitra" style="width:300px;" value="{{ old('kl_tgl_anggaran_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Pejabat Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_nama_pejabat_mitra" id="kl_nama_pejabat_mitra" style="width:300px;" value="{{ old('kl_nama_pejabat_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jabatan Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_jabatan_pejabat_mitra" id="kl_jabatan_pejabat_mitra" style="width:300px;" value="{{ old('kl_jabatan_pejabat_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor SKM</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_no_skm" id="kl_no_skm" style="width:300px;" value="{{ old('kl_no_skm') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal SKM</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="kl_tgl_skm" id="kl_tgl_skm" style="width:300px;" value="{{ old('kl_tgl_skm') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Perihal SKM</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_perihal_skm" id="kl_perihal_skm" style="width:300px;" value="{{ old('kl_perihal_skm') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><br></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Akhir Berlaku KL</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="kl_tgl_akhir_kl" id="kl_tgl_akhir_kl" style="width:300px;" value="{{ old('kl_tgl_akhir_kl') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><br></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pembayaran Uang Muka (DP) dari Telkom ke Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_bayar_dp" id="kl_bayar_dp" style="width:300px;" placeholder="RP xxx.xxx.xxx.-" value="{{ old('kl_bayar_dp') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Bank Rekening Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_nama_bank_mitra" id="kl_nama_bank_mitra" style="width:300px;" value="{{ old('kl_nama_bank_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Kantor Cabang Bank Rekening Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_cabang_bank_mitra" id="kl_cabang_bank_mitra" style="width:300px;" value="{{ old('kl_cabang_bank_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Rekening Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_rek_bank_mitra" id="kl_rek_bank_mitra" style="width:300px;" value="{{ old('kl_rek_bank_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Atas Nama Rekening Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="kl_an_bank_mitra" id="kl_an_bank_mitra" style="width:300px;" value="{{ old('kl_an_bank_mitra') }}">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><br></td></tr>
                                            <tr class="formKL"><td colspan="2">
                                                <button type="button" id="backP8" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P8</h6></button>
                                                <button type="submit" name="submit" value="submit_kl" class="btn bg-gradient-info" ><h6 class="mb-0 text-sm" style="color:white;">Submit Skema KL</h6></button>
                                                <button type="submit" name="submit" value="draf_kl" id="saveDraf" class="save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                                            </td></tr>

                                            <!-- <tr class="diatas-100">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Laurent Perrier</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                laurent@creative-tim.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text">
                                                </td>
                                            </tr> -->

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        <x-plugins></x-plugins>
        @push('js')
        <script>
            $( document ).ready(function() {
                var global_jenis_spk = '';
                var view_diatas_100='';

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


                // clear form submit after refresh browser
                $('#formObl')[0].reset();
                $("#formObl").submit( function(e) {
                   $("<input />").attr("type", "hidden")
                       .attr("name", "global_jenis_spk")
                       .attr("value", global_jenis_spk)
                       .appendTo("#formObl");
                   return true;
               });

                $('input[type=radio][name=p3_status_rapat_pengadaan]').change(function() {
                    if (this.value == 'ada') {
                        $('.status_rapat_pengadaan').show();
                    }
                    else if (this.value == 'nada') {
                        $('.status_rapat_pengadaan').hide();
                    }
                });


                $('input[type=radio][name=f2_nilai_kontrak]').change(function() {
                    if (this.value == 'dibawah_100') {
                        global_jenis_spk = 'SP';
                        view_diatas_100='0';
                        $('#lanjutP2').show(); $('.hide-filterkl').show();
                        $('#judulFilter').empty(); $('#judulFilter').append(`<h6 class="ps-2">SKEMA SP</h6>`);
                    }
                    else if (this.value == 'diatas_100') {
                        global_jenis_spk = 'KL';
                        view_diatas_100='1';
                        $('#lanjutP2').show(); $('.hide-filterkl').show();
                        $('#judulFilter').empty(); $('#judulFilter').append(`<h6 class="ps-2">SKEMA KL</h6>`);
                    }
                });

                // SKEMA OBL : WO
                $('#lanjutWO2').click(function(){
                  global_jenis_spk = 'WO';
                  $('.filterKontrak').hide(); $('.formP6').show();
                  $('#backP5').hide(); $('#lanjutP7').hide();
                  $('#backKontrak2').show(); $('#lanjutWO3').show();
                });

                $('#backKontrak2').click(function(){
                  global_jenis_spk = '';
                    $('.formP6').hide(); $('.filterKontrak').show();
                });
                $('#lanjutWO3').click(function(){
                  $('.formP6').hide(); $('.formWO').show();
                });
                $('#backP62').click(function(){
                    $('.formWO').hide(); $('.formP6').show();
                    $('#backP5').hide(); $('#lanjutP7').hide();
                    $('#backKontrak2').show(); $('#lanjutWO3').show();
                });
                // END SKEMA OBL : WO

                $('#lanjutFilter').click(function(){ $('.filterKontrak').hide(); $('.filterAwal').show(); $('.hide-filterkl').hide(); });
                $('#backKontrak').click(function(){ global_jenis_spk = ''; $('.filterAwal').hide(); $('input[type=radio][name=f2_nilai_kontrak]').prop('checked',false); $('#judulFilter').empty(); $('#judulFilter').append(`<h6 class="ps-2">FILTER KL</h6>`); $('.filterKontrak').show(); });
                $('#lanjutP2').click(function(){
                  if($('#f2_tgl_p1').val() === ''){ $('#f2_tgl_p1').addClass('outline-input-merah'); }
                  else{ $('.filterAwal').hide(); $('#f2_tgl_p1').removeClass('outline-input-merah'); $('.formP2').show(); }
                });

                $('#backFilter').click(function(){ $('.formP2').hide(); $('.filterAwal').show(); });
                $('#lanjutP3').click(function(){ $('.formP2').hide(); $('.formP3').show(); });

                $('#backP2').click(function(){ $('.formP3').hide(); $('.formP2').show(); });
                $('#lanjutP4').click(function(){ $('.formP3').hide(); $('.formP4').show(); });

                $('#backP3').click(function(){ $('.formP4').hide(); $('.formP3').show(); });
                $('#lanjutP5').click(function(){
                    $('.formP4').hide(); $('.formP5').show();
                });
                $('#backP4').click(function(){ $('.formP5').hide(); $('.formP4').show(); });
                $('#lanjutP6').click(function(){
                    $('.formP5').hide(); $('.formP6').show(); $('#backKontrak2').hide(); $('#lanjutWO3').hide(); $('#backP5').show(); $('#lanjutP7').show();
                });
                $('#backP5').click(function(){
                    $('.formP6').hide(); $('.formP5').show();
                });
                $('#lanjutP7').click(function(){
                    $('.formP6').hide(); $('.formP7').show();
                    if(view_diatas_100=='1'){ $('.dibawah-100').hide(); $('.diatas-100').show();  }
                    else if(view_diatas_100=='0'){ $('.diatas-100').hide(); $('.dibawah-100').show();  }
                });
                $('#backP6').click(function(){
                    $('.formP7').hide(); $('.formP6').show();
                });
                // SKEMA OBL : SP
                $('#lanjutSP').click(function(){
                    $('.formP7').hide(); $('.formSP').show();
                });
                $('#backP72').click(function(){
                    $('.formSP').hide(); $('.formP7').show(); $('.diatas-100').hide(); $('.dibawah-100').show();
                });

                // SKEMA OBL : KL
                $('#lanjutP8').click(function(){
                    $('.formP7').hide(); $('.formP8').show();
                    if(
                        $('#p7_lampiran_berkas').val() === '' ||
                        $('#p7_harga_pekerjaan').val() === '' ||
                        $('#p7_otc').val() === '' ||
                        $('#p7_rincian_bulanan').val() === '' ||
                        $('#p7_pemeriksa').val() === '' ||
                        $('#p7_tembusan').val() === ''
                    )
                    { $('#lanjutKL').hide(); $('.save-draf').hide(); $('#suksesIsi').hide(); $('#gagalIsi').show(); }
                    else{ $('#gagalIsi').hide(); $('#suksesIsi').show(); $('#lanjutKL').show(); $('.save-draf').show(); }
                });
                $('#backP7').click(function(){
                    $('.formP8').hide(); $('.formP7').show(); $('.dibawah-100').hide(); $('.diatas-100').show();
                });
                $('#backP8').click(function(){
                    $('.formKL').hide(); $('.formP8').show();
                    if(
                        $('#p7_lampiran_berkas').val() === '' ||
                        $('#p7_harga_pekerjaan').val() === '' ||
                        $('#p7_otc').val() === '' ||
                        $('#p7_rincian_bulanan').val() === '' ||
                        $('#p7_pemeriksa').val() === '' ||
                        $('#p7_tembusan').val() === ''
                    )
                    { $('#lanjutKL').hide(); $('.save-draf').hide(); $('#suksesIsi').hide(); $('#gagalIsi').show(); }
                    else{ $('#gagalIsi').hide(); $('#suksesIsi').show(); $('#lanjutKL').show(); $('.save-draf').show(); }
                });
                $('#lanjutKL').click(function(){
                    $('.formP8').hide(); $('.formKL').show();
                });

                // INPUT TEXT : NUMERIC TYPE ONLY
                $("input[name='p7_lampiran_berkas']").on('input', function (e) {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });
                $("input[name='wo_jumlah_layanan']").on('input', function (e) {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));
                });


                // STARTLINE: FORMAT RUPIAH FORM P5 Harga Penawaran
                var rupiah = document.getElementById('f1_nilai_kb');
                rupiah.addEventListener('keyup', function(e){
                    rupiah.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah2 = document.getElementById('p5_harga_penawaran');
                rupiah2.addEventListener('keyup', function(e){
                    rupiah2.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah3 = document.getElementById('p6_harga_negosiasi');
                rupiah3.addEventListener('keyup', function(e){
                    rupiah3.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah4 = document.getElementById('p7_harga_pekerjaan');
                rupiah4.addEventListener('keyup', function(e){
                    rupiah4.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah5 = document.getElementById('p7_otc');
                rupiah5.addEventListener('keyup', function(e){
                    rupiah5.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah6 = document.getElementById('p7_rincian_bulanan');
                rupiah6.addEventListener('keyup', function(e){
                    rupiah6.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah7 = document.getElementById('wo_harga_ke_plggn');
                rupiah7.addEventListener('keyup', function(e){
                    rupiah7.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah8 = document.getElementById('wo_onetime_charge_plggn');
                rupiah8.addEventListener('keyup', function(e){
                    rupiah8.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah9 = document.getElementById('wo_monthly_plggn');
                rupiah9.addEventListener('keyup', function(e){
                    rupiah9.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah10 = document.getElementById('wo_onetime_charge_telkom');
                rupiah10.addEventListener('keyup', function(e){
                    rupiah10.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah11 = document.getElementById('wo_monthly_telkom');
                rupiah11.addEventListener('keyup', function(e){
                    rupiah11.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah12 = document.getElementById('wo_onetime_charge_mitra');
                rupiah12.addEventListener('keyup', function(e){
                    rupiah12.value = formatRupiah(this.value, 'Rp. ');
                });

                var rupiah13 = document.getElementById('wo_monthly_mitra');
                rupiah13.addEventListener('keyup', function(e){
                    rupiah13.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah14 = document.getElementById('kl_bayar_dp');
                rupiah14.addEventListener('keyup', function(e){
                    rupiah14.value = formatRupiah(this.value, 'Rp. ');
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
                // ENDLINE: FORMAT RUPIAH FORM P5 Harga Penawaran


                // Start dd rows table p4 attendees
                var counter = 1;
                $("#insertRow").on("click", function (event) {
                    event.preventDefault();
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<th scrope="row">' + counter + '</th>';
                    cols += '<td><input style="width:500px;" type="text" name="p4_attendees[]" id="p4_attendees" placeholder="Masukkan Attendees"></td>';
                    cols += '<td><button style="float:left;margin-left:-250%;" type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>';
                    newRow.append(cols);
                    $("#p4_attendees").append(newRow);
                    counter++;
                });
                $("#p4_attendees").on("click", "#deleteRow", function (event) {
                    $(this).closest("tr").remove();
                    counter -= 1
                });
                // end add rows table p4 attendees

            });

        </script>
        @endpush
</x-layout>
