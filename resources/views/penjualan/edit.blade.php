@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($penjualan)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
            <form method="POST" action="{{ url('/penjualan/'.$penjualan->penjualan_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang butuh method PUT -->
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">User</label>
                    <div class="col-10">
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Pilih User -</option>
                            @foreach($user as $item)
                            <option value="{{ $item->user_id }}" {{ $item->user_id == $penjualan->user_id ? 'selected' : '' }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('username')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Pembeli</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ $penjualan->pembeli }}" required>
                        @error('pembeli')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Detail Barang</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary mt-1" id="add" onclick="addData()">Tambah Barang</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="detail">
                        {{-- looping detail penjualan --}}
                            @foreach($penjualan->detail as $key => $detail)
                            <div id="row{{ $key + 1 }}">
                                <div class="form-group row">
                                    <label class="col-2 control-label col-form-label">Nama Barang</label>
                                    <div class="col-10">
                                        <select class="form-control" id="barang_id{{ $key + 1 }}" name="barang_id[]" required>
                                            <option value="">- Pilih Barang -</option>
                                            @foreach($barang as $item)
                                            <option value="{{ $item->barang_id }}" {{ $item->barang_id == $detail->barang_id ? 'selected' : '' }}>{{ $item->barang_kode }} - {{ $item->barang_nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('barang_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 control-label col-form-label">Jumlah</label>
                                    <div class="col-10">
                                        <input type="number" class="form-control" id="jumlah{{ $key + 1 }}" name="jumlah[]" value="{{ $detail->jumlah }}" required>
                                        @error('jumlah')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-2 control-label col-form-label"></label>
                                    <div class="col-10 d-flex justify-content-end align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeData(this)">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    {{-- button to add barang --}}
                    <button type="submit" class="btn btn-sm btn-primary btn-block">Simpan</button>
                    </div>
                </div>
            </form>
            <a class="btn btn-sm btn-default btn-block" href="{{ url('penjualan') }}">Kembali</a>
            @endempty
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    var i = {{ count($penjualan->detail) }};
    function addData() {
        i++;
        $('#detail').append(`
            <div id="row`+i+`">
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Kode Barang</label>
                    <div class="col-10">
                        <select class="form-control" id="barang_id`+i+`" name="barang_id[]" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                            @endforeach
                        </select>
                        @error('barang_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Jumlah</label>
                    <div class="col-10">
                        <input type="number" class="form-control" id="jumlah{{ $key + 1 }}" name="jumlah[]" value="{{ $detail->jumlah }}" required>                        @error('jumlah')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10 d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeData(this)">Hapus</button>
                    </div>
                </div>
            </div>
        `);
    }

    function removeData(element) {
        $(element).closest('.form-group.row').parent().remove();
    }
    
</script>
@endpush
