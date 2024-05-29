@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @empty(!$user->image)
                <div class="text-center">
                    <img src="{{ asset($user->image) }}" alt="Foto Profil" style="max-width: 200px;" data-toggle="modal" data-target="#imageModal">
                </div>
                @else
                <div class="text-center">
                    <img src="{{ asset('gambar/User.jpg') }}" alt="Foto Profil Default" style="max-width: 200px;" data-toggle="modal" data-target="#imageModal">
                </div>
                @endempty
                
                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Foto Profil</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @empty(!$user->image)
                                <img src="{{ asset($user->image) }}" alt="Foto Profil" style="width: 100%;">
                                @else
                                <img src="{{ asset('gambar/User.jpg') }}" alt="Foto Profil Default" style="width: 100%;">
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @empty($user)
                <p>Data yang Anda cari tidak ditemukan.</p>
                @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $user->level->level_nama }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>********</td>
                    </tr>
                </table>
                @endempty
                <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush