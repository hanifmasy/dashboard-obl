<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-tables"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="OBL / Tabel Dokumen"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <!-- modal alerts -->
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
            <!-- end modal alerts -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-light shadow-dark border-radius-lg pt-4 pb-3">
                                    <h6 class="text-capitalize ps-3">Tabel Dokumen OBL</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-3">
                                    <table id="table-data-obl" class="table align-items-center justify-content-center mb-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No.</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Progress</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Segmen</th>
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
                                                    Keterangan Updated</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Keterangan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                                    Updated By</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        <x-plugins></x-plugins>
        @push('js')
        <script type="text/javascript">
            $("#modal-status-table-obl-delete").modal({show:false});
            function deleteDoc(delete_id){
                if(delete_id && typeof delete_id !== undefined){
                  $('#modal-pilihan-table-obl-hapus').empty();
                    $('#modal-pilihan-table-obl-hapus').append(`
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                      <button type="submit" name="obl_doc_action" value="delete_`+delete_id+`" class="btn btn-danger">DELETE</button>
                    `);
                    $('#modal-status-table-obl-delete').modal('show');
                }
            }

          $(document).ready(function () {
              $("#modal-status-table-obl").modal({show:false});
              var status_table_obl = "{{ session('status') }}";
              if(status_table_obl && typeof status_table_obl !== undefined){
                $('#status-table-obl').empty();
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

              // <div class="d-flex align-items-center justify-content-center">
              //     <span class="me-2 text-xs font-weight-bold">60%</span>
              //     <div>
              //         <div class="progress">
              //             <div class="progress-bar bg-gradient-info"
              //                 role="progressbar" aria-valuenow="60"
              //                 aria-valuemin="0" aria-valuemax="100"
              //                 style="width: 60%;"></div>
              //         </div>
              //     </div>
              // </div>

              $('#table-data-obl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('obl.tables') }}",
                columns: [
                  {
                     searchable:false,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<button type="button" class="btn btn-info btn-sm">Edit</button><button type="button" class="btn btn-warning btn-sm">Print</button><button type="button" class="btn btn-danger btn-sm" onclick="deleteDoc('+row.obl_id+')">Delete</button>';
                     }
                  },
                  {
                     data: 'DT_RowIndex',searchable:false,orderable:false
                  },
                  {
                     data: 'string_submit',name: 'string_submit',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                        if(row.filter_submit==='kontrak1'){ return '<span class="badge badge-sm bg-gradient-success">'+data+'</span>'; }
                        if(row.filter_submit==='kontrak2'){ return '<span class="badge badge-sm bg-gradient-info">'+data+'</span>'; }
                        if(row.filter_submit==='filter'){ return '<span class="badge badge-sm bg-gradient-danger">'+data+'</span>'; }
                        if(row.filter_submit==='form'){ return '<span class="badge badge-sm bg-gradient-warning">'+data+'</span>'; }
                     }
                  },
                  {
                     data: 'segmen',name: 'segmen',searchable:true,orderable:false,
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
                     data: 'jangka_waktu',name: 'jangka_waktu',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
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
                     data: 'tgl_keterangan',name: 'tgl_keterangan',searchable:true,orderable:true
                  },
                  {
                     data: 'keterangan',name: 'keterangan',searchable:true,orderable:false
                  },
                  {
                     data: 'updated_by',name: 'updated_by',searchable:true,orderable:false
                  }

                ],
                lengthChange:false,
                paging:true,
                orderCellsTop: true,
                pageLength: 50,
              });


          });
          $.extend( $.fn.dataTable.defaults, {
            responsive: true
          } );
        </script>
        @endpush
</x-layout>
