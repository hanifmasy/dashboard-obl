<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="witels"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="FORM P0-P1"></x-navbars.navs.auth>
            <!-- End Navbar -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">FORM P0-P1</h6>
                                </div>
                            </div>

                            <form id="formObl"  action="{{ route('witels.forms.create') }}" method="POST" enctype="multipart/form-data">
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
                                            <tr >
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h5 class="mb-0 text-sm">FORM P0</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Dokumen P0</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <input style="width:350px;" type="text" name="p0_nomor_p0" id="p0_nomor_p0"  value="{{ $witel_form->p0_nomor_p0 ? $witel_form->p0_nomor_p0 : '' }}" required>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Dibuat Oleh (Nama/NIK) AM</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="p0_nik_am" id="p0_nik_am" style="width:350px;" value="{{ $witel_form->p0_nik_am ? $witel_form->p0_nik_am : '' }}" >
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Diperiksa Oleh (Nama/NIK) Manager</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <input type="text" name="p0_nik_manager" id="p0_nik_manager" style="width:350px;" value="{{ $witel_form->p0_nik_manager ? $witel_form->p0_nik_manager : '' }}" >

                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jabatan Pemerika</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <select class="" name="p0_pemeriksa" id="p0_pemeriksa">
                                                    <option value="" disabled selected>Pilih Pemeriksa</option>
                                                    <option value="business_service" value="{{ $witel_form->p0_pemeriksa == 'business_service' ? ' selected="selected"' : '' }}">Manager BUSINESS service Witel {{ $witel_form->f1_witel ? $witel_form->f1_witel : ''  }}</option>
                                                    <option value="government_service" value="{{ $witel_form->p0_pemeriksa == 'government_service' ? ' selected="selected"' : '' }}">Manager GOVERNMENT service Witel {{ $witel_form->f1_witel ? $witel_form->f1_witel : ''  }}</option>
                                                    <option value="enterprise_service" value="{{ $witel_form->p0_pemeriksa == 'enterprise_service' ? ' selected="selected"' : '' }}">Manager ENTERPRISE service Witel {{ $witel_form->f1_witel ? $witel_form->f1_witel : ''  }}</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Disetujui Oleh (Nama/NIK) GM</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <input type="text" name="p0_nik_gm" id="p0_nik_gm" style="width:350px;" value="{{ $witel_form->p0_nik_gm ? $witel_form->p0_nik_gm : '' }}" >
                                                </td>
                                            </tr>
                                            <tr ><td colspan="2"><hr></td></tr>
                                            <tr >
                                                <td colspan="2">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h5 class="mb-0 text-sm">FORM P1</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Dokumen P1</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <input type="text" name="p1_nomor_p1" id="p1_nomor_p1" value="{{ $witel_form->p1_nomor_p1 ? $witel_form->p1_nomor_p1 : '' }}" style="width:350px;" required>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Delivery</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <input type="date" name="p1_tgl_delivery" id="p1_tgl_delivery" autocomplete="off" value="{{ $witel_form->tgl_delivery_p1 ? $witel_form->tgl_delivery_p1 : '' }}" style="width:350px;">
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lokasi Instalasi</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <input type="text" name="p1_lokasi_instal" id="p1_lokasi_instal" autocomplete="off" value="{{ $witel_form->p1_lokasi_instal ? $witel_form->p1_lokasi_instal : '' }}" style="width:350px;">
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Bisnis</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <select name="p1_skema_bisnis" id="p1_skema_bisnis">
                                                      <option value="" disabled selected>Pilih Skema Bisnis</option>
                                                      <option value="sewa_murni" {{ $witel_form->p1_skema_bisnis == 'sewa_murni' ? ' selected="selected"' : '' }}>Sewa Murni</option>
                                                      <option value="sewa_beli" {{ $witel_form->p1_skema_bisnis == 'sewa_beli' ? ' selected="selected"' : '' }}>Sewa Beli</option>
                                                      <option value="beli_putus" {{ $witel_form->p1_skema_bisnis == 'beli_putus' ? ' selected="selected"' : '' }}>Pengadaan Beli Putus</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Pembayaran</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <select name="p1_skema_bayar" id="p1_skema_bayar">
                                                      <option value="" disabled selected>Pilih Skema</option>
                                                      <option value="otc" {{ $witel_form->p1_skema_bayar == 'otc' ? ' selected="selected"' : '' }}>OTC</option>
                                                      <option value="recurring" {{ $witel_form->p1_skema_bayar == 'recurring' ? ' selected="selected"' : '' }}>Recurring</option>
                                                      <option value="termin" {{ $witel_form->p1_skema_bayar == 'termin' ? ' selected="selected"' : '' }}>Termin</option>
                                                      <option value="otc_recurring" {{ $witel_form->p1_skema_bayar == 'otc_recurring' ? ' selected="selected"' : '' }}>OTC Recurring</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Term of Payment</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                  <select name="p1_mekanisme_bayar" id="p1_mekanisme_bayar">
                                                      <option value="" disabled selected>Pilih Mekanisme</option>
                                                      <option value="back_to_back" {{ $witel_form->p1_mekanisme_bayar == 'back_to_back' ? ' selected="selected"' : '' }}>Back To Back</option>
                                                      <option value="non_back_to_back" {{ $witel_form->p1_mekanisme_bayar == 'non_back_to_back' ? ' selected="selected"' : '' }}>Non Back To Back</option>
                                                  </select>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Masa Kontrak Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     Mulai: <input type="date" name="p1_tgl_kontrak_mulai" id="p1_tgl_kontrak_mulai" value="{{ $witel_form->tgl_kontrak_mulai_p1 ? $witel_form->tgl_kontrak_mulai_p1 : '' }}">
                                                     Hingga: <input type="date" name="p1_tgl_kontrak_akhir" id="p1_tgl_kontrak_akhir" value="{{ $witel_form->tgl_kontrak_akhir_p1 ? $witel_form->tgl_kontrak_akhir_p1 : '' }}">
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Submit Dokumen ke Pelanggan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <input type="date" name="p1_tgl_doc_plggn" id="p1_tgl_doc_plggn" autocomplete="off" value="{{ $witel_form->tgl_doc_plggn_p1 ? $witel_form->tgl_doc_plggn_p1 : '' }}" style="width:350px;">
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Estimasi Harga</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="p1_estimasi_harga" id="p1_estimasi_harga" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ $witel_form->p1_estimasi_harga ? $witel_form->p1_estimasi_harga : '' }}" autocomplete="off">
                                                </td>
                                            </tr>
                                            <tr ><td colspan="2"><br></td></tr>
                                            <tr ><td colspan="2">
                                                <input type="text" name="obl_id" value="{{ isset($obl_id) ? $obl_id : '' }}" hidden>
                                                <a href="{{ route('obl.tables') }}" class="btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm text-black">KEMBALI</h6></a>
                                                <button type="submit" class="btn bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">SIMPAN</h6></button>
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
        @push('js')
        <script>

            $( document ).ready(function() {

                // STARTLINE: FORMAT RUPIAH
                var rupiah = document.getElementById('p1_estimasi_harga');
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
