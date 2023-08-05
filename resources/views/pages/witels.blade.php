<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="witels"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="WITEL / Input Form"></x-navbars.navs.auth>
            <!-- End Navbar -->

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
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Input Form</h6>
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

                            <form id="formObl" action="{{ route('witels.create') }}" method="POST" enctype="multipart/form-data">
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
                                                    <input style="width:350px;" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak','') }}">
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
                                                    <input style="width:350px;" type="text" name="f1_nomor_akun" id="f1_nomor_akun" value="{{ old('f1_nomor_akun','') }}">
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
                                                    <input class="rupiahs" type="text" name="f1_nilai_kb" id="f1_nilai_kb" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ old('f1_nilai_kb','') }}">
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
                                                      <textarea type="text" cols="50" rows="2" class="outline-input-merah" name="f1_judul_projek" id="f1_judul_projek">{{ old('f1_judul_projek','') }}</textarea>
                                                    @else
                                                      <textarea type="text" cols="50" rows="2" name="f1_judul_projek" id="f1_judul_projek">{{ old('f1_judul_projek','') }}</textarea>
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
                                                      <input style="width:450px;" class="outline-input-merah" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn','') }}"><br><br>
                                                    @else
                                                      <input style="width:450px;" type="text" id="f1_nama_plggn" name="f1_nama_plggn" placeholder="NAMA PELANGGAN" value="{{ old('f1_nama_plggn','') }}"><br><br>
                                                    @endif
                                                    <textarea cols="50" rows="2" id="f1_alamat_plggn" name="f1_alamat_plggn" placeholder="ALAMAT PELANGGAN">{{ old('f1_alamat_plggn','') }}</textarea>
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
                                                  @if($errors->has('f1_nama_mitra'))
                                                  <select class="outline-input-merah" id="f1_nama_mitra" name="f1_nama_mitra">
                                                    <option value="" disabled selected>Pilih Vendor</option>
                                                    @if(isset($mitra_vendor))
                                                      @foreach($mitra_vendor as $key => $value)
                                                        <option value="{{ $value }}" {{ old('f1_nama_mitra') == $value ? ' selected="selected"' : '' }}>{{ $value }}</option>
                                                      @endforeach
                                                    @endif
                                                  </select>
                                                  @else
                                                  <select class="" id="f1_nama_mitra" name="f1_nama_mitra" >
                                                    <option value="" disabled selected>Pilih Vendor</option>
                                                    @if(isset($mitra_vendor))
                                                      @foreach($mitra_vendor as $key => $value)
                                                        <option value="{{ $value }}" {{ old('f1_nama_mitra') == $value ? ' selected="selected"' : '' }}>{{ $value }}</option>
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
                                                    <select name="f1_segmen" id="f1_segmen" class="outline-input-merah">
                                                        <option value="" disabled selected>Pilih Segmen</option>
                                                        <option value="DES" {{ old('f1_segmen') == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                                                        <option value="DGS" {{ old('f1_segmen') == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                                                        <option value="DBS" {{ old('f1_segmen') == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                                                    </select>
                                                    @else
                                                    <select name="f1_segmen" id="f1_segmen">
                                                        <option value="" disabled selected>Pilih Segmen</option>
                                                        <option value="DES" {{ old('f1_segmen') == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                                                        <option value="DGS" {{ old('f1_segmen') == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                                                        <option value="DBS" {{ old('f1_segmen') == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
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
                                                            <option value="otc" {{ old('f1_skema_bayar') == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                                            <option value="recurring" {{ old('f1_skema_bayar') == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                                            <option value="termin" {{ old('f1_skema_bayar') == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                                            <option value="otc_recurring" {{ old('f1_skema_bayar') == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
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
                                                    <input type="text" name="f1_pic_plggn" id="f1_pic_plggn" style="width:350px;" value="{{ old('f1_pic_plggn') }}">
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
                                            <tr ><td colspan="2"><br></td></tr>
                                            <tr ><td colspan="2">
                                                <button type="submit" name="submit" value="submit_witel" class="btn bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">Submit</h6></button>
                                            </td></tr>

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

                // STARTLINE: FORMAT RUPIAH
                var rupiah = document.getElementById('f1_nilai_kb');
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

            });

        </script>
        @endpush
</x-layout>
