<form action="{{ url('/kendaraan/create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambahkendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">Tambah Kendaraan Baru</h4>
                </div>
                <div class="modal-body">
                    <label>Nama Kendaraan <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <input name="nama" type="text" class="form-control" placeholder="Masukkan nama kendaraan"
                            aria-label="nama" value="">
                    </div>
                    <label>Plat Nomor Kendaraan <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <input name="plat" type="text" class="form-control" placeholder="Masukkan plat kendaraan"
                            aria-label="plat" value="">
                    </div>
                    <label>Vit Kendaraan <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <input name="vit" type="number" class="form-control" placeholder="Masukkan vit kendaraan"
                            aria-label="vit" value="">
                    </div>
                    <label>Jenis Kendaraan <span class="text-danger">*</span></label>
                    <div class="input-group mb-3 input-group-outline">
                        <select class="form-control px-2" aria-label="Jenis Kendaraan" name="jenis_kendaraan">
                            <option class="ms-2" value="Truk">Truk</option>
                            <option value="Pick Up">Pick Up</option>
                        </select>
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
