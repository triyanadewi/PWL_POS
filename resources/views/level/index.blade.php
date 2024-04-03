@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Level')
@section('content_header_title', 'Manage')
@section('content_header_subtitle', 'Level')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Level</div>
            <div class="card-body">
                <a href="/level/create" class="btn btn-primary mb-3"><i class="fas fa-fw fa-plus"></i> Add Level</a>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush