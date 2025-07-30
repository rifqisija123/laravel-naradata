<form method="POST" action="{{ route('riwayat.peminjaman.store') }}" id="formPeminjaman">
    @csrf
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <label for="jenis_id" class="form-label">Jenis <span class="text-danger">*</span></label>
            <div class="d-flex align-items-stretch">
                <div class="flex-grow-1">
                    <select name="jenis_id" id="jenis_id" class="tom-select w-100" required
                        data-placeholder="-- Pilih Jenis --">
                        <option value="" disabled selected hidden>-- Pilih Jenis --
                        </option>
                        @foreach ($jenisBarang as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="merek_id" class="form-label">Merek <span class="text-danger">*</span></label>
            <div class="d-flex align-items-stretch">
                <div class="flex-grow-1">
                    <select name="merek_id" id="merek_id" class="tom-select w-100" required
                        data-placeholder="-- Pilih Merek --">
                        <option value="" disabled selected hidden>-- Pilih Merek --
                        </option>
                        @foreach ($jenisBarang as $merek)
                            <option value="{{ $merek->merek_id }}">{{ $merek->merek }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="barang_id" class="form-label">Barang <span class="text-danger">*</span></label>
            <div class="d-flex align-items-stretch">
                <div class="flex-grow-1">
                    <select name="barang_id" id="barang_id" class="tom-select w-100"
                        data-placeholder="-- Pilih Barang --">
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="karyawan_id" class="form-label">Karyawan <span class="text-danger">*</span></label>
            <div class="d-flex align-items-stretch">
                <div class="flex-grow-1">
                    <select name="karyawan_id" id="karyawan_id" class="tom-select w-100" required
                        data-placeholder="-- Pilih Karyawan --">
                        <option value="" disabled selected hidden>-- Pilih Karyawan --</option>
                        @foreach ($karyawans as $karyawan)
                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="tanggal" class="form-label">Tanggal Peminjaman <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
        </div>
        <div class="col-md-6">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control" rows="3"></textarea>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end my-5">
        <a href="{{ route('riwayat.index') }}" class="btn btn-secondary me-2">Kembali</a>
        <button type="submit" class="btn btn-primary px-4">Submit</button>
    </div>
</form>
