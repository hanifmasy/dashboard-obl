<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-tables"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="TABEL DOKUMEN"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <style media="screen">
            .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
  border-color: #D7B1D7;
  background-color: #D7B1D7;
}
            #table-data-obl .action-edit.dropdown-item:hover {
              background-color:  	#3b5998;
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
            @if( $is_user->role_id !== 1 and $is_user->role_id !== 3 and $is_user->role_id !== 4 and $is_user->role_id !== 5 and $is_user->role_id !== 6 and $is_user->role_id !== 7 )
            <div class="modal fade" id="modal-status-table-obl" tabindex="-1" aria-labelledby="modal-status-table-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Dokumen OBL:</h5>
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
            <div class="modal fade" id="modal-print-obl" tabindex="-1" aria-labelledby="modal-print-obl" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <form action="{{ route('obl.print.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-header">
                    <h5 class="modal-title">Print OBL:</h5>
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
            <div class="modal  fade" id="modal-lampiran-table-obl" tabindex="-1" aria-labelledby="modal-lampiran-table-obl" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Lampiran OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="formLampiran" action="{{ route('obl.lampiran.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-body" id="lampiran-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                    <button type="submit" name="submit" value="submit_lampiran" class="btn btn-success text-white">SIMPAN</button>
                  </div>
                </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-status-table-obl-delete" tabindex="-1" aria-labelledby="modal-status-table-obl-delete" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Dokumen OBL:</h5>
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
                    <h5 class="modal-title">Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="multi-obl-hapus-hapus-body">
                  </div>
                  <div class="modal-footer" id="multi-obl-hapus-hapus-footer">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal top fade" id="modal-lampiran-obl" tabindex="-1" aria-hidden="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="">Lampiran OBL:</h5>
                      </div>
                      <div class="modal-body" id="lampiran-obl-body">
                      </div>
                      <div class="modal-footer" id="lampiran-obl-footer">
                      </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id )
            <div class="modal fade" id="modal-ketdoc-table-obl" tabindex="-1" aria-labelledby="modal-ketdoc-table-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Dokumen OBL:</h5>
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
            @endif
            <!-- end modal alerts -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                @if( $is_user->role_id == 4 or $is_user->role_id == 5 )
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">TABEL DOKUMEN</h6>
                              </div>
                                @elseif( $is_user->role_id == 6 )
                                <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">TABEL DOKUMEN</h6>
                              </div>
                                @else
                                <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">TABEL DOKUMEN</h6>
                                </div>
                                @endif

                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-3">
                                  <form id="formObl" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                      <div class="col">
                                        <button type="button" class="btn btn-md bg-gradient-success" id="downloadExcel">EXCEL</button>
                                        @if( $is_user->role_id !== 1 and $is_user->role_id !== 3 and $is_user->role_id !== 4 and $is_user->role_id !== 5 and $is_user->role_id !== 6 and $is_user->role_id !== 7 )
                                            <button type="button" class="btn btn-md bg-gradient-danger" id="openMultiDel">HAPUS</button>
                                        @endif
                                      </div>
                                    </div><br>
                                    <table id="table-data-obl" class="table align-items-center justify-content-center mb-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No.</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Proses</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status OBL</th>
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
                                                    PIC Mitra</th>
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
                                                    Alamat Pelanggan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Keterangan Terbaru</th>
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
              $("<input />").attr("type", "hidden")
                .attr("name", "edit_obl_id")
                .attr("value", edit_obl_id)
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.edit') }}").submit();
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
                     <div class="alert alert-success alert-dismissible">
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
                                <h5 class="" style="color: #444444 !important;">`+data.status+`</h5>
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
                            <td><h6 class="text-sm">`+value.f1_keterangan+`</h6></td>
                          </tr>
                          `;
                        });
                      }
                      if(data.ketdoc_histori && data.ketdoc_histori.length > 0){
                        $.each(data.ketdoc_histori,function(index,value){
                          status_ket_obl+=`
                          <tr>
                            <td class="d-flex flex-column justify-content-center">[`+value.f1_tgl_keterangan+`]</td>
                            <td>`+value.f1_keterangan+`</td>
                          </tr>
                          `;
                        });
                      }

                      $('#ketdoc-table-obl').append(`
                        <div class="alert alert-secondary alert-dismissible">
                            <div class="text-center">
                                <h5 class="text-white">Keterangan OBL</h5>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12">
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

            function multiDelDoc(){
              $("<input />").attr("type", "hidden")
                .attr("name", "status_perintah")
                .attr("value", "multi_delete_ids")
                .appendTo("#formObl");
              $('#formObl').attr('action', "{{ route('obl.tables.multidelete') }}").submit();
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
                     for(let i = 0; i < 8; i++){
                       if( data.list_print_obl[0].submit === 'draf_wo' || data.list_print_obl[0].submit === 'submit_wo'){
                         list_print_obl += `
                         <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p6">P6</button><br>`;
                         list_print_obl += `
                         <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_wo">WO</button><br>`;
                         break;}
                   else{
                     if(i===0){
                        list_print_obl += `
                        <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p2">P2</button><br>`;
                        if( data.list_print_obl[0].submit === 'draf_p2' ){ break; }
                     }
                     if(i===1){
                       list_print_obl += `
                       <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p3">P3</button><br>`;
                       if( data.list_print_obl[0].submit === 'draf_p3' ){ break; }
                     }
                     if(i===2){
                        list_print_obl += `
                        <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p4">P4</button><br>`;
                        if( data.list_print_obl[0].submit === 'draf_p4' ){ break; }
                     }
                     if(i===3){
                        list_print_obl += `
                        <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p5">P5</button><br>`;
                        if( data.list_print_obl[0].submit === 'draf_p5' ){ break; }
                     }
                     if(i===4){
                        list_print_obl += `
                        <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p6">P6</button><br>`;
                        if( data.list_print_obl[0].submit === 'draf_p6' ){ break; }
                     }
                     if(i===5){
                        list_print_obl += `
                        <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p7">P7</button><br>`;
                        if( data.list_print_obl[0].submit === 'draf_p7' ){ break; }
                     }
                     if(i===6){
                       if( data.list_print_obl[0].submit === 'draf_sp' || data.list_print_obl[0].submit === 'submit_sp' ){
                         list_print_obl += `
                         <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_sp">SP</button>`; }
                     }
                     if(i===7){
                       if( data.list_print_obl[0].submit === 'draf_kl' || data.list_print_obl[0].submit === 'submit_kl'){
                         list_print_obl += `
                         <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_p8">P8</button><br>`;
                         list_print_obl += `
                         <button type="submit" class="btn btn-lg btn-warning" name="submit" value="submit_print_kl">KL</button>`; }
                     }
                   }


                     }

                     $('#list-print-obl').append(list_print_obl);
                   }
                 }
               });
               $('#modal-print-obl').modal('show');
            }


          $(document).ready(function () {
              $("#modal-status-table-obl").modal({show:false});
              $("#modal-ketdoc-table-obl").modal({show:false});
              $('#modal-lampiran-table-obl').modal({show:false});
              $('#modal-multi-obl-hapus').modal({show:false});

              var status_table_obl = "{{ session('status') }}";
              if(status_table_obl && typeof status_table_obl !== undefined){
                $('#status-table-obl').empty();
                if(status_table_obl.includes('Sukses')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-success alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-table-obl').modal('show');
                }
                if(status_table_obl.includes('Draf')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-table-obl').modal('show');
                }
                if(status_table_obl.includes('Tidak')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-table-obl').modal('show');
                }
                if(status_table_obl.includes('Oops')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-danger alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-table-obl').modal('show');
                }
              }

              $("#openMultiDel").on("click", function(){
                if($('input:checkbox:checked').length > 0){
                  $('#multi-obl-hapus-hapus-body').empty();
                  $('#multi-obl-hapus-hapus-body').append(`
                    <div class="alert alert-dismissible">
                        <div class="text-center">
                            <h5 class="">Yakin Hapus `+ $('input:checkbox:checked').length +` Data OBL?</h5>
                        </div>
                    </div>
                    `);
                  $('#multi-obl-hapus-hapus-footer').empty();
                  $('#multi-obl-hapus-hapus-footer').append(`
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TIDAK</button>
                      <button type="button" class="btn btn-danger" onclick="multiDelDoc()">HAPUS</button>
                    `);
                  $('#modal-multi-obl-hapus').modal('show');
                }
                else{
                  $('#multi-obl-hapus-hapus-body').empty();
                  $('#multi-obl-hapus-hapus-body').append(`
                    <div class="alert alert-danger alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">Pilihlah data OBL yang ingin dihapus.</h5>
                        </div>
                    </div>
                    `);
                  $('#multi-obl-hapus-hapus-footer').empty();
                  $('#multi-obl-hapus-hapus-footer').append(`
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    `);
                  $('#modal-multi-obl-hapus').modal('show');
                }
              });



              $("#downloadExcel").on("click", function(e){
                  e.preventDefault();
                  $("<input />").attr("type", "hidden")
                    .attr("name", "status_perintah")
                    .attr("value", "multi_download_ids")
                    .appendTo("#formObl");
                  $('#formObl').attr('action', "{{ route('obl.tables.excel') }}").submit();
              });




              var is_user = "{{ $is_user->role_id }}";
              var tableObl = $('#table-data-obl').DataTable({
                select: {
                    style: 'multi'
                },
                destroy: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('obl.tables') }}",
                columns: [
                  {
                    searchable: false,
                    orderable:false,
                    'targets': 0,
                    'render': function(data, type, row, meta){
                        data = '<input type="checkbox" name="multi_obl_ids[]" value="'+row.obl_id+'" class="dt-checkboxes">';
                        return data;
                    },
                    'checkboxes': {
                       'selectRow': false
                    }
                 },
                  {
                     data:'obl_id',searchable:false,orderable:false,
                     render: function ( data, type, row ) {
                       if(is_user === '1' || is_user === '3' || is_user === '4' || is_user === '5' ||  is_user === '6' ||  is_user === '7'){ return '<button type="button" class="btn btn-sm btn-secondary" data-toggle="popover" title="Keterangan OBL" onclick="ketDoc('+row.obl_id+')"><i class="material-icons" style="font-size:22px;">quiz</i></button>'; }
                       else{ return `
                         <div class="dropdown">
                            <button data-bs-toggle="dropdown" class="btn btn-sm bg-gradient-light dropdown-toggle" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-edit" onclick="editDoc(`+row.obl_id+`)">EDIT</button>
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-lampiran" onclick="lampiranDoc(`+row.obl_id+`)">LAMPIRAN</button>
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-print" onclick="printDoc(`+row.obl_id+`)">PRINT</button>
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-upload" onclick="uploadDoc(`+row.obl_id+`)">UPLOAD</button>
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-ketdoc" onclick="ketDoc(`+row.obl_id+`)">KETERANGAN</button>
                              <button type="button" class="dropdown-item  font-weight-bolder opacity-9 action-delete" onclick="deleteDoc(`+row.obl_id+`)">HAPUS</button>
                            </div>
                            </div>
                         `; }
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
                       else if(data==='obl'){ return '<span class="badge badge-sm bg-gradient-info">OBL</span>'; }
                       else if(data==='legal'){ return '<span class="badge badge-sm bg-gradient-secondary">LEGAL</span>'; }
                       else if(data==='mitra_obl'){ return '<span class="badge badge-sm bg-gradient-warning">MITRA OBL</span>'; }
                       else if(data==='close_sm'){ return '<span class="badge badge-sm bg-gradient-light" style="color: #444444 !important;">CLOSE SM</span>'; }
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
                     data: 'layanan',name: 'layanan',searchable:true,orderable:true
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
                     data: 'nilai_kb',name: 'nilai_kb',searchable:true,orderable:false
                  },
                  {
                     data: 'no_kfs_spk',name: 'no_kfs_spk',searchable:true,orderable:false
                  },
                  {
                     data: 'no_kontrak',name: 'no_kontrak',searchable:true,orderable:false
                  },
                  {
                     data: 'pic_mitra',name: 'pic_mitra',searchable:true,orderable:false
                  },
                  {
                     data: 'jenis_kontrak',name: 'jenis_kontrak',searchable:true,orderable:false
                  },
                  {
                     data: 'quote_kontrak',name: 'quote_kontrak',searchable:true,orderable:false
                  },
                  {
                     data: 'nomor_akun',name: 'nomor_akun',searchable:true,orderable:false
                  },
                  {
                     data: 'skema_bayar',name: 'skema_bayar',searchable:true,orderable:false
                  },
                  {
                     data: 'status_order',name: 'status_order',searchable:true,orderable:false
                  },
                  {
                     data: 'alamat_plggn',name: 'alamat_plggn',searchable:true,orderable:false
                  },
                  {
                     data: 'keterangan',name: 'keterangan',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(row.tgl_keterangan){ return '<span style="white-space:normal"><b>'+row.tgl_keterangan+'</b><br> '+data+'</span>'; }
                       else{ return '<span style="white-space:normal"></span>'; }
                     }
                  },
                  {
                     data: 'user_create',name: 'user_create',searchable:true,orderable:false
                  },
                  {
                     data: 'user_update',name: 'user_update',searchable:true,orderable:false
                  }

                ],
                lengthChange:false,
                paging:true,
                orderCellsTop: true,
                pageLength: 10,
              });


          });
          $.extend( $.fn.dataTable.defaults, {
            responsive: true
          } );
        </script>
        @endpush
</x-layout>
