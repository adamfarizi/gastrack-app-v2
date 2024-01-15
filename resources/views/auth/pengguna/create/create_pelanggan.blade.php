<form action="{{ url('/pengguna/pelanggan/create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambahpelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Tambah Pelanggan Baru</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="nama_perusahaan" type="text" class="form-control" placeholder="Masukkan nama perusahaan"
                                    aria-label="nama" value="{{ old('nama_perusahaan') }}">
                            </div>
                        </div>
                        <div class="col">
                            <label>Nama Pemilik <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="nama_pemilik" type="text" class="form-control" placeholder="Masukkan nama pemilik"
                                    aria-label="nama" value="{{ old('nama_pemilik') }}">
                            </div>
                        </div>
                        <div class="col">
                            <label>Email <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="email" type="email" class="form-control" placeholder="Masukkan email pelanggan"
                                    aria-label="email" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>No Hp <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="no_hp" type="number" class="form-control" placeholder="Masukkan nomor hp"
                                    aria-label="no_hp" value="{{ old('no_hp') }}">
                            </div>
                        </div>
                        <div class="col">
                            <label>Jadwal Bayar <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <select class="form-control px-2" aria-label="Jadwal Bayar" name="jadwal_bayar">
                                    <option value="2">2 Minggu</option>
                                    <option value="3">3 Minggu</option>
                                    <option value="4">4 Minggu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label>BOP Pelanggan <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 input-group-outline">
                                <input name="bop" type="number" class="form-control" placeholder="Masukkan bop pelanggan"
                                    aria-label="bop" value="{{ old('bop') }}">
                            </div>
                        </div>
                    </div>
                    <label>Alamat <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <textarea name="alamat" type="text" class="form-control" placeholder="Masukkan alamat pelanggan"
                            style="height: 70px; resize: none;" aria-label="alamat" value=""></textarea>
                    </div>
                    <label>Password <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <input name="password" type="password" class="form-control" placeholder="Masukkan password"
                            aria-label="password" value="">
                    </div>
                    <label>Konfirmasi Password <span class="text-danger">*</label>
                    <div class="input-group mb-3 input-group-outline">
                        <input name="konfirmasi_password" type="password" class="form-control" placeholder="Masukkan ulang password"
                            aria-label="konfirmasi_password" value="">
                    </div>
                    <div class="text-center ">
                        <button type="submit" name="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0"
                            values="Update">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
