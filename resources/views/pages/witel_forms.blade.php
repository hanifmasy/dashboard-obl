<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="witels-forms"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="FORM P1"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <style media="screen">
              .show-p0{ display: none; }
            </style>

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                              @if( isset($user_in_is) )
                                @if( $user_in_is->role_id === 4 )
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">FORM P1</h6>
                                </div>
                                @elseif( $user_in_is->role_id === 8 || $user_in_is->role_id === 13 || $user_in_is->role_id === 9 )
                                <div class="border-radius-lg pt-4 pb-3" style="background:#2a623d;">
                                    <h6 class="text-white text-capitalize ps-3">FORM P1</h6>
                                </div>
                                @endif
                              @endif
                            </div>

                            <form id="formObl"  action="{{ route('witels.forms.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if( isset($user_in_is) )
                              @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 || $user_in_is->role_id === 13 || $user_in_is->role_id === 9 )
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
                                                              <h5 class="mb-0 text-sm"><b>FORM P1</b></h5>
                                                          </div>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Tanggal P1</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <input type="date" name="p1_tgl_p1" id="p1_tgl_p1" value="{{ $witel_form->tgl_p1 ? $witel_form->tgl_p1 : '' }}" style="width:350px;" autocomplete="off">
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
                                                       <input type="text" name="p1_nomor_p1" id="p1_nomor_p1" value="{{ $witel_form->p1_nomor_p1 ? $witel_form->p1_nomor_p1 : '' }}" style="width:350px;" autocomplete="off">
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
                                                    <select name="f1_segmen" id="f1_segmen" autocomplete="off">
                                                        <option value="" disabled selected>Pilih Segmen</option>
                                                        <option value="DES" {{ old('f1_segmen', $witel_form->f1_segmen) == 'DES' ? ' selected="selected"' : '' }}>DES</option>
                                                        <option value="DGS" {{ old('f1_segmen', $witel_form->f1_segmen) == 'DGS' ? ' selected="selected"' : '' }}>DGS</option>
                                                        <option value="DBS" {{ old('f1_segmen', $witel_form->f1_segmen) == 'DBS' ? ' selected="selected"' : '' }}>DBS</option>
                                                    </select>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Witel</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <input type="text" value="{{ $witel_form->f1_witel ? $witel_form->f1_witel : '' }}" class="border-0 font-weight-bolder" disabled>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Nama Kegiatan</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <textarea name="f1_judul_projek" cols="50" class="font-weight-bolder" autocomplete="off">{{ $witel_form->f1_judul_projek ? $witel_form->f1_judul_projek : '' }}</textarea>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Total Nilai</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                      <input class="rupiahs" type="text" name="p1_estimasi_harga" id="p1_estimasi_harga" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-" value="{{ $witel_form->p1_estimasi_harga ? $witel_form->p1_estimasi_harga : '' }}" autocomplete="off">
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Saat Penggunaan</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <input type="date" name="p1_tgl_delivery" id="p1_tgl_delivery" autocomplete="off" value="{{ $witel_form->tgl_delivery_p1 ? $witel_form->tgl_delivery_p1 : '' }}" style="width:350px;">
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td colspan="2">
                                                      <hr>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Latar Belakang</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <textarea name="p1_paragraf" rows="2" cols="60">{{ $witel_form->p1_paragraf ? $witel_form->p1_paragraf : '' }}</textarea>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Aspek Strategis</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <textarea name="p1_aspek_strategis" rows="2" cols="60">{{ $witel_form->p1_aspek_strategis ? $witel_form->p1_aspek_strategis : '' }}</textarea>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Lingkup Kerja</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <textarea name="p1_lingkup_kerja" rows="2" cols="60">{{ $witel_form->p1_lingkup_kerja ? $witel_form->p1_lingkup_kerja : '' }}</textarea>
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
                                                       <input type="text" name="p1_lokasi_instal" id="p1_lokasi_instal" autocomplete="off" value="{{ $witel_form->p1_lokasi_instal ? $witel_form->p1_lokasi_instal : '' }}" style="width:500px;">
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td colspan="2">
                                                      <hr>
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
                                                              <h6 class="mb-0 text-sm">Skema Bayar</h6>
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
                                                              <h6 class="mb-0 text-sm">Mekanisme Bayar</h6>
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
                                                  <td colSpan="2"><hr></td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Rekomendasi Calon Mitra (Bila Spesifik)</h6>
                                                              <p class="text-xs text-secondary mb-0">
                                                                  *Input ini terkunci setelah form disimpan</p>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <select class="" id="f1_mitra_id" name="f1_mitra_id" >
                                                      <option value="" disabled selected>Pilih Vendor</option>
                                                      @if( $witel_form->f1_mitra_id )
                                                        <option disabled selected value="{{ $witel_form->f1_mitra_id }}" > {{ $witel_form->nama_mitra }} </option>
                                                      @elseif(isset($mitra_vendor))
                                                        @foreach($mitra_vendor as $key => $value)
                                                          <option value="{{ $value['id'] }}" >{{ $value['nama_mitra'] }}</option>
                                                        @endforeach
                                                      @endif
                                                    </select>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm"><i>Service Level Guarantee</i> (SLG)</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                       <input type="text" name="p1_slg" id="p1_slg" autocomplete="off" value="{{ $witel_form->p1_slg ? $witel_form->p1_slg : '' }}" style="width:60px;"> %
                                                  </td>
                                              </tr>

                                              <tr  class="show-p0"><td colspan="2"><hr></td></tr>
                                              <tr class="show-p0">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h5 class="mb-0 text-sm"><b>FORM P0</b></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                </td>
                                              </tr>
                                              <tr class="show-p0">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal P0</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                  <input style="width:350px;" autocomplete="off" type="date" name="p0_tgl_submit" value="{{ $witel_form->tgl_submit_p0 ? $witel_form->tgl_submit_p0 : '' }}">
                                                </td>
                                              </tr>
                                              <tr class="show-p0">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor P0</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                  <input style="width:350px;" autocomplete="off" type="text" name="p0_nomor_p0" value="{{ $witel_form->p0_nomor_p0 ? $witel_form->p0_nomor_p0 : '' }}">
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colSpan="2"><hr></td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Dibuat Oleh</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <select name="p1_dibuat_am" id="p1_dibuat_am">
                                                        <option value="" disabled selected autocomplete="off">Pilih Account Manager</option>
                                                        @if( isset($acc_mgr) )
                                                          @if( $acc_mgr )
                                                            @foreach( $acc_mgr as $key => $value )
                                                            <option value="{{ $value->nama_nik }}" {{ $value->nama_nik === $witel_form->p1_dibuat_am ? ' selected="selected" ' : '' }}>{{ $value->nama_nik }}</option>
                                                            @endforeach
                                                          @endif
                                                        @endif
                                                    </select>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Diperiksa Oleh</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <select name="p1_diperiksa_manager" id="p1_diperiksa_manager">
                                                        <option value="" disabled selected autocomplete="off">Pilih Manager</option>
                                                        @if( isset($mgr_service) )
                                                          @if( $mgr_service )
                                                            @foreach( $mgr_service as $key => $value )
                                                            <option value="{{ $value->id }}" {{ $value->nama_nik === $witel_form->p1_diperiksa_manager ? ' selected="selected" ' : '' }}>{{ $value->nama_nik }}</option>
                                                            @endforeach
                                                          @endif
                                                        @endif
                                                    </select>
                                                  </td>
                                              </tr>
                                              <tr >
                                                  <td>
                                                      <div class="d-flex px-2 py-1">
                                                          <div class="d-flex flex-column justify-content-center">
                                                              <h6 class="mb-0 text-sm">Disetujui Oleh</h6>
                                                          </div>
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <select name="p1_disetujui_gm" id="p1_disetujui_gm">
                                                        <option value="" disabled selected autocomplete="off">Pilih GM</option>
                                                        @if( isset($gm_witel) )
                                                          @if( $gm_witel )
                                                            @foreach( $gm_witel as $key => $value )
                                                            <option value="{{ $value->nama_nik }}" {{ $value->nama_nik === $witel_form->p1_disetujui_gm ? ' selected="selected" ' : '' }}>{{ $value->nama_nik }}</option>
                                                            @endforeach
                                                          @endif
                                                        @endif
                                                    </select>
                                                  </td>
                                              </tr>
                                              <tr>
                                                <td colSpan="2"><hr></td>
                                              </tr>
                                              <tr class="button-p0">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Form P0</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                  <button type="button" id="show_p0" class="btn btn-md bg-gradient-secondary"><h6 class="mb-0 text-sm text-white"></h6> SHOW</button>
                                                </td>
                                              </tr>
                                              <tr ><td colspan="2">
                                                  <input type="text" name="obl_id" value="{{ isset($obl_id) ? $obl_id : '' }}" hidden>
                                                  <input type="text" name="encrypted" value="{{ isset($encrypted) ? $encrypted : '' }}" hidden>
                                                  @if( isset($user_in_is) )
                                                    @if( $user_in_is->role_id === 4 )
                                                      @if( $encrypted )
                                                      <a href="{{ route('witels.pralop.detail',['edit_pralop_id'=>$encrypted]) }}" class="ms-2 btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm text-black">KEMBALI</h6></a>
                                                      @else
                                                      <a href="{{ route('obl.tables') }}" class="ms-2 btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm text-black">KEMBALI</h6></a>
                                                      @endif

                                                      @if( $user_in_is->role_id === 4 && $pralop->on_handling === 'witel' )
                                                      <button type="submit" class="btn bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">SIMPAN</h6></button>
                                                      @endif

                                                    @elseif( $user_in_is->role_id === 13 )
                                                      @if( $encrypted )
                                                      <a href="{{ route('witels.pralop.detail',['edit_pralop_id'=>$encrypted]) }}" class="ms-2 btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm text-black">KEMBALI</h6></a>
                                                      @else
                                                      <a href="{{ route('obl.tables') }}" class="ms-2 btn bg-gradient-light shadow-primary"><h6 class="mb-0 text-sm text-black">KEMBALI</h6></a>
                                                      @endif
                                                    @elseif( $user_in_is->role_id === 8 )
                                                      @if( $encrypted )
                                                      <a href="{{ route('witels.pralop.detail',['edit_pralop_id'=>$encrypted]) }}" class="ms-2 btn bg-gradient-secondary"><h6 class="mb-0 text-sm text-white">KEMBALI</h6></a>
                                                      @else
                                                      <a href="{{ route('obl.tables') }}" class="ms-2 btn bg-gradient-secondary"><h6 class="mb-0 text-sm text-white">KEMBALI</h6></a>
                                                      @endif

                                                      @if( $user_in_is->role_id === 8 && ( $pralop->on_handling === 'solution'  || $pralop->on_handling === 'final_pralop'  ) )
                                                      <button type="submit" class="btn" style="background:#2a623d;"><h6 class="mb-0 text-sm" style="color:white;">SIMPAN</h6></button>
                                                      @endif

                                                    @elseif( $user_in_is->role_id === 9 )
                                                      @if( $encrypted )
                                                      <a href="{{ route('witels.pralop.detail',['edit_pralop_id'=>$encrypted]) }}" class="ms-2 btn bg-gradient-secondary"><h6 class="mb-0 text-sm text-white">KEMBALI</h6></a>
                                                      @else
                                                      <a href="{{ route('obl.tables') }}" class="ms-2 btn bg-gradient-secondary"><h6 class="mb-0 text-sm text-white">KEMBALI</h6></a>
                                                      @endif
                                                    <button type="submit" class="btn" style="background:#2a623d;"><h6 class="mb-0 text-sm" style="color:white;">SIMPAN</h6></button>
                                                    @endif
                                                  @endif
                                              </td></tr>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              @endif
                            @endif
                        </form>
                        </div>
                    </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script>

          function clearNameFile(){
            $('#file_p0').val('');
            $('#label_file_p0').empty(); $('#label_file_p0').append(`Pilih File P0`);
          }

          $('#btn_clear_p0').on('click', function() {
            $('#file_p0').val('');
            $('#label_file_p0').empty(); $('#label_file_p0').append(`Pilih File P0`);
            $('.label_p0').removeClass('bg-gradient-secondary'); $('.label_p0').addClass('bg-gradient-light');
          });

          $("#file_p0").change(function() {
            // filename = this.files[0].name;
            // console.log(filename);
              $('.label_p0').removeClass('bg-gradient-light');
              $('#label_file_p0').empty();
              $('#label_file_p0').append(this.files[0].name);
              $('.label_p0').addClass('bg-gradient-secondary');
          });

          var show_p0 = 0;
          $('#show_p0').on('click', function() {
            if( show_p0 === 0 ){
              $(".show-p0").show();
              $(".button-p0").hide();
              $("<input />").attr("type", "hidden")
                .attr("name", "tambah_p0")
                .attr("value", true )
                .appendTo("#formObl");
              show_p0 = 1;
            }
            else{ $(".show-p0").hide(); show_p0 = 0; }
          });

            $( document ).ready(function() {

                clearNameFile();



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
