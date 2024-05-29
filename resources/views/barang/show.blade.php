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
        @else
        <div class="row">
            <div class="col-md-4">
                @empty(!$barang->image)
                <div class="text-center">
                    <img src="{{ asset($barang->image) }}" alt="Gambar Barang" style="max-width: 200px;" data-toggle="modal" data-target="#imageModal">
                </div>
                @else
                <div class="text-center">
                    <img src="{{ asset('gambar/Barang.jpg') }}" alt="Gambar Barang Default" style="max-width: 200px;" data-toggle="modal" data-target="#imageModal">
                </div>
                @endempty
                
                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Gambar Barang</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @empty(!$barang->image)
                                <img src="{{ asset($barang->image) }}" alt="Gambar Barang" style="width: 100%;">
                                @else
                                <img src="{{ asset('gambar/barang.jpg') }}" alt="Gambar Barang Default" style="width: 100%;">
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $barang->barang_id }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $barang->kategori->kategori_nama }}</td>
                    </tr>
                    <tr>
                        <th>Kode Barang</th>
                        <td>{{ $barang->barang_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th>Harga Beli</th>
                        <td>{{ $barang->harga_beli }}</td>
                    </tr>
                    <tr>
                        <th>Harga Jual</th>
                        <td>{{ $barang->harga_jual }}</td>
                    </tr>
                </table>
                @endempty
                <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush