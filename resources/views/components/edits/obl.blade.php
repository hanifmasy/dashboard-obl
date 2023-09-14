@props([
    'table_edit','table_edit_keterangan','mitra_vendor'
])

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
            @foreach($table_edit as $key => $value)
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
                        <input style="width:450px;" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn',$value['f1_nama_plggn']) }}"><br><br>
                        <textarea cols="50" rows="2" id="f1_alamat_plggn" name="f1_alamat_plggn" placeholder="ALAMAT PELANGGAN">{{ old('f1_alamat_plggn',$value['f1_alamat_plggn']) }}</textarea>
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
                          <input type="text" value="{{ old('f1_witel',$value['f1_witel']) }}" disabled style="border:none;font-weight:bolder;">
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
                          <textarea type="text" cols="50" rows="2" name="f1_judul_projek" id="f1_judul_projek">{{ old('f1_judul_projek',$value['f1_judul_projek']) }}</textarea>
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
                            <option value="DES" {{ old('f1_segmen',$value['f1_segmen']) == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                            <option value="DGS" {{ old('f1_segmen',$value['f1_segmen']) == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                            <option value="DBS" {{ old('f1_segmen',$value['f1_segmen']) == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                        </select>
                    </td>
                </tr>
                <tr class="filterKontrak">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Proses</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <select name="f1_proses" id="f1_proses" disabled>
                            <option value="" disabled selected>Pilih Proses</option>
                            <option value="witel" {{ old('f1_proses',$value['f1_proses']) == 'witel' ? ' selected="selected"' : '' }}>WITEL</option>
                            <option value="obl" {{ old('f1_proses',$value['f1_proses']) == 'obl' ? ' selected="selected"' : '' }}>OBL</option>
                            <option value="legal" {{ old('f1_proses',$value['f1_proses']) == 'legal' ? ' selected="selected"' : '' }}>LEGAL</option>
                            <option value="mitra_obl" {{ old('f1_proses',$value['f1_proses']) == 'mitra_obl' ? ' selected="selected"' : '' }}>MITRA OBL</option>
                            <option value="close_sm" {{ old('f1_proses',$value['f1_proses']) == 'close_sm' ? ' selected="selected"' : '' }}>CLOSE SM</option>
                            <option value="done" {{ old('f1_proses',$value['f1_proses']) == 'done' ? ' selected="selected"' : '' }}>DONE</option>
                            <option value="cancel" {{ old('f1_proses',$value['f1_proses']) == 'cancel' ? ' selected="selected"' : '' }}>CANCEL</option>
                        </select>
                    </td>
                </tr>
                <tr class="filterKontrak">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Jenis SPK</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" value="{{ $value['f1_jenis_spk'] }}" disabled style="font-weight: bolder;border:none;">
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
                        <select name="f1_jenis_kontrak" id="f1_jenis_kontrak">
                            <option value="" disabled selected>Pilih Jenis</option>
                            <option value="perpanjangan" {{ old('f1_jenis_kontrak',$value['f1_jenis_kontrak']) == 'perpanjangan' ? ' selected="selected"' : '' }}>Amandemen</option>
                            <option value="baru" {{ old('f1_jenis_kontrak',$value['f1_jenis_kontrak']) == 'baru' ? ' selected="selected"' : '' }}>Pasang Baru</option>
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
                            <input class="rupiahs outline-input-merah" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb') }}">
                        @else
                          <input class="rupiahs" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb',$value['f1_nilai_kb']) }}">
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
                        <input type="number" name="f1_masa_layanan_tahun" id="f1_masa_layanan_tahun" min="0" style="width:80px;" value="{{ old('f1_masa_layanan_tahun',$value['f1_masa_layanan_tahun']) }}">Tahun
                        <input type="number" name="f1_masa_layanan_bulan" id="f1_masa_layanan_bulan" min="0" style="width:80px;" value="{{ old('f1_masa_layanan_bulan',$value['f1_masa_layanan_bulan']) }}">Bulan
                        <input type="number" name="f1_masa_layanan_hari" id="f1_masa_layanan_hari" min="0" style="width:80px;" value="{{ old('f1_masa_layanan_hari',$value['f1_masa_layanan_hari']) }}">Hari
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
                        <input style="width:350px;" type="text" name="f1_no_kfs_spk" id="f1_no_kfs_spk" value="{{ old('f1_no_kfs_spk',$value['f1_no_kfs_spk']) }}">
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
                        <input style="width:350px;" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak',$value['f1_quote_kontrak']) }}">
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
                        <input style="width:350px;" type="text" name="f1_nomor_akun" id="f1_nomor_akun" value="{{ old('f1_nomor_akun',$value['f1_nomor_akun']) }}">
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
                                <option value="otc" {{ old('f1_skema_bayar',$value['f1_skema_bayar']) == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                <option value="recurring" {{ old('f1_skema_bayar',$value['f1_skema_bayar']) == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                <option value="termin" {{ old('f1_skema_bayar',$value['f1_skema_bayar']) == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                <option value="otc_recurring" {{ old('f1_skema_bayar',$value['f1_skema_bayar']) == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
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
                                <option value="inprogress_provision_issued" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_provision_issued' ? ' selected="selected"' : '' }}>In Progress - Provision Issued</option>
                                <option value="inprogress_provision_start" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_provision_start' ? ' selected="selected"' : '' }}>In Progress - Provision Start</option>
                                <option value="inprogress_provision_failed" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_provision_failed' ? ' selected="selected"' : '' }}>In Progress - Provision Failed</option>
                                <option value="inprogress_provision_complete" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_provision_complete' ? ' selected="selected"' : '' }}>In Progress - Provision Complete</option>
                                <option value="inprogress_pending_billing" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_pending_billing' ? ' selected="selected"' : '' }}>In Progress - Pending Billing</option>
                                <option value="inprogress_tsq_start" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_tsq_start' ? ' selected="selected"' : '' }}>In Progress - TSQ Start</option>
                                <option value="inprogress_provision_designed" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_provision_designed' ? ' selected="selected"' : '' }}>In Progress - Provision Designed</option>
                                <option value="approval" {{ old('f1_status_order',$value['f1_status_order']) == 'approval' ? ' selected="selected"' : '' }}>Approval</option>
                                <option value="submit" {{ old('f1_status_order',$value['f1_status_order']) == 'submit' ? ' selected="selected"' : '' }}>Submit</option>
                                <option value="failed_provision_failed" {{ old('f1_status_order',$value['f1_status_order']) == 'failed_provision_failed' ? ' selected="selected"' : '' }}>Failed - Provision Failed</option>
                                <option value="inprogress_fullfill_billing_start" {{ old('f1_status_order',$value['f1_status_order']) == 'inprogress_fullfill_billing_start' ? ' selected="selected"' : '' }}>In Progress - Fullfill Billing Start</option>
                                <option value="pending_baso" {{ old('f1_status_order',$value['f1_status_order']) == 'pending_baso' ? ' selected="selected"' : '' }}>Pending BASO</option>
                                <option value="failed_fullfill_billing_failed" {{ old('f1_status_order',$value['f1_status_order']) == 'failed_fullfill_billing_failed' ? ' selected="selected"' : '' }}>Failed - Fullfill Billing Failed</option>
                                <option value="fullfill_billing_complete" {{ old('f1_status_order',$value['f1_status_order']) == 'fullfill_billing_complete' ? ' selected="selected"' : '' }}>Fullfill Billing Complete</option>
                                <option value="abandoned" {{ old('f1_status_order',$value['f1_status_order']) == 'abandoned' ? ' selected="selected"' : '' }}>Abandoned</option>
                                <option value="pending_cancel" {{ old('f1_status_order',$value['f1_status_order']) == 'pending_cancel' ? ' selected="selected"' : '' }}>Pending Cancel</option>
                                <option value="complete" {{ old('f1_status_order',$value['f1_status_order']) == 'complete' ? ' selected="selected"' : '' }}>Complete</option>
                                <option value="cancel" {{ old('f1_status_order',$value['f1_status_order']) == 'cancel' ? ' selected="selected"' : '' }}>Cancel</option>
                            </select>
                    </td>
                </tr>
                <tr class="filterKontrak">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Status SM</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                            <select name="f1_status_sm" id="f1_status_sm">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="close" {{ old('f1_status_sm',$value['f1_status_sm']) == 'close' ? ' selected="selected"' : '' }}>CLOSE</option>
                                <option value="not_close" {{ old('f1_status_sm',$value['f1_status_sm']) == 'not_close' ? ' selected="selected"' : '' }}>NOT CLOSE</option>
                            </select>
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
                      @if($errors->has('f1_mitra_id'))
                      <select class="outline-input-merah" id="f1_mitra_id" name="f1_mitra_id" disabled>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @if(isset($mitra_vendor))
                          @foreach($mitra_vendor as $ind => $label)
                            <option value="{{ $label->id }}" {{ old('f1_mitra_id',$value['f1_mitra_id']) == $label->id ? ' selected="selected"' : '' }}>{{ $label->nama_mitra }}</option>
                          @endforeach
                        @endif
                        <option class="f1-nama-mitra-lain" value="lainnya">Lainnya</option>
                      </select>
                      @else
                      <select class="" id="f1_mitra_id" name="f1_mitra_id"  disabled>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @if(isset($mitra_vendor))
                          @foreach($mitra_vendor as $ind => $label)
                            <option value="{{ $label->id }}" {{ old('f1_mitra_id',$value['f1_mitra_id']) == $label->id ? ' selected="selected"' : '' }}>{{ $label->nama_mitra }}</option>
                          @endforeach
                        @endif
                      </select>
                      @endif
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
                        <input style="width:450px;" type="text" name="f1_pic_mitra" id="f1_pic_mitra" value="{{ old('f1_pic_mitra',$value['f1_pic_mitra']) }}">
                    </td>
                </tr>
                <tr class="filterKontrak"><td colspan="2"><hr></td></tr>
                <tr class="filterKontrak">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Keterangan</h6>
                            </div>
                        </div>
                    </td>
                    <td><textarea cols="50" rows="2" name="f1_keterangan" id="f1_keterangan" placeholder="INPUT KETERANGAN TERBARU">{{ old('f1_keterangan') }}</textarea>
                        @if( $value['f1_keterangan'] )
                        <br><table class="align-item-center">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TANGGAL</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">KETERANGAN</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class=" justify-content-center"><h6 class="text-sm">▶️ [{{ $value['f1_tgl_keterangan'] }}]</h6></td>
                              <td class="ps-4"><h6 class="text-sm">{{ $value['f1_keterangan'] }}</h6></td>
                            </tr>
                            @if(isset($table_edit_keterangan))
                              @foreach($table_edit_keterangan as $tunjuk => $nilai)
                                <tr>
                                  <td class=" justify-content-center">[{{ $nilai->f1_tgl_keterangan }}]</td>
                                  <td>{{ $nilai->f1_keterangan }}</td>
                                </tr>
                              @endforeach
                            @endif
                          </tbody>
                        </table>
                        @endif
                    </td>
                </tr>
                <tr class="filterKontrak"><td colspan="2"><br></td></tr>
                <tr class="filterKontrak"><td colspan="2">
                    <a href="{{ route('obl.tables') }}" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">KEMBALI</h6></a>
                    <button type="button" id="lanjutWO2" class="btn bg-gradient-success jenis_spk_wo"><h6 class="mb-0 text-sm" style="color:white;">Lanjutkan WO </h6></button>
                    <button type="button" id="lanjutFilter" class="btn bg-gradient-info jenis_spk_klsp"><h6 class="mb-0 text-sm" style="color:white;">Lanjutkan KL / SP</h6></button>
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
                            <input type="radio" id="f2_nilai_kontrak" name="f2_nilai_kontrak" value="dibawah_100" {{ old('f2_nilai_kontrak',$value['f2_nilai_kontrak']) == 'dibawah_100' ? "checked" : "" }}>
                            <label for="f2_nilai_kontrak"> < 100 Juta</label><br>
                            <input type="radio" id="f2_nilai_kontrak" name="f2_nilai_kontrak" value="diatas_100" {{ old('f2_nilai_kontrak',$value['f2_nilai_kontrak']) == 'diatas_100' ? "checked" : "" }}>
                            <label for="f2_nilai_kontrak"> > 100 Juta</label><br>
                    </td>
                </tr>
                <tr class="filterAwal">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Tanggal Terbit Form P1</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                      @if($errors->has('f2_tgl_p1'))
                        <input class="outline-input-merah" type="date" name="f2_tgl_p1" id="f2_tgl_p1" value="{{ old('f2_tgl_p1',$value['tgl_p1_all']) }}">
                      @else
                        <input type="date" name="f2_tgl_p1" id="f2_tgl_p1" value="{{ old('f2_tgl_p1',$value['tgl_p1_all']) }}">
                      @endif
                    </td>
                </tr>
                <tr class="filterAwal"><td colspan="2"><br></td></tr>
                <tr class="filterAwal"><td colspan="2">
                    <button type="button" id="backKontrak" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Filter Kontrak</h6></button>
                    <button type="button" id="lanjutP2" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P2</h6></button>
                    <button type="submit" name="submit" value="draf_filter_kl" id="saveDraf" class=" save-draf btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                </td></tr>
                <!-- P2 -->
                <tr class="formP2"><td colspan="2"><br></td></tr>
                <tr class="formP2"><td colspan="2"><h6 class="ps-2">FORM P2 – EVALUASI DAN PENETAPAN BAKAL CALON MITRA PELAKSANA </h6></td></tr>
                <tr class="formP2">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Tanggal Justifikasi Kebutuhan Penyedia Jasa dan Barang</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="date" name="p2_tgl_justifikasi" id="p2_tgl_justifikasi" value="{{ old('p2_tgl_justifikasi',$value['tgl_justifikasi']) }}">
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p2_dievaluasi_oleh',$value['p2_dievaluasi_oleh']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p2_dievaluasi_oleh',$value['p2_dievaluasi_oleh']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p2_dievaluasi_oleh',$value['p2_dievaluasi_oleh']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                            <option value="Hariyadi_800031" {{ old('p2_disetujui_oleh',$value['p2_disetujui_oleh']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Subroto Marzuki - 740130</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p2_disetujui_oleh',$value['p2_disetujui_oleh']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Taufik - 730206</option>
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
                            <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="setuju" {{ old('p2_pilihan_catatan',$value['p2_pilihan_catatan']) == 'setuju' ? "checked" : "" }}>
                            <label for="p2_pilihan_catatan"> Setuju</label><br>
                            <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="setuju_dgn_catatan" {{ old('p2_pilihan_catatan',$value['p2_pilihan_catatan']) == 'setuju_dgn_catatan' ? "checked" : "" }}>
                            <label for="p2_pilihan_catatan"> Setuju dengan Catatan</label><br>
                            <input type="radio" id="p2_pilihan_catatan" name="p2_pilihan_catatan" value="tidak_setuju" {{ old('p2_pilihan_catatan',$value['p2_pilihan_catatan']) == 'tidak_setuju' ? "checked" : "" }}>
                            <label for="p2_pilihan_catatan"> Tidak Setuju</label><br>
                            <textarea name="p2_catatan" id="p2_catatan" cols="50" rows="2">{{ old('p2_catatan',$value['p2_catatan']) }}</textarea>

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
                        <textarea cols="50" rows="2" name="p3_pejabat_mitra_alamat" id="p3_pejabat_mitra_alamat" placeholder="ALAMAT MITRA" style="width:350px;">{{ old('p3_pejabat_mitra_alamat',$value['p3_pejabat_mitra_alamat']) }}</textarea><br>
                        <input type="text" name="p3_pejabat_mitra_telepon" id="p3_pejabat_mitra_telepon" placeholder="TELEPON MITRA" style="width:350px;" value="{{ old('p3_pejabat_mitra_telepon',$value['p3_pejabat_mitra_telepon']) }}">
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
                                <h6 class="mb-0 text-sm">Waktu Delivery Layanan <i>(Ready for Service)</i></h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="date" name="p4_waktu_layanan" id="p4_waktu_layanan" value="{{ old('p4_waktu_layanan',$value['waktu_layanan']) }}">
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
                            <option value="sewa_murni" {{ old('p4_skema_bisnis',$value['p4_skema_bisnis']) == 'sewa_murni' ? ' selected="selected"' : '' }}>Sewa Murni</option>
                            <option value="sewa_beli" {{ old('p4_skema_bisnis',$value['p4_skema_bisnis']) == 'sewa_beli' ? ' selected="selected"' : '' }}>Sewa Beli</option>
                            <option value="beli_putus" {{ old('p4_skema_bisnis',$value['p4_skema_bisnis']) == 'beli_putus' ? ' selected="selected"' : '' }}>Pengadaan Beli Putus</option>
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
                            <option value="back_to_back" {{ old('p4_mekanisme_pembayaran',$value['p4_mekanisme_pembayaran']) == 'back_to_back' ? ' selected="selected"' : '' }}>Back To Back</option>
                            <option value="non_back_to_back" {{ old('p4_mekanisme_pembayaran',$value['p4_mekanisme_pembayaran']) == 'non_back_to_back' ? ' selected="selected"' : '' }}>Non Back To Back</option>
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
                        <input type="number" min="0" name="p4_slg" id="p4_slg" style="width:100px;" value="{{ old('p4_slg',$value['p4_slg']) }}"> %
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p4_fasilitator',$value['p4_fasilitator']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p4_fasilitator',$value['p4_fasilitator']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p4_fasilitator',$value['p4_fasilitator']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p4_pengesahan',$value['p4_pengesahan']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p4_pengesahan',$value['p4_pengesahan']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p4_pengesahan',$value['p4_pengesahan']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                              @if($errors->has('p4_attendees'))
                                  @if( old('p4_attendees') )
                                    @for($i = 0; $i < count(old('p4_attendees')); $i++ )
                                      <tr>
                                        <th scrope="row">{{ ($i + 1) }}</th>
                                        <td><input style="width:500px;" type="text" name="p4_attendees[]" id="p4_attendees" value="{{ old('p4_attendees.'.$i) }}"></td>
                                        <td><button style="float:left;margin-left:-20%;" type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>
                                      </tr>
                                    @endfor
                                  @endif
                              @else
                                  @if( isset($table_edit_p4_attendees) && $table_edit_p4_attendees )
                                    @foreach($table_edit_p4_attendees as $tunjuk => $nilai)
                                      <tr>
                                        <th scrope="row">{{ ($tunjuk + 1) }}</th>
                                        <td><input style="width:500px;" type="text" name="p4_attendees[]" id="p4_attendees" value="{{ old('p4_attendees.'.$tunjuk,$nilai['p4_attendees']) }}"></td>
                                        <td><button style="float:left;margin-left:-250%;" type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>
                                      </tr>
                                    @endforeach
                                  @endif
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
                        <input class="rupiahs" type="text" name="p5_harga_penawaran" id="p5_harga_penawaran" style="width:350px;" value="{{ old('p5_harga_penawaran',$value['p5_harga_penawaran']) }}">
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p5_ttd_evaluator',$value['p5_ttd_evaluator']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p5_ttd_evaluator',$value['p5_ttd_evaluator']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p5_ttd_evaluator',$value['p5_ttd_evaluator']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                        <input type="text" id="p6_ttd_bast_telkom" name="p6_ttd_bast_telkom" style="width:350px;" value="{{ old('p6_ttd_bast_telkom',$value['p6_ttd_bast_telkom']) }}">
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
                        <input type="text" id="p6_ttd_bast_mitra" name="p6_ttd_bast_mitra" style="width:350px;" value="{{ old('p6_ttd_bast_mitra',$value['p6_ttd_bast_mitra']) }}">
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
                        <input class="rupiahs" type="text" name="p6_harga_negosiasi" id="p6_harga_negosiasi" style="width:350px;" value="{{ old('p6_harga_negosiasi',$value['p6_harga_negosiasi']) }}">
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
                        <input type="text" name="p6_nama_peserta_mitra" id="p6_nama_peserta_mitra" style="width:350px;" value="{{ old('p6_nama_peserta_mitra',$value['p6_nama_peserta_mitra']) }}"><br>
                        <input type="text" style="width:350px;" id="p6_jabatan_peserta_mitra" name="p6_jabatan_peserta_mitra" value="{{ old('p6_jabatan_peserta_mitra',$value['p6_jabatan_peserta_mitra']) }}">
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p6_peserta_rapat_telkom',$value['p6_peserta_rapat_telkom']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p6_peserta_rapat_telkom',$value['p6_peserta_rapat_telkom']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p6_peserta_rapat_telkom',$value['p6_peserta_rapat_telkom']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p6_pengesahan',$value['p6_pengesahan']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p6_pengesahan',$value['p6_pengesahan']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p6_pengesahan',$value['p6_pengesahan']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                        <input type="number" name="p7_lampiran_berkas" id="p7_lampiran_berkas" style="width:100px;" min="0" value="{{ old('p7_lampiran_berkas',$value['p7_lampiran_berkas']) }}">
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
                        <input class="rupiahs" type="text" name="p7_harga_pekerjaan" id="p7_harga_pekerjaan" style="width:350px;" value="{{ old('p7_harga_pekerjaan',$value['p7_harga_pekerjaan']) }}"><br>
                    </td>
                </tr>
                <tr class="formP7">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Skema Pembayaran</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <select name="p7_skema_bayar" id="p7_skema_bayar">
                          <option value="" disabled>Pilih Skema</option>
                          <option value="otc" {{ old('p7_skema_bayar',$value['p7_skema_bayar']) == 'otc' ? ' selected="selected"' : '' }}> OTC </option>
                          <option value="recurring" {{ old('p7_skema_bayar',$value['p7_skema_bayar']) == 'recurring' ? ' selected="selected"' : '' }} > Recurring </option>
                          <option value="termin" {{ old('p7_skema_bayar',$value['p7_skema_bayar']) == 'termin' ? ' selected="selected"' : '' }} > Termin </option>
                          <option value="campuran" {{ old('p7_skema_bayar',$value['p7_skema_bayar']) == 'campuran' ? ' selected="selected"' : '' }} > OTC Recurring </option>
                        </select>
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
                            <option value="Didik_Kurniawan_Hadi_860113" {{ old('p7_pemeriksa',$value['p7_pemeriksa']) == 'Didik_Kurniawan_Hadi_860113' ? ' selected="selected"' : '' }}>Didik Kurniawan Hadi - 860113</option>
                            <option value="Hariyadi_800031" {{ old('p7_pemeriksa',$value['p7_pemeriksa']) == 'Hariyadi_800031' ? ' selected="selected"' : '' }}>Hariyadi - 800031</option>
                            <option value="Yayan_Nuryana_710516" {{ old('p7_pemeriksa',$value['p7_pemeriksa']) == 'Yayan_Nuryana_710516' ? ' selected="selected"' : '' }}>Yayan Nuryana - 710516</option>
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
                        <input type="text" style="width:350px;border:none;font-weight:bolder;" value="{{ $value['p7_tembusan'] }}" disabled><br>
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
                    <button type="submit" name="submit" value="draf_p8" id="saveDraf" class="save-draf-p8 btn bg-gradient-primary ms-10"><h6 class="mb-0 text-sm" style="color:white;">Simpan sebagai Draf</h6></button>
                </td></tr>
                <!-- WO -->
                <tr class="formWO"><td colspan="2"><br></td></tr>
                <tr class="formWO"><td colspan="2"><h6 class="ps-2">WORK ORDER ( WO )</h6></td></tr>
                <tr class="formWO">
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Tanggal Terbit FO (P1)</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                      @if($errors->has('wo_tgl_fo'))
                        <input class="outline-input-merah" type="date" name="wo_tgl_fo" id="wo_tgl_fo" value="{{ old('wo_tgl_fo') }}">
                      @else
                        <input type="date" name="wo_tgl_fo" id="wo_tgl_fo" value="{{ old('wo_tgl_fo',$value['tgl_p1_all']) }}">
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
                      @if(isset($value['f1_jenis_kontrak']))
                        @if( $value['f1_jenis_kontrak'] == 'perpanjangan' )
                          <datalist class="" id="list_nomor_kb">
                            @if(isset($list_nomor_kb))
                              @foreach($list_nomor_kb as $kunci => $nilai)
                                <option value="{{ $nilai['nomor_kb'] }}"  {{ old('wo_nomor_kb',$nilai['nomor_kb']) == $nilai['nomor_kb'] ? ' selected="selected"' : '' }}>{{ $nilai['nomor_kb'] }}</option>
                              @endforeach
                            @endif
                          </datalist>
                          <input type="text" name="wo_nomor_kb" id="wo_nomor_kb" style="width:400px;" list="list_nomor_kb">
                        @elseif( $value['f1_jenis_kontrak'] == 'baru' )
                          <input type="text" name="wo_nomor_kb" id="wo_nomor_kb" style="width:400px;" value="{{ old('wo_nomor_kb',$value['wo_nomor_kb']) }}">
                        @else
                          <input type="text" name="wo_nomor_kb" id="wo_nomor_kb" style="width:350px;">
                        @endif
                      @else
                        <input type="text" name="wo_nomor_kb" id="wo_nomor_kb" style="width:350px;">
                      @endif
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
                        <input type="text" name="wo_jenis_layanan" id="wo_jenis_layanan" style="width:350px;" value="{{ old('wo_jenis_layanan',$value['wo_jenis_layanan']) }}">
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
                        <input type="number" name="wo_jumlah_layanan" id="wo_jumlah_layanan" min="0" style="width:100px;" value="{{ old('wo_jumlah_layanan',$value['wo_jumlah_layanan']) }}">
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
                        <input class="rupiahs" type="text" name="wo_harga_ke_plggn" id="wo_harga_ke_plggn" style="width:350px;" value="{{ old('wo_harga_ke_plggn',$value['wo_harga_ke_plggn']) }}">
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
                        <input class="rupiahs" type="text" name="wo_onetime_charge_plggn" id="wo_onetime_charge_plggn" style="width:350px;" value="{{ old('wo_onetime_charge_plggn',$value['wo_onetime_charge_plggn']) }}">
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
                        <input class="rupiahs" type="text" name="wo_monthly_plggn" id="wo_monthly_plggn" style="width:350px;" value="{{ old('wo_monthly_plggn',$value['wo_monthly_plggn']) }}">
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
                        <input class="rupiahs" type="text" name="wo_onetime_charge_telkom" id="wo_onetime_charge_telkom" style="width:350px;" value="{{ old('wo_onetime_charge_telkom',$value['wo_onetime_charge_telkom']) }}">
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
                        <input type="number" min="0" name="wo_persen_telkom" id="wo_persen_telkom" style="width:100px;" value="{{ old('wo_persen_telkom',$value['wo_persen_telkom']) }}"> % atau sebesar
                        <input type="text" name="wo_monthly_telkom" id="wo_monthly_telkom" style="width:300px;" value="{{ old('wo_monthly_telkom',$value['wo_monthly_telkom']) }}">
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
                        <input class="rupiahs" type="text" name="wo_onetime_charge_mitra" id="wo_onetime_charge_mitra" style="width:350px;" value="{{ old('wo_onetime_charge_mitra',$value['wo_onetime_charge_mitra']) }}">
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
                        <input type="number" min="0" name="wo_persen_mitra" id="wo_persen_mitra" style="width:100px;" value="{{ old('wo_persen_mitra',$value['wo_persen_mitra']) }}"> % atau sebesar
                        <input type="text" name="wo_monthly_mitra" id="wo_monthly_mitra" style="width:300px;" value="{{ old('wo_monthly_mitra',$value['wo_monthly_mitra']) }}">
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
                        @if(isset($value['f1_jenis_kontrak']))
                          @if( $value['f1_jenis_kontrak'] == 'perpanjangan' )
                            <datalist class="" id="list_nomor_kb">
                              @if(isset($list_nomor_kb))
                                @foreach($list_nomor_kb as $kunci => $nilai)
                                  <option value="{{ $nilai['nomor_kb'] }}"  {{ old('sp_nomor_kb',$nilai['nomor_kb']) == $nilai['nomor_kb'] ? ' selected="selected"' : '' }}>{{ $nilai['nomor_kb'] }}</option>
                                @endforeach
                              @endif
                            </datalist>
                            <input type="text" name="sp_nomor_kb" id="sp_nomor_kb" style="width:400px;" list="list_nomor_kb">
                          @elseif( $value['f1_jenis_kontrak'] == 'baru' )
                            <input type="text" name="sp_nomor_kb" id="sp_nomor_kb" style="width:400px;" value="{{ old('sp_nomor_kb',$value['sp_nomor_kb']) }}">
                          @else
                            <input type="text" name="sp_nomor_kb" id="sp_nomor_kb" style="width:400px;">
                          @endif
                        @else
                          <input type="text" name="sp_nomor_kb" id="sp_nomor_kb" style="width:400px;">
                        @endif
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
                      @if(isset($value['f1_jenis_kontrak']))
                        @if( $value['f1_jenis_kontrak'] == 'perpanjangan' )
                          <datalist class="" id="list_nomor_kb">
                            @if(isset($list_nomor_kb))
                              @foreach($list_nomor_kb as $kunci => $nilai)
                                <option value="{{ $nilai['nomor_kb'] }}"  {{ old('kl_nomor_kb',$nilai['nomor_kb']) == $nilai['nomor_kb'] ? ' selected="selected"' : '' }}>{{ $nilai['nomor_kb'] }}</option>
                              @endforeach
                            @endif
                          </datalist>
                          <input type="text" name="kl_nomor_kb" id="kl_nomor_kb" style="width:400px;" list="list_nomor_kb">
                        @elseif( $value['f1_jenis_kontrak'] == 'baru' )
                          <input type="text" name="kl_nomor_kb" id="kl_nomor_kb" style="width:400px;" value="{{ old('kl_nomor_kb',$value['kl_nomor_kb']) }}">
                        @else
                          <input type="text" name="kl_nomor_kb" id="kl_nomor_kb" style="width:350px;">
                        @endif
                      @else
                        <input type="text" name="kl_nomor_kb" id="kl_nomor_kb" style="width:350px;">
                      @endif
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
                        <input type="text" name="kl_no_kl_mitra" id="kl_no_kl_mitra" style="width:300px;" value="{{ old('kl_no_kl_mitra',$value['kl_no_kl_mitra']) }}">
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
                        <input type="text" name="kl_tempat_ttd_kl" id="kl_tempat_ttd_kl" style="width:300px;" value="{{ old('kl_tempat_ttd_kl',$value['kl_tempat_ttd_kl']) }}">
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
                        <input type="text" name="kl_notaris" id="kl_notaris" style="width:300px;" value="{{ old('kl_notaris',$value['kl_notaris']) }}">
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
                        <input type="text" name="kl_akta_notaris" id="kl_akta_notaris" style="width:300px;" value="{{ old('kl_akta_notaris',$value['kl_akta_notaris']) }}">
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
                        <input type="date" name="kl_tgl_akta_notaris" id="kl_tgl_akta_notaris" style="width:300px;" value="{{ old('kl_tgl_akta_notaris',$value['tgl_akta_notaris']) }}">
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
                        <input type="text" name="kl_nama_pejabat_telkom" id="kl_nama_pejabat_telkom" style="width:300px;" value="{{ old('kl_nama_pejabat_telkom',$value['kl_nama_pejabat_telkom']) }}">
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
                        <input type="text" name="kl_jabatan_pejabat_telkom" id="kl_jabatan_pejabat_telkom" style="width:300px;" value="{{ old('kl_jabatan_pejabat_telkom',$value['kl_jabatan_pejabat_telkom']) }}">
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
                        <input type="text" name="kl_npwp_mitra" id="kl_npwp_mitra" style="width:300px;" value="{{ old('kl_npwp_mitra',$value['kl_npwp_mitra']) }}">
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
                        <input type="text" name="kl_no_anggaran_mitra" id="kl_no_anggaran_mitra" style="width:300px;" value="{{ old('kl_no_anggaran_mitra',$value['kl_no_anggaran_mitra']) }}">
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
                        <input type="date" name="kl_tgl_anggaran_mitra" id="kl_tgl_anggaran_mitra" style="width:300px;" value="{{ old('kl_tgl_anggaran_mitra',$value['tgl_anggaran_mitra']) }}">
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
                        <input type="text" name="kl_nama_pejabat_mitra" id="kl_nama_pejabat_mitra" style="width:300px;" value="{{ old('kl_nama_pejabat_mitra',$value['kl_nama_pejabat_mitra']) }}">
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
                        <input type="text" name="kl_jabatan_pejabat_mitra" id="kl_jabatan_pejabat_mitra" style="width:300px;" value="{{ old('kl_jabatan_pejabat_mitra',$value['kl_jabatan_pejabat_mitra']) }}">
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
                        <input type="text" name="kl_no_skm" id="kl_no_skm" style="width:300px;" value="{{ old('kl_no_skm',$value['kl_no_skm']) }}">
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
                        <input type="date" name="kl_tgl_skm" id="kl_tgl_skm" style="width:300px;" value="{{ old('kl_tgl_skm',$value['tgl_skm']) }}">
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
                        <input type="text" name="kl_perihal_skm" id="kl_perihal_skm" style="width:300px;" value="{{ old('kl_perihal_skm',$value['kl_perihal_skm']) }}">
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
                        <input type="date" name="kl_tgl_akhir_kl" id="kl_tgl_akhir_kl" style="width:300px;" value="{{ old('kl_tgl_akhir_kl',$value['tgl_akhir_kl']) }}">
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
                        <input type="text" name="kl_bayar_dp" id="kl_bayar_dp" style="width:300px;" value="{{ old('kl_bayar_dp',$value['kl_bayar_dp']) }}">
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
                        <input type="text" name="kl_nama_bank_mitra" id="kl_nama_bank_mitra" style="width:300px;" value="{{ old('kl_nama_bank_mitra',$value['kl_nama_bank_mitra']) }}">
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
                        <input type="text" name="kl_cabang_bank_mitra" id="kl_cabang_bank_mitra" style="width:300px;" value="{{ old('kl_cabang_bank_mitra',$value['kl_cabang_bank_mitra']) }}">
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
                        <input type="text" name="kl_rek_bank_mitra" id="kl_rek_bank_mitra" style="width:300px;" value="{{ old('kl_rek_bank_mitra', $value['kl_rek_bank_mitra'] ) }}">
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
                        <input type="text" name="kl_an_bank_mitra" id="kl_an_bank_mitra" style="width:300px;" value="{{ old('kl_an_bank_mitra',$value['kl_an_bank_mitra']) }}">
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
            @endforeach
            </tbody>
        </table>
    </div>
</div>
