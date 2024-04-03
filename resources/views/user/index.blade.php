@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'User')
@section('content_header_title', 'Manage')
@section('content_header_subtitle', 'User')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage User</div>
            <div class="card-body">
                <a href="/user/tambah" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus"></i> Add User</a>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush