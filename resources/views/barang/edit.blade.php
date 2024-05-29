@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($barang)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <div class="text-center">
            <img src="{{ asset($barang->image) }}" alt="Gambar Barang" style="max-width: 200px;">
        </div>
        <form method="POST" action="{{ url('/barang/'.$barang->barang_id) }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- tambahkan baris ini untuk proses edit yang membutuhkan method PUT -->
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kategori</label>
                <div class="col-11">
                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $item)
                        <option value="{{ $item->kategori_id }}" @if($item->kategori_id == $barang->kategori_id) selected @endif>{{ $item->kategori_nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ old('barang_kode', $barang->barang_kode) }}" required>
                    @error('barang_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama Barang</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ old('barang_nama', $barang->barang_nama) }}" required>
                    @error('barang_nama')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga Beli</label>
                <div class="col-11">
                    <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" required>
                    @error('harga_beli')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Harga Jual</label>
                <div class="col-11">
                    <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" required>
                    @error('harga_jual')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Gambar Barang</label>
                <div class="col-11">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" onchange="updateFileName()">
                        <label class="custom-file-label" for="image" id="file-name">
                            {{ old('image', $barang->image) ? basename($barang->image) : 'No file chosen' }}
                        </label>
                    </div>
                    @error('image')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @else
                    <small class="form-text text-muted">Abaikan (jangan diisi) jika tidak ingin mengganti gambar barang.</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('barang') }}">Kembali</a>
                </div>
            </div>
        </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function updateFileName() {
        const fileInput = document.getElementById('image');
        const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file chosen';
        document.getElementById('file-name').innerText = fileName;
    }
</script>
@endpush