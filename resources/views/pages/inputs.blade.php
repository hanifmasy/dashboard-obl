<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="inputs"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="Input Form"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Input Form OBL</h6>
                                </div>
                                @if( session('status') )
                                <br>
                                <div class="alert alert-success alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <div style="color:white;" class="text-center">
                                        <strong>{{ session('status') }}</strong>
                                    </div>
                                </div>
                                @endif 
                            </div>
                            

                            <form id="formObl" action="{{ route('inputs.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr class="kepala">
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Inputan</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Isian Inputan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="filterAwal"><td colspan="2"><hr></td></tr>
                                            <tr class="filterAwal"><td colspan="2"><h6 class="ps-2 opacity-7 text-sm">FILTER FORM</h6></td></tr>
                                            <tr class="filterAwal">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jenis Kontrak</h6>
                                                            <!-- <p class="text-xs text-secondary mb-0">
                                                                laurent@creative-tim.com</p> -->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                        <input type="radio" id="jenis_kotrak" name="jenis_kotrak" value="perpanjangan">
                                                        <label for="jenis_kotrak"> Perpanjangan KL Eksisting</label><br>
                                                        <input type="radio" id="jenis_kotrak" name="jenis_kotrak" value="baru">
                                                        <label for="jenis_kotrak"> Kontrak Baru</label><br>
                                                </td>
                                            </tr>
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
                                                        <input type="radio" id="nilai_kontrak" name="nilai_kontrak" value="dibawah_100">
                                                        <label for="nilai_kontrak"> < 100 Juta</label><br>
                                                        <input type="radio" id="nilai_kontrak" name="nilai_kontrak" value="diatas_100">
                                                        <label for="nilai_kontrak"> > 100 Juta</label><br>
                                                </td>
                                            </tr>
                                            <tr class="filterAwal">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Form P1</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="tgl_p1" id="tgl_p1">
                                                </td>
                                            </tr>
                                            <tr class="filterAwal"><td colspan="2">
                                                <button type="button" id="lanjutP2" class="btn bg-gradient-info w-100 my-4 mb-2"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P2</h6></button>
                                            </td></tr>
                                            <!-- P2 -->
                                            <tr class="formP2"><td colspan="2"><hr></td></tr>
                                            <tr class="formP2"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P2 – EVALUASI DAN PENETAPAN BAKAL CALON MITRA PELAKSANA </h6></td></tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Judul Projek</h6> 
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea type="text" cols="50" rows="2" name="judul_projek" id="judul_projek"></textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lingkup pekerjaan yang membutuhkan Anak Perusahaan/Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea type="text" cols="50" rows="2" name="lingkup_kerja" id="lingkup_kerja"></textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Anak Perusahaan / Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="nama_mitra" id="nama_mitra" style="width:350px;">
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Dibuat Oleh</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="dibuat_oleh" id="dibuat_oleh" placeholder="NAMA/NIK">
                                                    <input type="text" name="dibuat_oleh_jabatan" id="dibuat_oleh_jabatan" placeholder="JABATAN">
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
                                                    <input type="text" name="dievaluasi_oleh" id="dievaluasi_oleh" placeholder="NAMA/NIK">
                                                    <input type="text" name="dievaluasi_oleh_jabatan" id="dievaluasi_oleh_jabatan" placeholder="JABATAN">
                                                </td>
                                            </tr>
                                            <tr class="formP2">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Disetujui dan Ditetapkan Oleh</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="disetujui_oleh" id="disetujui_oleh" placeholder="NAMA/NIK">
                                                    <input type="text" name="disetujui_oleh_jabatan" id="disetujui_oleh_jabatan" placeholder="JABATAN">
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
                                                        <input type="radio" id="catatan_p2_pilihan" name="catatan_p2_pilihan" value="setuju">
                                                        <label for="catatan_p2_pilihan"> Setuju</label><br>
                                                        <input type="radio" id="catatan_p2_pilihan" name="catatan_p2_pilihan" value="setuju_dgn_catatan">
                                                        <label for="catatan_p2_pilihan"> Setuju dengan Catatan</label><br>
                                                        <input type="radio" id="catatan_p2_pilihan" name="catatan_p2_pilihan" value="tidak_setuju">
                                                        <label for="catatan_p2_pilihan"> Tidak Setuju</label><br>
                                                        <textarea name="catatan_p2" id="catatan_p2" cols="50" rows="5"></textarea>

                                                </td>
                                            </tr>
                                            <tr class="formP2"><td colspan="2">
                                                <button type="button" id="backFilter" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali ke Filter</h6></button>
                                                <button type="button" id="lanjutP3" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P3</h6></button>
                                            </td></tr>
                                            <!-- P3 -->
                                            <tr class="formP3"><td colspan="2"><hr></td></tr>
                                            <tr class="formP3"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P3</h6></td></tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Perwakilan Anak Perusahaan / Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="pejabat_mitra_nama" id="pejabat_mitra_nama" style="width:350px;" placeholder="NAMA PEJABAT"><br>
                                                    <input type="text" name="pejabat_mitra_alamat" id="pejabat_mitra_alamat" style="width:350px;" placeholder="ALAMAT"><br>
                                                    <input type="text" name="pejabat_mitra_telepon" id="pejabat_mitra_telepon" style="width:350px;" placeholder="TELEPON">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Unit Bisnis Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="nama_unit_telkom" id="nama_unit_telkom" style="width:350px;">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Pelanggan Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="nama_plggn_telkom" id="nama_plggn_telkom" style="width:350px;">
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
                                                    <input type="radio" name="status_rapat_pengadaan" id="status_rapat_pengadaan" value="ada"><label for="status_rapat_pengadaan">Ada</label><br>
                                                    <input type="radio" name="status_rapat_pengadaan" id="status_rapat_pengadaan" value="nada"><label for="status_rapat_pengadaan">Tidak Ada</label><br>
                                                    <div class="status_rapat_pengadaan"><input type="datetime-local" name="tgl_rapat_pengadaan" id="tgl_rapat_pengadaan" style="width:350px;"> WIB</div>
                                                    <input class="status_rapat_pengadaan" type="text" name="tmpt_rapat_pengadaan" id="tmpt_rapat_pengadaan" style="width:350px;" placeholder="TEMPAT RAPAT">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Surat Penawaran Mitra</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                Tenggat Waktu Menerima Surat Penawaran Mitra ke Telkom</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="datetime-local" name="tgl_terima_sp" id="tgl_terima_sp" style="width:350px;"> WIB<br>
                                                    <input type="text" name="alamat_terima_sp" id="alamat_terima_sp" style="width:350px;" placeholder="ALAMAT PENYERAHAN DOKUMEN">
                                                </td>
                                            </tr>
                                            <tr class="formP3">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Manager OBL</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="manager_obl" id="manager_obl" style="width:350px;" placeholder="">
                                                </td>
                                            </tr>
                                            <tr class="formP3"><td colspan="2">
                                                <button type="button" id="backP2" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P2</h6></button>
                                                <button type="button" id="lanjutP4" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P4</h6></button>
                                            </td></tr>
                                            <!-- P4 -->
                                            <tr class="formP4"><td colspan="2"><hr></td></tr>
                                            <tr class="formP4"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P4 – BERITA ACARA RAPAT PENJELASAN</h6></td></tr>
                                            <tr class="formP4">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Attendees</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                Perwakilan yang Hadir Rapat Penjelasan Pengadaan</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="rapat_wakil_obl" id="rapat_wakil_obl" style="width:350px;" placeholder="Perwakilan Unit pelaksana OBL"><br>
                                                    <input type="text" name="rapat_wakil_instalator" id="rapat_wakil_instalator" style="width:350px;" placeholder="Perwakilan Unit Instalator"><br>
                                                    <input type="text" name="rapat_wakil_mitra" id="rapat_wakil_mitra" style="width:350px;" placeholder="Perwakilan Anak perusahaan / Mitra">
                                                </td>
                                            </tr>
                                            <tr class="formP4"><td colspan="2">
                                                <button type="button" id="backP3" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P3</h6></button>
                                                <button type="button" id="lanjutP5" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P5</h6></button>
                                            </td></tr>
                                            <!-- P5 -->
                                            <tr class="formP5"><td colspan="2"><hr></td></tr>
                                            <tr class="formP5"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P5 – BERITA ACARA EVALUASI <i>INDICATIVE OFFERING</i></h6></td></tr>
                                            <tr class="formP5">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Kelengkapan Administrasi</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="radio" name="lengkap_admin" id="lengkap_admin" value="lengkap"><label for="lengkap_admin">Lengkap</label><br>
                                                    <input type="radio" name="lengkap_admin" id="lengkap_admin" value="tidak_lengkap"><label for="lengkap_admin">Tidak Lengkap, </label>
                                                    <textarea cols="30" rows="1" name="catatan_lengkap_admin" id="catatan_lengkap_admin" placeholder="CATATAN"></textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP5">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Kesesuaian Teknis dengan permintaan Customer</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="radio" name="sesuai_teknis" id="sesuai_teknis" value="sesuai"><label for="sesuai_teknis">Sesuai</label><br>
                                                    <input type="radio" name="sesuai_teknis" id="sesuai_teknis" value="tidak_sesuai"><label for="sesuai_teknis">Tidak Sesuai, </label>
                                                    <textarea cols="30" rows="1" name="catatan_sesuai_teknis" id="catatan_sesuai_teknis" placeholder="CATATAN"></textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP5-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Harga Penawaran Total (Sebelum PPN)</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td >
                                                    <input class="rupiahs" type="text" name="harga_penawaran" id="harga_penawaran" style="width:350px;" placeholder="Rp. xxx.xxx.xxx.-"><br>
                                                    <input type="radio" name="negosiasi" id="negosiasi" value="negosiasi"><label for="negosiasi">Negosiasi</label>
                                                    <input type="radio" name="negosiasi" id="negosiasi" value="tidak_negosiasi"><label for="negosiasi">Tidak Perlu Negosiasi</label>
                                                </td>
                                            </tr>
                                            <tr class="formP5">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Klarifikasi Lebih Lanjut</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="radio" name="klarifikasi_lanjut" id="klarifikasi_lanjut" value="perlu"><label for="klarifikasi_lanjut">Perlu</label>
                                                    <input type="radio" name="klarifikasi_lanjut" id="klarifikasi_lanjut" value="tidak_perlu"><label for="klarifikasi_lanjut">Tidak Perlu</label><br>
                                                    <textarea name="alt_lain" id="alt_lain" cols="50" rows="2" placeholder="REKOMENDASI ALTERNATIF LAIN"></textarea>
                                                </td>
                                            </tr>
                                            <tr class="formP5"><td colspan="2">
                                                <button type="button" id="backP4" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P4</h6></button>
                                                <button type="button" id="lanjutP6" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P6</h6></button>
                                            </td></tr>
                                            <!-- P6 -->
                                            <tr class="formP6"><td colspan="2"><hr></td></tr>
                                            <tr class="formP6"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P6 – BERITA ACARA KLARIFIKASI DAN NEGOSIASI</h6></td></tr>
                                            <tr class="formP6">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Peserta Rapat dari Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="rapat_wakil_mitra_1" id="rapat_wakil_mitra_1" style="width:350px;" placeholder="NAMA - JABATAN MITRA"><br>
                                                    <input type="text" name="rapat_wakil_mitra_2" id="rapat_wakil_mitra_2" style="width:350px;" placeholder="NAMA - JABATAN MITRA"><br>
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Bisnis</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="radio" name="skema_bisnis" id="skema_bisnis" value="sewa_murni"><label for="skema_bisnis">Sewa Murni</label><br>
                                                    <input type="radio" name="skema_bisnis" id="skema_bisnis" value="sewa_beli"><label for="skema_bisnis">Sewa Beli</label><br>
                                                    <input type="radio" name="skema_bisnis" id="skema_bisnis" value="beli_putus"><label for="skema_bisnis">Pengadaan Beli Putus</label>
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Skema Pembayaran</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="skema_pembayaran" id="skema_pembayaran" style="width:350px;" placeholder="">
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lokasi Instalasi / Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="lokasi_layanan" id="lokasi_layanan" style="width:350px;" placeholder="">
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Waktu Delivery Layanan <i>(Ready for Service)</i></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="waktu_layanan" id="waktu_layanan" style="width:350px;" placeholder="">
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Masa Kontrak Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" name="masa_layanan" id="masa_layanan" min="0" style="width:80px;">
                                                    <select name="satuan_masa_layanan" id="satuan_masa_layanan">
                                                        <option value="hari">hari</option>
                                                        <option value="bulan">bulan</option>
                                                        <option value="tahun">tahun</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td colspan="2"><hr></td>
                                            </tr>
                                            <tr class="formP6-baru">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Lampiran Spesifikasi Teknis</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="formP6-baru"><td colspan="2">
                                                <div class="table-responsive">
                                                    <table class="table" id="lampiranSpek">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Layanan/Barang</th>
                                                                <th scope="col">Spesifikasi</th>
                                                                <th scope="col">Merek</th>
                                                                <th scope="col">Volume</th>
                                                                <th scope="col">Satuan</th>
                                                                <th scope="col">Harga Satuan</th>
                                                                <th scope="col">Harga Total</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <button type="button" class="btn bg-gradient-info" id="insertRow">Add new row</button>
                                            </td></tr>
                                            <tr class="formP6"><td colspan="2">
                                                <button type="button" id="backP5" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P5</h6></button>
                                                <button type="button" id="lanjutP7" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P7</h6></button>
                                            </td></tr>
                                            <!-- P7 -->
                                            <tr class="formP7"><td colspan="2"><hr></td></tr>
                                            <tr class="formP7"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P7</h6></td></tr>
                                            <tr class="formP7">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Disetujui dan Diketahui</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="osm_sda" id="osm_sda" style="width:370px;" placeholder="EGM SDA / DEGM SDA / OSM SDA">
                                                </td>
                                            </tr>
                                            <tr class="formP7"><td colspan="2">
                                                <button type="button" id="backP6" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P6</h6></button>
                                                <button type="button" id="lanjutP8" class="diatas-100 btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form P8</h6></button>
                                                <button type="submit" class="dibawah-100 btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit All Form</h6></button>
                                            </td></tr>
                                            <!-- P8 -->
                                            <tr class="formP8"><td colspan="2"><hr></td></tr>
                                            <tr class="formP8"><td colspan="2"><h6 class="opacity-7 text-sm">FORM P8</h6></td></tr>
                                            <tr class="formP8">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor Kontrak Berlangganan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="nomor_kb" id="nomor_kb" style="width:370px;" placeholder="">
                                                </td>
                                            </tr>
                                            <tr class="formP8"><td colspan="2">
                                                <button type="button" id="backP7" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P7</h6></button>
                                                <button type="button" id="lanjutWO" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form WO</h6></button>
                                            </td></tr>
                                            <!-- WO -->
                                            <tr class="formWO"><td colspan="2"><hr></td></tr>
                                            <tr class="formWO"><td colspan="2"><h6 class="opacity-7 text-sm">FORM WORK ORDER</h6></td></tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Jenis Layanan</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="" id="">
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
                                                    <input type="number" name="" id="" min="0">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Total Harga ke Pelanggan</h6>
                                                            <p class="text-xs text-secondary mb-0">
                                                                format: Rp. xxx.xxx.-</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="rupiahs" type="text" name="harga_ke_plggn" id="harga_ke_plggn" style="width:350px;" placeholder="TOTAL HARGA"><br>
                                                    <input class="rupiahs" type="text" name="onetime_charge_plggn" id="onetime_charge_plggn" style="width:350px;" placeholder="ONE TIME CHARGE"><br>
                                                    <input class="rupiahs" type="text" name="monthly_plggn" id="monthly_plggn" style="width:350px;" placeholder="MONTHLY / LOKASI">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                    <td colspan="2"><hr></td>
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
                                                    <input class="rupiahs" type="text" name="onetime_charge_telkom" id="onetime_charge_telkom" style="width:350px;" placeholder="Rp xxx.xxx.-">
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
                                                    <input type="number" min="0" name="persen_telkom" id="persen_telkom" placeholder="PERSEN" style="width:100px;"> % atau sebesar
                                                    <input type="text" name="monthly_telkom" id="monthly_telkom" placeholder="Rp xxx.xxx.-" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formWO">
                                                    <td colspan="2"><hr></td>
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
                                                    <input class="rupiahs" type="text" name="onetime_charge_mitra" id="onetime_charge_mitra" style="width:350px;" placeholder="Rp xxx.xxx.-">
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
                                                    <input type="number" min="0" name="persen_mitra" id="persen_mitra" placeholder="PERSEN" style="width:100px;"> % atau sebesar
                                                    <input type="text" name="monthly_mitra" id="monthly_mitra" placeholder="Rp xxx.xxx.-" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formWO"><td colspan="2">
                                                <button type="button" id="backP8" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form P8</h6></button>
                                                <button type="button" id="lanjutKL" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Lanjut Form KL</h6></button>
                                            </td></tr>
                                            <!-- KL -->
                                            <tr class="formKL"><td colspan="2"><hr></td></tr>
                                            <tr class="formKL"><td colspan="2"><h6 class="opacity-7 text-sm">FORM KL</h6></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Layanan yang disediakan Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="layanan_sedia_mitra" id="layanan_sedia_mitra" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nomor KL Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="no_kl_telkom" id="no_kl_telkom" style="width:300px;">
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
                                                    <input type="text" name="no_kl_mitra" id="no_kl_mitra" style="width:300px;">
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
                                                    <input type="text" name="tempat_ttd_kl" id="tempat_ttd_kl" style="width:300px;">
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
                                                    <input type="text" name="notaris" id="notaris" style="width:300px;">
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
                                                    <input type="text" name="akta_notaris" id="akta_notaris" style="width:300px;">
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
                                                    <input type="date" name="tgl_akta_notaris" id="tgl_akta_notaris" style="width:300px;">
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
                                                    <input type="text" name="nama_pejabat_telkom" id="nama_pejabat_telkom" style="width:300px;">
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
                                                    <input type="text" name="jabatan_pejabat_telkom" id="jabatan_pejabat_telkom" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><hr></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">NPWP Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="npwp_mitra" id="npwp_mitra" style="width:300px;">
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
                                                    <input type="text" name="no_anggaran_mitra" id="no_anggaran_mitra" style="width:300px;">
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
                                                    <input type="date" name="tgl_anggaran_mitra" id="tgl_anggaran_mitra" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Nama Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="nama_pejabat_mitra" id="nama_pejabat_mitra" style="width:300px;">
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
                                                    <input type="text" name="jabatan_pejabat_mitra" id="jabatan_pejabat_mitra" style="width:300px;">
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
                                                    <input type="text" name="no_skm" id="no_skm" style="width:300px;">
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
                                                    <input type="date" name="tgl_skm" id="tgl_skm" style="width:300px;">
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
                                                    <input type="text" name="perihal_skm" id="perihal_skm" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><hr></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Tanggal Akhir Berlaku KL</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" name="tgl_akhir_kl" id="tgl_akhir_kl" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><hr></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Pembayaran Uang Muka (DP) dari Telkom ke Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="bayar_dp" id="bayar_dp" style="width:300px;">
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
                                                    <input type="text" name="nama_bank_mitra" id="nama_bank_mitra" style="width:300px;">
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
                                                    <input type="text" name="cabang_bank_mitra" id="cabang_bank_mitra" style="width:300px;">
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
                                                    <input type="text" name="rek_bank_mitra" id="rek_bank_mitra" style="width:300px;">
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
                                                    <input type="text" name="an_bank_mitra" id="an_bank_mitra" style="width:300px;">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Service Level Guarantee (SLG) Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" name="slg_mitra" id="slg_mitra" style="width:100px;"> %
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2"><hr></td></tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Wakil Pihak Telkom</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="wakil_pihak_telkom" id="wakil_pihak_telkom" style="width:300px;" placeholder="NAMA : JABATAN">
                                                </td>
                                            </tr>
                                            <tr class="formKL">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Wakil Pihak Mitra</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="wakil_pihak_mitra" id="wakil_pihak_mitra" style="width:300px;" placeholder="NAMA : JABATAN">
                                                </td>
                                            </tr>
                                            <tr class="formKL"><td colspan="2">
                                                <button type="button" id="backWO" class="btn bg-gradient-secondary"><h6 class="mb-0 text-sm" style="color:white;">Kembali Form WO</h6></button>
                                                <button type="submit" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit All Form</h6></button>
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
        <script src="{{ asset('assets') }}/js/alertboot.min.js"></script>
        <script>
            $( document ).ready(function() {

                $('.filterAwal').show();
                $('.formP2').hide();
                $('.formP3').hide();
                $('.formP4').hide();
                $('.formP5').hide();
                $('.formP6').hide();
                $('.formP7').hide();
                $('.formP8').hide();
                $('.formWO').hide();
                $('.formKL').hide();
                $('.formP5-baru').hide();
                $('.formP6-baru').hide();
                $('.diatas-100').hide();
                $('.dibawah-100').hide();
                $('.status_rapat_pengadaan').hide();
                $('#formObl')[0].reset();

                $('input[type=radio][name=status_rapat_pengadaan]').change(function() {
                    if (this.value == 'ada') {
                        $('.status_rapat_pengadaan').show();
                    }
                    else if (this.value == 'nada') {
                        $('.status_rapat_pengadaan').hide();
                    }
                });

                var view_diatas_100='';
                $('input[type=radio][name=nilai_kontrak]').change(function() {
                    if (this.value == 'dibawah_100') {
                        view_diatas_100='0';
                    }
                    else if (this.value == 'diatas_100') {
                        view_diatas_100='1';
                    }
                });

                var view_baru='';
                $('input[type=radio][name=jenis_kotrak]').change(function() {
                    if (this.value == 'perpanjangan') {
                        view_baru = '0';
                    }
                    else if (this.value == 'baru') {
                        view_baru = '1';
                    }
                });

                $('#lanjutP2').click(function(){ $('.filterAwal').hide(); $('.formP2').show(); }); 
                
                $('#backFilter').click(function(){ $('.formP2').hide(); $('.filterAwal').show(); }); 
                $('#lanjutP3').click(function(){ $('.formP2').hide(); $('.formP3').show(); });

                $('#backP2').click(function(){ $('.formP3').hide(); $('.formP2').show(); }); 
                $('#lanjutP4').click(function(){ $('.formP3').hide(); $('.formP4').show(); }); 
                
                $('#backP3').click(function(){ $('.formP4').hide(); $('.formP3').show(); });
                $('#lanjutP5').click(function(){ 
                    if(view_baru=='1'){ $('.formP4').hide(); $('.formP5').show(); $('.formP5-baru').show();  }
                    else if(view_baru=='0'){ $('.formP4').hide(); $('.formP5').show(); $('.formP5-baru').hide(); }
                }); 
                
                $('#backP4').click(function(){ $('.formP5').hide(); $('.formP5-baru').hide(); $('.formP4').show(); });
                $('#lanjutP6').click(function(){
                    if(view_baru=='1'){ $('.formP5').hide(); $('.formP5-baru').hide(); $('.formP6').show(); $('.formP6-baru').show(); }
                    else if(view_baru=='0'){ $('.formP5').hide(); $('.formP5-baru').hide(); $('.formP6').show(); $('.formP6-baru').hide(); }
                });

                $('#backP5').click(function(){
                    if(view_baru=='1'){ $('.formP6').hide(); $('.formP6-baru').hide(); $('.formP5').show(); $('.formP5-baru').show();  }
                    else if(view_baru=='0'){ $('.formP6').hide(); $('.formP6-baru').hide(); $('.formP5').show(); $('.formP5-baru').hide();  }
                });
                $('#lanjutP7').click(function(){ 
                    $('.formP6').hide(); $('.formP6-baru').hide(); $('.formP7').show(); 
                    if(view_diatas_100=='1'){ $('.dibawah-100').hide(); $('.diatas-100').show();  }
                    else if(view_diatas_100=='0'){ $('.diatas-100').hide(); $('.dibawah-100').show();  }
                });

                $('#backP6').click(function(){
                    if(view_baru=='1'){ $('.formP7').hide(); $('.formP6').show(); $('.formP6-baru').show(); }
                    else if(view_baru=='0'){ $('.formP7').hide(); $('.formP6').show(); $('.formP6-baru').hide(); }
                });
                $('#lanjutP8').click(function(){ $('.formP7').hide(); $('.formP8').show(); });
                
                $('#backP7').click(function(){
                    if(view_diatas_100=='1'){ $('.formP8').hide(); $('.formP7').show(); $('.dibawah-100').hide(); $('.diatas-100').show();   }
                    else if(view_diatas_100=='0'){ $('.formSP').hide(); $('.formP7').show(); $('.dibawah-100').show(); $('.diatas-100').hide();   }
                });
                $('#lanjutWO').click(function(){ $('.formP8').hide(); $('.formWO').show(); });

                $('#backP8').click(function(){ $('.formWO').hide(); $('.formP8').show();  });

                $('#backWO').click(function(){
                    $('.dibawah-100').hide(); $('.diatas-100').hide(); $('.formKL').hide(); $('.formWO').show();  
                });
                $('#lanjutKL').click(function(){
                    $('.dibawah-100').hide(); $('.diatas-100').hide(); $('.formWO').hide(); $('.formKL').show();
                });


                // STARTLINE: FORMAT RUPIAH FORM P5 Harga Penawaran
                var rupiah = document.getElementById('harga_penawaran');
                rupiah.addEventListener('keyup', function(e){
                    rupiah.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah1 = document.getElementById('harga_ke_plggn');
                rupiah1.addEventListener('keyup', function(e){
                    rupiah1.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah2 = document.getElementById('onetime_charge_plggn');
                rupiah2.addEventListener('keyup', function(e){
                    rupiah2.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah3 = document.getElementById('monthly_plggn');
                rupiah3.addEventListener('keyup', function(e){
                    rupiah3.value = formatRupiah(this.value, 'Rp. ');
                });
                
                var rupiah4 = document.getElementById('onetime_charge_telkom');
                rupiah4.addEventListener('keyup', function(e){
                    rupiah4.value = formatRupiah(this.value, 'Rp. ');
                });
                
                var rupiah5 = document.getElementById('monthly_telkom');
                rupiah5.addEventListener('keyup', function(e){
                    rupiah5.value = formatRupiah(this.value, 'Rp. ');
                });
                
                var rupiah6 = document.getElementById('onetime_charge_mitra');
                rupiah6.addEventListener('keyup', function(e){
                    rupiah6.value = formatRupiah(this.value, 'Rp. ');
                });
                
                var rupiah7 = document.getElementById('monthly_mitra');
                rupiah7.addEventListener('keyup', function(e){
                    rupiah7.value = formatRupiah(this.value, 'Rp. ');
                });
                var rupiah8 = document.getElementById('bayar_dp');
                rupiah8.addEventListener('keyup', function(e){
                    rupiah8.value = formatRupiah(this.value, 'Rp. ');
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


                // Start dd rows table SP
                var counter = 1;
                $("#insertRow").on("click", function (event) {
                    event.preventDefault();
                    var newRow = $("<tr>");
                    var cols = '';
                    // Table columns
                    cols += '<th scrope="row">' + counter + '</th>';
                    cols += '<td><textarea cols="10" rows="1" class="" type="text" name="lampiran_layanan_barang[]" id="lampiran_layanan_barang" placeholder=""></textarea></td>';
                    cols += '<td><textarea cols="10" rows="1" class="" type="text" name="lampiran_spesifikasi[]" id="lampiran_spesifikasi" placeholder=""></textarea></td>';
                    cols += '<td><textarea cols="10" rows="1" class="" type="text" name="lampiran_merek[]" id="lampiran_merek" placeholder=""></textarea></td>';
                    cols += '<td><input style="width:100px;" class="" type="text" name="lampiran_volume[]" id="lampiran_volume" placeholder=""></td>';
                    cols += '<td><input style="width:100px;" class="" type="text" name="lampiran_satuan[]" id="lampiran_satuan" placeholder=""></td>';
                    cols += '<td><input style="width:100px;" class="" type="text" name="lampiran_harga_satuan[]" id="lampiran_harga_satuan" placeholder=""></td>';
                    cols += '<td><input style="width:100px;" class="" type="text" name="lampiran_harga_total[]" id="lampiran_harga_total" placeholder=""></td>';
                    cols += '<td><button style="width:35px;" type="button" class="btn btn-danger rounded-0" id="deleteRow"><i class="fa fa-trash"></i></button</td>';
                    // Insert the columns inside a row
                    newRow.append(cols);
                    // Insert the row inside a table
                    $("#lampiranSpek").append(newRow);
                    // Increase counter after each row insertion
                    counter++;
                });
                // Remove row when delete btn is clicked
                $("#lampiranSpek").on("click", "#deleteRow", function (event) {
                    $(this).closest("tr").remove();
                    counter -= 1
                });
                // end add rows table SP

            });

        </script>
        @endpush
</x-layout>
