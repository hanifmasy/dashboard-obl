@props([
    'table_edit','mitra_vendor'
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
                <!-- filter kontrak -->
                <tr ><td colspan="2"><br></td></tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Quote</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                      @if($errors->has('f1_quote_kontrak'))
                      <input style="width:350px;" class="outline-input-merah" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak',$table_edit[0]['f1_quote_kontrak']) }}" autocomplete="off" required>
                      @else
                      <input style="width:350px;" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak',$table_edit[0]['f1_quote_kontrak']) }}" autocomplete="off" required>
                      @endif
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Nomor Akun</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input style="width:350px;" type="text" name="f1_nomor_akun" id="f1_nomor_akun" value="{{ old('f1_nomor_akun',$table_edit[0]['f1_nomor_akun']) }}" autocomplete="off">
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Nilai KB</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input class="rupiahs" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb',$table_edit[0]['f1_nilai_kb']) }}" autocomplete="off">
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Nama Layanan</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($errors->has('f1_judul_projek'))
                          <textarea type="text" cols="50" rows="2" class="outline-input-merah" name="f1_judul_projek" id="f1_judul_projek" autocomplete="off" required>{{ old('f1_judul_projek',$table_edit[0]['f1_judul_projek']) }}</textarea>
                        @else
                          <textarea type="text" cols="50" rows="2" name="f1_judul_projek" id="f1_judul_projek" autocomplete="off" required>{{ old('f1_judul_projek',$table_edit[0]['f1_judul_projek']) }}</textarea>
                        @endif
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Pelanggan</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($errors->has('f1_nama_plggn'))
                          <input style="width:450px;" class="outline-input-merah" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn',$table_edit[0]['f1_nama_plggn']) }}" autocomplete="off" required><br><br>
                        @else
                          <input style="width:450px;" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn',$table_edit[0]['f1_nama_plggn']) }}" autocomplete="off" required><br><br>
                        @endif
                        <textarea cols="50" rows="2" id="f1_alamat_plggn" name="f1_alamat_plggn" placeholder="ALAMAT PELANGGAN" autocomplete="off">{{ old('f1_alamat_plggn',$table_edit[0]['f1_alamat_plggn']) }}</textarea>
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Nama Vendor</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                      @if($errors->has('f1_mitra_id'))
                      <select class="outline-input-merah" id="f1_mitra_id" name="f1_mitra_id" required>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @if(isset($mitra_vendor))
                          @foreach($mitra_vendor as $key => $value)
                            <option value="{{ $value->id }}" {{ old('f1_mitra_id',$table_edit[0]['f1_mitra_id']) == $value->id ? ' selected="selected"' : '' }}>{{ $value->nama_mitra }}</option>
                          @endforeach
                        @endif
                      </select>
                      @else
                      <select class="" id="f1_mitra_id" name="f1_mitra_id" required>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @if(isset($mitra_vendor))
                          @foreach($mitra_vendor as $key => $value)
                            <option value="{{ $value->id }}" {{ old('f1_mitra_id',$table_edit[0]['f1_mitra_id']) == $value->id ? ' selected="selected"' : '' }}>{{ $value->nama_mitra }}</option>
                          @endforeach
                        @endif
                      </select>
                      @endif
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Segmen</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($errors->has('f1_segmen'))
                        <select name="f1_segmen" id="f1_segmen" class="outline-input-merah" required>
                            <option value="" disabled selected>Pilih Segmen</option>
                            <option value="DES" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                            <option value="DGS" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                            <option value="DBS" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                        </select>
                        @else
                        <select name="f1_segmen" id="f1_segmen" required>
                            <option value="" disabled selected>Pilih Segmen</option>
                            <option value="DES" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                            <option value="DGS" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                            <option value="DBS" {{ old('f1_segmen',$table_edit[0]['f1_segmen']) == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                        </select>
                        @endif
                    </td>
                </tr>
                <tr >
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
                                <option value="otc" {{ old('f1_skema_bayar',$table_edit[0]['f1_skema_bayar']) == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                <option value="recurring" {{ old('f1_skema_bayar',$table_edit[0]['f1_skema_bayar']) == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                <option value="termin" {{ old('f1_skema_bayar',$table_edit[0]['f1_skema_bayar']) == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                <option value="otc_recurring" {{ old('f1_skema_bayar',$table_edit[0]['f1_skema_bayar']) == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
                            </select>
                    </td>
                </tr>
                <tr >
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">PIC Customer (Nama)</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="f1_pic_plggn" id="f1_pic_plggn" style="width:350px;" value="{{ old('f1_pic_plggn',$table_edit[0]['f1_pic_plggn']) }}" autocomplete="off">
                    </td>
                </tr>
                <tr >
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
                                <option value="inprogress_provision_issued" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_provision_issued' ? ' selected="selected"' : '' }}>In Progress - Provision Issued</option>
                                <option value="inprogress_provision_start" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_provision_start' ? ' selected="selected"' : '' }}>In Progress - Provision Start</option>
                                <option value="inprogress_provision_failed" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_provision_failed' ? ' selected="selected"' : '' }}>In Progress - Provision Failed</option>
                                <option value="inprogress_provision_complete" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_provision_complete' ? ' selected="selected"' : '' }}>In Progress - Provision Complete</option>
                                <option value="inprogress_pending_billing" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_pending_billing' ? ' selected="selected"' : '' }}>In Progress - Pending Billing</option>
                                <option value="inprogress_tsq_start" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_tsq_start' ? ' selected="selected"' : '' }}>In Progress - TSQ Start</option>
                                <option value="inprogress_provision_designed" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_provision_designed' ? ' selected="selected"' : '' }}>In Progress - Provision Designed</option>
                                <option value="approval" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'approval' ? ' selected="selected"' : '' }}>Approval</option>
                                <option value="submit" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'submit' ? ' selected="selected"' : '' }}>Submit</option>
                                <option value="failed_provision_failed" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'failed_provision_failed' ? ' selected="selected"' : '' }}>Failed - Provision Failed</option>
                                <option value="inprogress_fullfill_billing_start" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'inprogress_fullfill_billing_start' ? ' selected="selected"' : '' }}>In Progress - Fullfill Billing Start</option>
                                <option value="pending_baso" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'pending_baso' ? ' selected="selected"' : '' }}>Pending BASO</option>
                                <option value="failed_fullfill_billing_failed" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'failed_fullfill_billing_failed' ? ' selected="selected"' : '' }}>Failed - Fullfill Billing Failed</option>
                                <option value="fullfill_billing_complete" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'fullfill_billing_complete' ? ' selected="selected"' : '' }}>Fullfill Billing Complete</option>
                                <option value="abandoned" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'abandoned' ? ' selected="selected"' : '' }}>Abandoned</option>
                                <option value="pending_cancel" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'pending_cancel' ? ' selected="selected"' : '' }}>Pending Cancel</option>
                                <option value="complete" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'complete' ? ' selected="selected"' : '' }}>Complete</option>
                                <option value="cancel" {{ old('f1_status_order',$table_edit[0]['f1_status_order']) == 'cancel' ? ' selected="selected"' : '' }}>Cancel</option>
                            </select>
                    </td>
                </tr>
                <tr ><td colspan="2"><br></td></tr>
                <tr ><td colspan="2">
                    <input type="text" name="edit_obl_id" value="{{ $table_edit[0]['id'] ? $table_edit[0]['id'] : '' }}" hidden>
                    <a href="{{ route('obl.tables') }}" class="btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm">KEMBALI</h6></a>
                    <button type="submit" name="submit" value="submit_witel"  class="btn bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">SIMPAN EDIT</h6></button>
                </td></tr>

            </tbody>
        </table>
    </div>
</div>
