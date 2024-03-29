<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-tables"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="DOKUMEN OBL"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <style media="screen">
            .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
              border-color: #D7B1D7;
              background-color: #D7B1D7;
            }

            #table-data-obl .action-kembali-proses-witel.dropdown-item:hover {
              background-color:  	#E91E63;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-obl.dropdown-item:hover {
              background-color:  	#1a73e8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-legal.dropdown-item:hover {
              background-color:  	#fb8c00;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-mitra-obl.dropdown-item:hover {
              background-color:  	#1da2d8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-closesm.dropdown-item:hover {
              background-color:  	#d9534f;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-done.dropdown-item:hover {
              background-color:  	#4CAF50;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-cancel.dropdown-item:hover {
              background-color:  	#f44335;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-kembali-witel.dropdown-item:hover {
              background-color:  	#E91E63;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-lanjut-obl.dropdown-item:hover {
              background-color:  	#1a73e8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-edit.dropdown-item:hover {
              background-color:  	#3b5998;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-forms.dropdown-item:hover {
              background-color:  	#2a623d;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-lampiran.dropdown-item:hover {
              background-color:  	#008080;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-print.dropdown-item:hover {
              background-color:  	#eeba30;
              color:  	#000000;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-upload.dropdown-item:hover {
              background-color:  	#7289da;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-ketdoc.dropdown-item:hover {
              background-color:  	#708090;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-delete.dropdown-item:hover {
              background-color:  	#ae0001;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            </style>
            <!-- modal alerts -->
            @if( $is_user->role_id === 2 or $is_user->role_id === 4 or $is_user->role_id === 8 or $is_user->role_id === 9  )
            <div class="modal fade" id="modal-status-table-obl" tabindex="-1" aria-labelledby="modal-status-table-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Proses Sistem:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="status-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id === 2 or $is_user->role_id === 9 )
            <div class="modal  fade" id="modal-lampiran-table-obl" tabindex="-1" aria-labelledby="modal-lampiran-table-obl" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Lampiran Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="formLampiran" action="{{ route('obl.lampiran.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-body" id="lampiran-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                    <button type="submit" name="submit" value="submit_lampiran" class="btn text-white" style="background:#008080;">SIMPAN</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
            <div class="modal top fade" id="modal-lampiran-obl" tabindex="-1" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="">Lampiran Dokumen OBL:</h5>
                      </div>
                      <div class="modal-body" id="lampiran-obl-body">
                      </div>
                      <div class="modal-footer" id="lampiran-obl-footer">
                      </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id === 2 or $is_user->role_id === 8 or $is_user->role_id === 9 )
            <div class="modal fade" id="modal-status-table-obl-delete" tabindex="-1" aria-labelledby="modal-status-table-obl-delete" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="">
                        <div class="text-center">
                            <h5 class="">Anda Yakin Hapus Dokumen OBL?</h5>
                        </div>
                    </div>
                  </div>
                  <form action="{{ route('obl.tables.delete') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-footer" id="modal-pilihan-table-obl-hapus">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-multi-obl-hapus" tabindex="-1" aria-labelledby="modal-multi-obl-hapus" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="multi-obl-hapus-hapus-body">
                  </div>
                  <div class="modal-footer" id="multi-obl-hapus-hapus-footer">
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id )
            <div class="modal fade" id="modal-ketdoc-table-obl" tabindex="-1" aria-labelledby="modal-ketdoc-table-obl" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Keterangan Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="ketdoc-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-print-obl" tabindex="-1" aria-labelledby="modal-print-obl" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <form action="{{ route('obl.print.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-header">
                    <h5 class="modal-title">Print Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="list-print-obl">
                  </div>
                  <div class="modal-footer" id="list-print-obl-options">
                  </div>
                </form>
                </div>
              </div>
            </div>
            @endif
            <!-- end modal alerts -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                @if( $is_user->role_id == 4 || $is_user->role_id == 5 )
                                <div class="bg-gradient-primary border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">DOKUMEN OBL</h6>
                              </div>
                                @elseif( $is_user->role_id == 6 )
                                <div class="bg-gradient-mitra border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">DOKUMEN OBL</h6>
                              </div>
                                @elseif( $is_user->role_id == 13 )
                                <div class="bg-gradient-warning border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">DOKUMEN OBL</h6>
                              </div>
                                @elseif( $is_user->role_id !== 4 && $is_user->role_id !== 5 && $is_user->role_id !== 6 && $is_user->role_id !== 13 )
                                <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3">DOKUMEN OBL</h6>
                                </div>
                                @endif

                            </div>
                            <div class="card-body px-0 pb-2">

                              <div class="row ps-4">
                                  <div class="col-sm-6">
                                    <div class=" card z-index-2 ">

                                      <div class="input-group p-1">

                                        @if( $is_user->role_id === 4 || $is_user->role_id === 5 )
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_witel" name="fl_witel" disabled>
                                          <option value="" selected>Pilih Witel</option>
                                        </select>
                                        @else
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_witel" name="fl_witel">
                                          <option value="" selected>Pilih Witel</option>
                                          @if( $witels )
                                            @foreach( $witels as $key => $value )
                                              <option value="{{ $value->nama_witel }}">{{ $value->nama_witel }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                        @endif

                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_tahun" name="fl_tahun">
                                          <option value="" selected>Pilih Tahun</option>
                                          @if( $tahuns )
                                            @foreach( $tahuns as $key => $value )
                                              <option value="{{ $value->tahun }}">{{ $value->tahun }}</option>
                                            @endforeach
                                          @endif
                                        </select>

                                        @if( $is_user->role_id === 6 )
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_mitra" name="fl_mitra" disabled>
                                          <option value="" selected>Pilih Mitra</option>
                                        </select>
                                        @else
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_mitra" name="fl_mitra">
                                          <option value="" selected>Pilih Mitra</option>
                                          @if( $mitras )
                                            @foreach( $mitras as $key => $value )
                                              <option value="{{ $value->id }}">{{ $value->nama_mitra }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                        @endif

                                      </div>
                                      <div class="input-group p-1">
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_plggn" name="fl_plggn">
                                          <option value="" selected>Pilih Pelanggan</option>
                                          @if( $plggns )
                                            @foreach( $plggns as $key => $value )
                                              <option value="{{ $value->f1_nama_plggn }}">{{ $value->f1_nama_plggn }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_segmen" name="fl_segmen">
                                          <option value="" selected>Pilih Segmen</option>
                                          @if( $segmens )
                                            @foreach( $segmens as $key => $value )
                                              <option value="{{ $value->f1_segmen }}">{{ $value->f1_segmen }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                        <select class="border-0 form-select form-select-lg" aria-label="Default select example" id="fl_status" name="fl_status">
                                          <option value="" selected>Pilih Status</option>
                                          @if( $statuses )
                                            @foreach( $statuses as $key => $value )
                                              <option value="{{ $value->f1_jenis_kontrak }}">{{ $value->jenis_kontrak }}</option>
                                            @endforeach
                                          @endif
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                              </div>
                              <div class="row pt-2 ps-4">
                                <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                                  <div class="btn-group" role="group">
                                    <button class="btn btn-sm bg-gradient-info" type="button" name="button" id="cari">CARI</button>
                                    <button class="btn btn-sm bg-gradient-danger" type="button" name="button" id="reset">RESET</button>
                                  </div>
                                </div>
                              </div>

                                <div class="table-responsive p-3">
                                  <form id="formObl" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                      <div class="col">

                                      </div>
                                    </div><br>
                                    <table id="table-data-obl" class="table align-items-center justify-content-center mb-0 table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No.</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Proses</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Update Form</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Segmen</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Folder</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Tanggal Submit</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Tanggal Update</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Jenis SPK</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Witel</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Nama Pelanggan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Layanan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Nama Vendor</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Jangka Waktu</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Nilai KB</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    No. KFS / SPK</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    No. KL / WO / SP</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Jenis Kontrak</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Quote</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    No. Akun</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Cara Bayar</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Status Order</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Keterangan Terbaru</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Jumlah Witel Revisi</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Created By</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Updated By</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script type="text/javascript">

            $("#modal-status-table-obl-delete").modal({show:false});
            function deleteDoc(delete_id){
                if(delete_id && typeof delete_id !== undefined){
                  $('#modal-pilihan-table-obl-hapus').empty();
                    $('#modal-pilihan-table-obl-hapus').append(`
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TIDAK</button>
                      <button type="submit" name="obl_doc_action" value="delete_`+delete_id+`" class="btn btn-danger">HAPUS</button>
                    `);
                    $('#modal-status-table-obl-delete').modal('show');
                }
            }

            function editDoc(edit_obl_id){
              // console.log(edit_obl_id);
              $('#formObl').attr('action', "");
              $("<input />").attr("type", "hidden")
                .attr("name", "edit_obl_id")
                .attr("value", edit_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.edit') }}").submit();
            }

            function formsDoc(forms_obl_id){
              $('#formObl').attr('action', "");
              $("<input />").attr("type", "hidden")
                .attr("name", "forms_obl_id")
                .attr("value", forms_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('witels.forms') }}").submit();
            }



            function lampiranDoc(lampiran_doc_id){
              // $('#lampiran-table-obl').empty();
              let lampiran_obl = ``;
              // JQUERY AJAX POST
              $.ajax({
                 type:'POST',
                 url:"{{ route('obl.lampiran.index') }}",
                 data:{
                   _token: "{{ csrf_token() }}",
                   lampiran_doc_id:lampiran_doc_id
                 },
                 success:function(data){
                   if(data.status_id==='4' || data.status_id==='3'){
                     $('#lampiran-obl-body').empty();
                     $('#lampiran-obl-footer').empty();
                     $('#lampiran-obl-body').append(`
                       <div class="alert alert-danger alert-dismissible">
                           <div class="text-center">
                               <h6 class="text-white">`+data.status+`</h6>
                           </div>
                       </div>
                       `);
                      $('#lampiran-obl-footer').append(`
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        `);
                        $('#modal-lampiran-obl').modal('show');
                   }
                   if(data.status_id==='2'){
                     $('#lampiran-obl-body').empty();
                     $('#lampiran-obl-footer').empty();
                     $('#lampiran-obl-body').append(`
                       <div class="alert alert-warning alert-dismissible">
                           <div class="text-center">
                               <h6 class="text-uppercase align-items-center">`+data.status+`</h6>
                           </div>
                       </div>
                       `);
                      $('#lampiran-obl-footer').append(`
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        `);
                      $('#modal-lampiran-obl').modal('show');
                   }
                   if(data.status_id==='1'){
                     $('#lampiran-table-obl').empty();
                     let append_lampiran_p2 = ``;
                     let append_lampiran_p3 = ``;
                     let append_lampiran_p4 = ``;
                     let append_lampiran_p5 = ``;
                     let append_lampiran_p6 = ``;
                     let append_lampiran_p7 = ``;
                     let append_lampiran_p8 = ``;
                     let append_lampiran_sp = ``;
                     let append_lampiran_wo = ``;
                     let append_lampiran_kl = ``;
                     $.each(data.lampiran_doc,function(index,value){
                        if(value.tipe_form==='P2'){
                          append_lampiran_p2+=`
                           <tr>
                             <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p2"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p2[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p2[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p2[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p2[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p2[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p2[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p2[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p2[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p2[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p2[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P3'){
                          append_lampiran_p3+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p3"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p3[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p3[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p3[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p3[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p3[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p3[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p3[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p3[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p3[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p3[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P4'){
                          append_lampiran_p4+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p4"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p4[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p4[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p4[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p4[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p4[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p4[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p4[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p4[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p4[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p4[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P5'){
                          append_lampiran_p5+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p5"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p5[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p5[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p5[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p5[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p5[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p5[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p5[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p5[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p5[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p5[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P6'){
                          append_lampiran_p6+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p6"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p6[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p6[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p6[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p6[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p6[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p6[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p6[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p6[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p6[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p6[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P7'){
                          append_lampiran_p7+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p7"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p7[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p7[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p7[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p7[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p7[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p7[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p7[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p7[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p7[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p7[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='P8'){
                          append_lampiran_p8+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p8"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_p8[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_p8[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_p8[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_p8[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_p8[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_p8[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_p8[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_p8[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_p8[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_p8[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='SP'){
                          append_lampiran_sp+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_sp"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_sp[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_sp[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_sp[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_sp[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_sp[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_sp[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_sp[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_sp[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_sp[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_sp[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='WO'){
                          append_lampiran_wo+=`
                           <tr>
                           <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_wo"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_wo[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_wo[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_wo[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_wo[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_wo[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_wo[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_wo[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_wo[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_wo[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_wo[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                        if(value.tipe_form==='KL'){
                          append_lampiran_kl+=`
                           <tr>
                            <td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_kl"><i class="fa fa-trash"></i></button</td>
                             <td>`+(index+1)+`</td>
                             <td><input type="text" name="detail_item_kl[]" value="`+value.detail_item+`"></td>
                             <td><input type="text" name="jumlah_kl[]" value="`+value.jumlah+`"></td>
                             <td><input type="text" name="satuan_kl[]" value="`+value.satuan+`"></td>
                             <td><input type="text" name="periode_bulan_kl[]" value="`+value.periode_bulan+`"></td>
                             <td><input type="text" name="harga_tawar_otc_kl[]" value="`+value.harga_tawar_otc+`"></td>
                             <td><input type="text" name="harga_tawar_total_kl[]" value="`+value.harga_tawar_total+`"></td>
                             <td><input type="text" name="harga_nego_otc_kl[]" value="`+value.harga_nego_otc+`"></td>
                             <td><input type="text" name="harga_nego_total_kl[]" value="`+value.harga_nego_total+`"></td>
                             <td><input type="text" name="harga_kerja_otc_kl[]" value="`+value.harga_kerja_otc+`"></td>
                             <td><input type="text" name="harga_kerja_total_kl[]" value="`+value.harga_kerja_total+`"></td>
                           </tr>
                          `;
                        }
                     });

                     let append_total = `
                     <div class="alert alert-dismissible" style="background:#008080;">
                         <div class="text-center">
                         <h6 class="text-white">
                          Layanan: `+data.perihal[0].f1_judul_projek+` &nbsp;|&nbsp;
                          Pelanggan: `+data.perihal[0].f1_nama_plggn+` &nbsp;|&nbsp;
                          Mitra: `+data.perihal[0].nama_mitra+`
                         </h6>
                         </div>
                     </div><hr>
                     <div class="row">
                      <div class="col-lg-2">
                      <input type="text" name="obl_id" value="`+data.perihal[0].id+`" hidden>
                        <select id="pilih_lamp_terkait" name="pilih_lamp_terkait"  class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="border:1px solid;">
                          <option value="" disabled selected>Pilih Lampiran Form</option>
                          <option value="P2">Lampiran Form P2</option>
                          <option value="P3">Lampiran Form P3</option>
                          <option value="P4">Lampiran Form P4</option>
                          <option value="P5">Lampiran Form P5</option>
                          <option value="P6">Lampiran Form P6</option>
                          <option value="P7">Lampiran Form P7</option>
                          <option value="P8">Lampiran Form P8</option>
                          <option value="SP">Lampiran Form SP</option>
                          <option value="WO">Lampiran Form WO</option>
                          <option value="KL">Lampiran Form KL</option>
                        </select>
                      </div>
                     </div>
                     <br>
                       <div class="row lampP2 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                  <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE (BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p2">`+append_lampiran_p2+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p2" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP3 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p3">`+append_lampiran_p3+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p3" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP4 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p4">`+append_lampiran_p4+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p4" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP5 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p5">`+append_lampiran_p5+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p5" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP6 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p6">`+append_lampiran_p6+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p6" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP7 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p7">`+append_lampiran_p7+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p7" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampP8 lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_p8">`+append_lampiran_p8+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_p8" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampSP lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_sp">`+append_lampiran_sp+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_sp" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampWO lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_wo">`+append_lampiran_wo+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_wo" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       <div class="row lampKL lamp-sisa">
                        <div class="col-lg-12 align-items-center text-center table-responsive">
                          <table class="table">
                              <thead>
                                <tr>
                                  <th rowspan="2"></th>
                                  <th rowspan="2">NO.</th>
                                  <th rowspan="2">DETAIL ITEM</th>
                                  <th rowspan="2">JUMLAH</th>
                                  <th rowspan="2">SATUAN</th>
                                  <th rowspan="2">PERIODE<br>(BULAN)</th>
                                  <th colspan="2">HARGA PENAWARAN</th>
                                  <th colspan="2">HARGA NEGOSIASI</th>
                                  <th colspan="2">HARGA PEKERJAAN</th>
                                </tr>
                                <tr>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                  <th>OTC</th>
                                  <th>TOTAL</th>
                                </tr>
                              </thead>
                              <tbody id="insert_lamp_kl">`+append_lampiran_kl+`</tbody>
                          </table>
                        </div>
                        <button type="button" id="btn_lamp_kl" class="btn btn-md bg-gradient-info"><i class="fa fa-plus-square"></i></button>
                       </div>
                       `;
                     // console.log(append_lampiran_p2,append_rekap_p2);
                     $('#lampiran-table-obl').append(append_total);
                      $('.lampP2').hide();
                      $('.lampP3').hide();
                      $('.lampP4').hide();
                      $('.lampP5').hide();
                      $('.lampP6').hide();
                      $('.lampP7').hide();
                      $('.lampP8').hide();
                      $('.lampSP').hide();
                      $('.lampWO').hide();
                      $('.lampKL').hide();
                      $('#modal-lampiran-table-obl').modal('show');

                      $('#pilih_lamp_terkait').on('change', function (e) {
                          var optionSelected = $("option:selected", this);
                          var valueSelected = this.value;
                          if(valueSelected==='P2'){ $('.lamp-sisa').hide(); $('.lampP2').show(); }
                          if(valueSelected==='P3'){ $('.lamp-sisa').hide(); $('.lampP3').show(); }
                          if(valueSelected==='P4'){ $('.lamp-sisa').hide(); $('.lampP4').show(); }
                          if(valueSelected==='P5'){ $('.lamp-sisa').hide(); $('.lampP5').show(); }
                          if(valueSelected==='P6'){ $('.lamp-sisa').hide(); $('.lampP6').show(); }
                          if(valueSelected==='P7'){ $('.lamp-sisa').hide(); $('.lampP7').show(); }
                          if(valueSelected==='P8'){ $('.lamp-sisa').hide(); $('.lampP8').show(); }
                          if(valueSelected==='SP'){ $('.lamp-sisa').hide(); $('.lampSP').show(); }
                          if(valueSelected==='WO'){ $('.lamp-sisa').hide(); $('.lampWO').show(); }
                          if(valueSelected==='KL'){ $('.lamp-sisa').hide(); $('.lampKL').show(); }
                      });


                      $("#btn_lamp_p2").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p2"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p2[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p2[]"></td>';
                          cols += '<td><input type="text" name="satuan_p2[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p2[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p2[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p2").append(newRow);
                      });
                      $("#insert_lamp_p2").on("click", "#del_row_lamp_p2", function (event) {
                          $(this).closest("tr").remove();
                      });

                      $("#btn_lamp_p3").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p3"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p3[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p3[]"></td>';
                          cols += '<td><input type="text" name="satuan_p3[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p3[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p3[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p3").append(newRow);
                      });
                      $("#insert_lamp_p3").on("click", "#del_row_lamp_p3", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_p4").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p4"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p4[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p4[]"></td>';
                          cols += '<td><input type="text" name="satuan_p4[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p4[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p4[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p4").append(newRow);
                      });
                      $("#insert_lamp_p4").on("click", "#del_row_lamp_p4", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_p5").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p5"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p5[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p5[]"></td>';
                          cols += '<td><input type="text" name="satuan_p5[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p5[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p5[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p5").append(newRow);
                      });
                      $("#insert_lamp_p5").on("click", "#del_row_lamp_p5", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_p6").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p6"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p6[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p6[]"></td>';
                          cols += '<td><input type="text" name="satuan_p6[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p6[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p6[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p6").append(newRow);
                      });
                      $("#insert_lamp_p6").on("click", "#del_row_lamp_p6", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_p7").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p7"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p7[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p7[]"></td>';
                          cols += '<td><input type="text" name="satuan_p7[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p7[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p7[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p7").append(newRow);
                      });
                      $("#insert_lamp_p7").on("click", "#del_row_lamp_p7", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_p8").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_p8"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_p8[]"></td>';
                          cols += '<td><input type="text" name="jumlah_p8[]"></td>';
                          cols += '<td><input type="text" name="satuan_p8[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_p8[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_p8[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_p8").append(newRow);
                      });
                      $("#insert_lamp_p8").on("click", "#del_row_lamp_p8", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_sp").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_sp"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_sp[]"></td>';
                          cols += '<td><input type="text" name="jumlah_sp[]"></td>';
                          cols += '<td><input type="text" name="satuan_sp[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_sp[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_sp[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_sp").append(newRow);
                      });
                      $("#insert_lamp_sp").on("click", "#del_row_lamp_sp", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_wo").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_wo"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_wo[]"></td>';
                          cols += '<td><input type="text" name="jumlah_wo[]"></td>';
                          cols += '<td><input type="text" name="satuan_wo[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_wo[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_wo[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_wo").append(newRow);
                      });
                      $("#insert_lamp_wo").on("click", "#del_row_lamp_wo", function (event) {
                          $(this).closest("tr").remove();
                      });
                      $("#btn_lamp_kl").on("click", function (event) {
                          event.preventDefault();
                          var newRow = $("<tr>");
                          var cols = '';
                          cols += '<td><button type="button" class="btn btn-md btn-danger" id="del_row_lamp_kl"><i class="fa fa-trash"></i></button</td>';
                          cols += '<th scrope="row"></th>';
                          cols += '<td><input type="text" name="detail_item_kl[]"></td>';
                          cols += '<td><input type="text" name="jumlah_kl[]"></td>';
                          cols += '<td><input type="text" name="satuan_kl[]"></td>';
                          cols += '<td><input type="text" name="periode_bulan_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_otc_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_tawar_total_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_otc_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_nego_total_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_otc_kl[]"></td>';
                          cols += '<td><input type="text" name="harga_kerja_total_kl[]"></td>';
                          newRow.append(cols);
                          $("#insert_lamp_kl").append(newRow);
                      });
                      $("#insert_lamp_kl").on("click", "#del_row_lamp_kl", function (event) {
                          $(this).closest("tr").remove();
                      });

                   }
                 },
                 error: function(xhr, textStatus, error) {
                     alert('Gagal Ambil Data Lampiran OBL!');
                  }
              });
              // $('#modal-lampiran-table-obl').modal('show');
            }



            function ketDoc(ket_obl_id){
              $('#ketdoc-table-obl').empty();
              let status_ket_obl = ``;
              // JQUERY AJAX POST
              $.ajax({
                 type:'POST',
                 url:"{{ route('obl.tables.ketdoc') }}",
                 data:{
                   _token: "{{ csrf_token() }}",
                   ket_obl_id:ket_obl_id
                 },
                 success:function(data){
                    if(data.status_id==='3' || data.status_id==='4'){
                      $('#ketdoc-table-obl').append(`
                        <div class="alert alert-danger alert-dismissible">
                            <div class="text-center">
                                <h5 class="text-white">`+data.status+`</h5>
                            </div>
                        </div>
                      `);
                    }
                    else if(data.status_id==='2'){
                      $('#ketdoc-table-obl').append(`
                        <div class="alert alert-warning alert-dismissible">
                            <div class="text-center">
                                <h5 class="text-white">`+data.status+`</h5>
                            </div>
                        </div>
                      `);
                    }
                    else{
                      let status_ket_obl = ``;
                      if(data.ketdoc && data.ketdoc.length > 0){
                        $.each(data.ketdoc,function(index,value){
                          status_ket_obl+=`
                          <tr>
                            <td class="d-flex flex-column"><h6 class="text-sm justify-content-center">▶️ [`+value.f1_tgl_keterangan+`]</h6></td>
                            <td><h6 style="white-space:normal;" class="text-sm">`+value.f1_keterangan+`</h6></td>
                          </tr>
                          `;
                        });
                      }
                      if(data.ketdoc_histori && data.ketdoc_histori.length > 0){
                        $.each(data.ketdoc_histori,function(index,value){
                          status_ket_obl+=`
                          <tr>
                            <td class="d-flex flex-column justify-content-center">[`+value.f1_tgl_keterangan+`]</td>
                            <td style="white-space:normal;">`+value.f1_keterangan+`</td>
                          </tr>
                          `;
                        });
                      }

                      $('#ketdoc-table-obl').append(`
                        <div class="alert alert-secondary alert-dismissible">
                            <div class="text-center">
                                <h5 class="text-white">List Keterangan</h5>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 table-responsive">
                            <table class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                              <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TANGGAL</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KETERANGAN</th>
                                </tr>
                              </thead>
                              <tbody>
                              `+status_ket_obl+`
                              </tbody>
                            </table>
                          </div>
                        </div>
                      `);
                    }
                 }
              });
              $('#modal-ketdoc-table-obl').modal('show');
            }



            function uploadDoc(upload_doc_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "upload_doc_id")
                .attr("value", upload_doc_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.upload') }}").submit();
            }

            function printDoc(print_obl_id){
            $('#list-print-obl').empty();
            $('#list-print-obl-options').empty();
            // JQUERY AJAX POST
            $.ajax({
               type:'POST',
               url:"{{ route('obl.print.index') }}",
               data:{
                 _token: "{{ csrf_token() }}",
                 print_obl_id:print_obl_id
               },
               success:function(data){
                 // console.log(data);
                 if(data.status_id==='4' || data.status_id==='3'){
                   $('#list-print-obl').append(`<div class="alert alert-danger alert-dismissible">
                       <div class="text-center">
                           <h5 class="text-white">`+data.status+`</h5>
                       </div>
                   </div>`);
                   $('#list-print-obl-options').append(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>`);
                 }
                 if(data.status_id==='2'){
                   $('#list-print-obl').append(`<div class="alert alert-warning alert-dismissible">
                       <div class="text-center">
                           <h5 class="text-white">`+data.status+`</h5>
                       </div>
                   </div>`);
                   $('#list-print-obl-options').append(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>`);
                 }
                 if(data.status_id==='1'){
                   let list_print_obl = `<input type="type" name="print_obl_id" value="`+data.print_obl_id+`" hidden>`;
                      if( data.user_in_is.role_id === 8 || data.user_in_is.role_id === 9 ){
                        for(let i = 0; i < 7; i++){
                          if( data.list_print_obl.f1_jenis_spk === 'WO' || data.list_print_obl.submit === 'draf_wo' || data.list_print_obl.submit === 'submit_wo'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p0">P0</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p1">P1</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_wo">WO</button><br>`;
                            break;
                          }
                          else if( data.list_print_obl.f1_jenis_spk === 'SP' || data.list_print_obl.submit === 'draf_sp' || data.list_print_obl.submit === 'submit_sp'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p0">P0</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p1">P1</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_sp">SP</button>`;
                            break;
                          }
                          else if( data.list_print_obl.f1_jenis_spk === 'KL' || data.list_print_obl.submit === 'draf_kl' || data.list_print_obl.submit === 'submit_kl'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p0">P0</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p1">P1</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p8">P8</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_kl">KL</button>`;
                            break;
                          }
                          else{
                              if(i===0){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p0">P0</button><br>
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p1">P1</button><br>`;
                                 if( data.list_print_obl.submit === 'am_form_p0-p1' || data.list_print_obl.submit === 'solution_form_p0-p1' ){ break; }
                              }
                              if(i===1){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p2' ){ break; }
                              }
                              if(i===2){
                                list_print_obl += `
                                <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>`;
                                if( data.list_print_obl.submit === 'draf_p3' ){ break; }
                              }
                              if(i===3){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p4' ){ break; }
                              }
                              if(i===4){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p5' ){ break; }
                              }
                              if(i===5){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p6' ){ break; }
                              }
                              if(i===6){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p7' ){ break; }
                              }
                         }
                       }
                      }
                      if( data.user_in_is.role_id === 2 ){
                        for(let i = 0; i < 6; i++){
                          if( data.list_print_obl.f1_jenis_spk === 'WO' || data.list_print_obl.submit === 'draf_wo' || data.list_print_obl.submit === 'submit_wo'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_wo">WO</button><br>`;
                            break;
                          }
                          else if( data.list_print_obl.f1_jenis_spk === 'SP' || data.list_print_obl.submit === 'draf_sp' || data.list_print_obl.submit === 'submit_sp'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_sp">SP</button>`;
                            break;
                          }
                          else if( data.list_print_obl.f1_jenis_spk === 'KL' || data.list_print_obl.submit === 'draf_kl' || data.list_print_obl.submit === 'submit_kl'){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p8">P8</button><br>
                             <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_kl">KL</button>`;
                            break;
                          }
                          else{
                              if(i===0){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p2">P2</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p2' ){ break; }
                              }
                              if(i===1){
                                list_print_obl += `
                                <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p3">P3</button><br>`;
                                if( data.list_print_obl.submit === 'draf_p3' ){ break; }
                              }
                              if(i===2){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p4">P4</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p4' ){ break; }
                              }
                              if(i===3){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p5">P5</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p5' ){ break; }
                              }
                              if(i===4){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p6">P6</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p6' ){ break; }
                              }
                              if(i===5){
                                 list_print_obl += `
                                 <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p7">P7</button><br>`;
                                 if( data.list_print_obl.submit === 'draf_p7' ){ break; }
                              }
                         }
                      }
                    }
                      if( data.user_in_is.role_id === 4 ){
                        for(let i = 0; i < 1; i++){
                          if( data.list_print_obl.submit === 'am_form_p0-p1' || data.list_print_obl.submit === 'solution_form_p0-p1' ){
                            list_print_obl += `
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p0">P0</button><br>
                            <button type="submit" class="btn btn-lg btn-warning" name="submit" value="print_p1">P1</button><br>`;
                            break;
                          }
                        }
                      }

                      $('#list-print-obl').append(list_print_obl + `
                       <br>
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                      `);
                   }
                 }
             });
             $('#modal-print-obl').modal('show');
            }


            function kembaliWitel(kw_obl_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "kw_obl_id")
                .attr("value", kw_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.kembali_witel') }}").submit();
            }

            function lanjutObl(lo_obl_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "lo_obl_id")
                .attr("value", lo_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.lanjut_obl') }}").submit();
            }


            function kembaliProsesWitel(proses_witel_obl_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "proses_witel_obl_id")
                .attr("value", proses_witel_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.proses_witel') }}").submit();
            }

          function prosesObl(proses_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "proses_obl_id")
              .attr("value", proses_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.proses_obl') }}").submit();
          }

          function prosesLegal(legal_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "legal_obl_id")
              .attr("value", legal_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.legal_obl') }}").submit();
          }

          function prosesMitraObl(mitra_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "mitra_obl_id")
              .attr("value", mitra_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.mitra_obl') }}").submit();
          }

          function prosesCloseSm(closesm_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "closesm_obl_id")
              .attr("value", closesm_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.closesm_obl') }}").submit();
          }

          function prosesDone(done_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "done_obl_id")
              .attr("value", done_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.done_obl') }}").submit();
          }

          function prosesCancel(cancel_obl_id){
            $("<input />").attr("type", "hidden")
              .attr("name", "cancel_obl_id")
              .attr("value", cancel_obl_id)
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('obl.tables.cancel_obl') }}").submit();
          }

          $(document).ready(function () {
              $("#modal-status-table-obl").modal({show:false});
              $("#modal-ketdoc-table-obl").modal({show:false});
              $('#modal-lampiran-table-obl').modal({show:false});
              $('#modal-multi-obl-hapus').modal({show:false});

              var status_table_obl = "{{ session('status') }}";
              if(status_table_obl && typeof status_table_obl !== undefined){
                $('#status-table-obl').empty();
                if(status_table_obl.includes('Oops')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-danger alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Sukses')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-success alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Draf')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Tidak')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                $('#modal-status-table-obl').modal('show');
              }


              var is_user = "{{ $is_user->role_id }}";
              var gdt = @json($gdt);
              var cl = @json($cl);
              var wl = @json($wl);

              var fl_witel = $('#fl_witel').val();
              var fl_tahun = $('#fl_tahun').val();
              var fl_mitra = $('#fl_mitra').val();
              var fl_plggn = $('#fl_plggn').val();
              var fl_segmen = $('#fl_segmen').val();
              var fl_status = $('#fl_status').val();

              yajra(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);

              $("#reset").click(function(){
                is_user = "{{ $is_user->role_id }}";
                gdt = @json($gdt);
                cl = @json($cl);
                wl = @json($wl);

                $('#fl_witel').val('');
                $('#fl_tahun').val('');
                $('#fl_mitra').val('');
                $('#fl_plggn').val('');
                $('#fl_segmen').val('');
                $('#fl_status').val('');

                fl_witel = $('#fl_witel').val();
                fl_tahun = $('#fl_tahun').val();
                fl_mitra = $('#fl_mitra').val();
                fl_plggn = $('#fl_plggn').val();
                fl_segmen = $('#fl_segmen').val();
                fl_status = $('#fl_status').val();

                // console.log(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);
                yajra(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);
              });

              $("#cari").click(function(){
                is_user = "{{ $is_user->role_id }}";
                gdt = @json($gdt);
                cl = @json($cl);
                wl = @json($wl);

                fl_witel = $('#fl_witel').val();
                fl_tahun = $('#fl_tahun').val();
                fl_mitra = $('#fl_mitra').val();
                fl_plggn = $('#fl_plggn').val();
                fl_segmen = $('#fl_segmen').val();
                fl_status = $('#fl_status').val();

                // console.log(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);
                yajra(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status);
              });

              var tableObl;
              function yajra(is_user,gdt,cl,wl,fl_witel,fl_tahun,fl_mitra,fl_plggn,fl_segmen,fl_status){
                if( is_user === undefined ){ is_user = '1'; }
                if( gdt === undefined ){ gdt = ''; }
                if( cl === undefined ){ cl = ''; }
                if( wl === undefined ){ wl = ''; }
                if( fl_witel === undefined ){ fl_witel = ''; }
                if( fl_tahun === undefined ){ fl_tahun = ''; }
                if( fl_mitra === undefined ){ fl_mitra = ''; }
                if( fl_plggn === undefined ){ fl_plggn = ''; }
                if( fl_segmen === undefined ){ fl_segmen = ''; }
                if( fl_status === undefined ){ fl_status = ''; }

                tableObl = $('#table-data-obl').DataTable({
                  language: {
                      url: "{{ asset('assets') }}/json/yajra_indonesia.json",
                  },
                  dom: 'fBrtip',
                  buttons: [
                    {
                        extend: 'excel',
                        text: 'EXCEL',
                        className: 'btn btn-sm btn-success',
                        filename: function(){
                              var today = new Date();
                              var dd = String(today.getDate()).padStart(2, '0');
                              var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                              var yyyy = today.getFullYear();
                              today = yyyy + '-' + mm + '-' + dd;
                              return 'Table_Dokumen_OBL_' + today;
                          },
                        exportOptions: {
                             columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
                         }
                    }
                  ],
                  select: {
                      style: 'multi'
                  },
                  destroy: true,
                  processing: true,
                  serverSide: true,
                  retrieve: true,
                  aaSorting: [],
                  ajax: "{{ route('obl.tables') }}?ajx_gdt="+gdt+"&ajx_cl="+cl+"&ajx_wl="+wl+"&fl_witel="+fl_witel+"&fl_tahun="+fl_tahun+"&fl_mitra="+fl_mitra+"&fl_plggn="+fl_plggn+"&fl_segmen="+fl_segmen+"&fl_status="+fl_status,
                  columns: [
                    {
                       searchable:false,orderable:false,targets: 0,
                       render: function ( data, type, row ) {
                         if( row.is_draf === 9 ){
                           if( is_user !== '9' && is_user !== '2' ){
                             return '<button type="button" class="btn btn-sm btn-secondary mt-3" data-bs-toggle="popover" title="Keterangan OBL" onclick="ketDoc('+row.obl_id+')"><i class="material-icons" style="font-size:18px;">note</i></button>';
                           }
                           else if ( is_user === '2' ){
                             return `
                               <div class="dropdown">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  </div>
                                  </div>
                               `;
                           }
                           else if ( is_user === '9' ){
                             return `
                               <div class="btn-group" role="group">
                               <div class="btn-group" role="group">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                                  </div>
                                  </div>
                               <div class="btn-group" role="group">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">PROSES <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-witel" onclick="kembaliWitel(`+row.obl_id+`)" >KEMBALI WITEL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-proses-witel" onclick="kembaliProsesWitel(`+row.obl_id+`)" >KEMBALI PROSES WITEL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-lanjut-obl" onclick="lanjutObl(`+row.obl_id+`)">LANJUT OBL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-obl" onclick="prosesObl(`+row.obl_id+`)">OBL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-legal" onclick="prosesLegal(`+row.obl_id+`)">LEGAL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-mitra-obl" onclick="prosesMitraObl(`+row.obl_id+`)">MITRA OBL</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-closesm" onclick="prosesCloseSm(`+row.obl_id+`)">CLOSE SM</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-done" onclick="prosesDone(`+row.obl_id+`)">DONE</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-cancel" onclick="prosesCancel(`+row.obl_id+`)">CANCEL</button>
                                  </div>
                                  </div>
                               </div>
                               `;
                           }
                         }
                         else{
                           if( is_user === '6' && row.proses !== 'mitra_obl' ){ return '<button type="button" class="btn btn-sm btn-secondary mt-3" data-bs-toggle="popover" title="Keterangan OBL" onclick="ketDoc('+row.obl_id+')"><i class="material-icons" style="font-size:18px;">note</i></button>'; }
                           else if( is_user === '6' && row.proses === 'mitra_obl' ){
                             return `
                               <div class="dropdown">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  </div>
                                  </div>
                               `;
                           }
                           else if( is_user === '1' || is_user === '3' || is_user === '5' || is_user === '7' ){ return `
                             <div class="dropdown">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                </div>
                                </div>
                             `; }
                           else if( is_user === '13' && row.proses !== 'legal' ){
                             return `<button type="button" class="btn btn-sm btn-secondary mt-3" data-bs-toggle="popover" title="Keterangan OBL" onclick="ketDoc(`+row.obl_id+`)"><i class="material-icons" style="font-size:18px;">note</i></button>`;
                           }
                           else if( is_user === '13' && row.proses === 'legal' ){
                             return `
                               <div class="dropdown">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  </div>
                                  </div>
                               `;
                           }
                           else if( is_user === '4' && row.is_revisi === false ){ return `
                             <div class="dropdown">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                </div>
                                </div>
                             `; }
                           else if( is_user === '4' && row.is_revisi === true ){
                             return `
                               <div class="dropdown">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  </div>
                                  </div>
                               `;
                           }
                           else if( is_user === '8' && row.proses !== 'witel' ){
                             return `
                               <div class="dropdown">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  </div>
                                  </div>
                               `;
                           }
                           else if( is_user === '8' && row.proses === 'witel' ){
                             return `
                               <div class="btn-group" role="group" aria-label="basic">
                               <div class="btn-group" role="group">
                                  <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                  <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                    <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                                  </div>
                                  </div>
                              <div class="btn-group" role="group">
                                 <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">PROSES <span class="caret"></span></button>
                                 <div class="dropdown-menu">
                                   <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-witel" onclick="kembaliWitel(`+row.obl_id+`)" >KEMBALI WITEL</button>
                                   <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-lanjut-obl" onclick="lanjutObl(`+row.obl_id+`)">LANJUT OBL</button>
                                 </div>
                                 </div>
                               </div>
                               `;
                           }
                           else if( is_user === '2' && row.proses === 'witel' ){ return `
                             <div class="dropdown">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                </div>
                                </div>
                             `; }
                           else if( is_user === '2' && row.proses !== 'witel' && row.proses !== 'obl' ){ return `
                             <div class="btn-group" role="group">
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                                </div>
                                </div>
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">PROSES <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-obl" onclick="prosesObl(`+row.obl_id+`)">OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-legal" onclick="prosesLegal(`+row.obl_id+`)">LEGAL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-mitra-obl" onclick="prosesMitraObl(`+row.obl_id+`)">MITRA OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-closesm" onclick="prosesCloseSm(`+row.obl_id+`)">CLOSE SM</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-done" onclick="prosesDone(`+row.obl_id+`)">DONE</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-cancel" onclick="prosesCancel(`+row.obl_id+`)">CANCEL</button>
                                </div>
                                </div>
                             </div>
                             `; }
                           else if( is_user === '2' && row.proses !== 'witel' && row.proses === 'obl' ){ return `
                             <div class="btn-group" role="group">
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                                </div>
                                </div>
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">PROSES <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-proses-witel" onclick="kembaliProsesWitel(`+row.obl_id+`)" >KEMBALI PROSES WITEL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-legal" onclick="prosesLegal(`+row.obl_id+`)">LEGAL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-mitra-obl" onclick="prosesMitraObl(`+row.obl_id+`)">MITRA OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-closesm" onclick="prosesCloseSm(`+row.obl_id+`)">CLOSE SM</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-done" onclick="prosesDone(`+row.obl_id+`)">DONE</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-cancel" onclick="prosesCancel(`+row.obl_id+`)">CANCEL</button>
                                </div>
                                </div>
                             </div>
                             `; }
                           else if( is_user === '9' ){ return `
                             <div class="btn-group" role="group">
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">PILIHAN <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-forms" onclick="formsDoc(`+row.obl_id+`)">FORM P0-P1</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">FILES</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                                  <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                                </div>
                                </div>
                             <div class="btn-group" role="group">
                                <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-secondary dropdown-toggle" aria-haspopup="true" aria-expanded="false">PROSES <span class="caret"></span></button>
                                <div class="dropdown-menu">
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-witel" onclick="kembaliWitel(`+row.obl_id+`)" >KEMBALI WITEL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-kembali-proses-witel" onclick="kembaliProsesWitel(`+row.obl_id+`)" >KEMBALI PROSES WITEL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-lanjut-obl" onclick="lanjutObl(`+row.obl_id+`)">LANJUT OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-obl" onclick="prosesObl(`+row.obl_id+`)">OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-legal" onclick="prosesLegal(`+row.obl_id+`)">LEGAL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-mitra-obl" onclick="prosesMitraObl(`+row.obl_id+`)">MITRA OBL</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-closesm" onclick="prosesCloseSm(`+row.obl_id+`)">CLOSE SM</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-done" onclick="prosesDone(`+row.obl_id+`)">DONE</button>
                                <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-proses-cancel" onclick="prosesCancel(`+row.obl_id+`)">CANCEL</button>
                                </div>
                                </div>
                             </div>
                             `; }
                         }
                       }
                    },
                    {
                       data: 'DT_RowIndex',searchable:false,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<b>'+data+'</b>';
                       }
                    },
                    {
                       data: 'proses',name: 'proses',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         if(data==='witel'){ return '<span class="badge badge-sm bg-gradient-primary">WITEL</span>'; }
                         else if(data==='obl' || data==='pjm'){ return '<span class="badge badge-sm bg-gradient-info">OBL</span>'; }
                         else if(data==='legal'){ return '<span class="badge badge-sm bg-gradient-warning">LEGAL</span>'; }
                         else if(data==='mitra_obl'||data==='mitra_pjm'){ return '<span class="badge badge-sm bg-gradient-info">MITRA OBL</span>'; }
                         else if(data==='close_sm'){ return '<span class="badge badge-sm bg-gradient-danger">CLOSE SM</span>'; }
                         else if(data==='done'){ return '<span class="badge badge-sm bg-gradient-success">DONE</span>'; }
                         else if(data==='cancel'){ return '<span class="badge badge-sm bg-gradient-danger">CANCEL</span>'; }
                         else{ return '<span class="badge badge-sm bg-gradient-dark">'+data+'</span>'; }
                       }
                    },
                    {
                       data: 'string_submit',name: 'string_submit',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                          if(row.filter_submit==='kontrak1'){ return '<span class="badge badge-sm bg-gradient-info">'+data+'</span>'; }
                          if(row.filter_submit==='kontrak2'){ return '<span class="badge badge-sm bg-gradient-success">'+data+'</span>'; }
                          if(row.filter_submit==='kontrak3'){ return '<span class="badge badge-sm bg-gradient-primary">'+data+'</span>'; }
                          if(row.filter_submit==='kontrak4'){ return '<span class="badge badge-sm bg-gradient-info">'+data+'</span>'; }
                          if(row.filter_submit==='filter'){ return '<span class="badge badge-sm bg-gradient-danger">'+data+'</span>'; }
                          if(row.filter_submit==='form'){ return '<span class="badge badge-sm bg-gradient-warning">'+data+'</span>'; }
                          if(row.filter_submit===''){ return ''; }
                       }
                    },
                    {
                       data: 'segmen',name: 'segmen',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'folder',name: 'folder',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'string_tgl_submit',name: 'string_tgl_submit',searchable:true,orderable:true
                    },
                    {
                       data: 'string_tgl_update',name: 'string_tgl_update',searchable:true,orderable:true
                    },
                    {
                       data: 'jenis_spk',name: 'jenis_spk',searchable:true,orderable:true
                    },
                    {
                       data: 'witel',name: 'witel',searchable:true,orderable:true
                    },
                    {
                       data: 'nama_plggn',name: 'nama_plggn',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'layanan',name: 'layanan',searchable:true,orderable:true,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'nama_vendor',name: 'nama_vendor',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'masa_layanan_tahun',name: 'masa_layanan_tahun',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         let string_masa_layanan = `<span style="white-space:normal">`;
                         if( /\d/.test(data) ){ string_masa_layanan+= ` ` + data +` tahun`; }
                         if( /\d/.test(row.masa_layanan_bulan) ){ string_masa_layanan+=` `+row.masa_layanan_bulan+` bulan`; }
                         if( /\d/.test(row.masa_layanan_hari) ){ string_masa_layanan+=` `+row.masa_layanan_hari+` hari`; }
                         string_masa_layanan += `</span>`;
                         return string_masa_layanan;
                       }
                    },
                    {
                       data: 'nilai_kb',name: 'nilai_kb',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'no_kfs_spk',name: 'no_kfs_spk',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'no_kontrak',name: 'no_kontrak',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'jenis_kontrak',name: 'jenis_kontrak',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'quote_kontrak',name: 'quote_kontrak',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'nomor_akun',name: 'nomor_akun',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'skema_bayar',name: 'skema_bayar',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'status_order',name: 'status_order',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'keterangan',name: 'keterangan',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {

                         if( row.is_draf === 9 ){
                            return '<span white-space:normal><b>'+row.tgl_keterangan+'</b> '+data.substr(0,20)+'</span>';
                         }
                         else{
                           if( row.tgl_keterangan ){ return '<span style="white-space:normal"><b>'+row.tgl_keterangan+'</b><br> '+data+'</span>'; }
                           else{ return '<span style="white-space:normal"></span>'; }
                         }

                       }
                    },
                    {
                       data: 'revisi_count',name: 'revisi_count',searchable:false,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'user_create',name: 'user_create',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    },
                    {
                       data: 'user_update',name: 'user_update',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<span style="white-space:normal">'+data+'</span>';
                       }
                    }

                  ],
                  // lengthChange:false,
                  paging:true,
                  // orderCellsTop: true,
                  pageLength: 50,
                });
                // tableObl.ajax.reload(null,false);
                tableObl.ajax.url("{{ route('obl.tables') }}?ajx_gdt="+gdt+"&ajx_cl="+cl+"&ajx_wl="+wl+"&fl_witel="+fl_witel+"&fl_tahun="+fl_tahun+"&fl_mitra="+fl_mitra+"&fl_plggn="+fl_plggn+"&fl_segmen="+fl_segmen+"&fl_status="+fl_status).load();
              }

          });
          $.extend( $.fn.dataTable.defaults, {
            responsive: true
          } );
        </script>
        @endpush
</x-layout>
