@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')
{{-- Content body: main page content --}}
@section('content')
<div class="container">
    <!-- general form elements disabled -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Edit Level</h3>
        </div>
        <!-- /.card-header -->

        <form method="post" action="../edit_save/{{ $data->level_id }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="level_kode">Kode Level</label>
                    <input type="text" class="form-control" id="level_kode" name="level_kode" value="{{ $data->level_kode }}">
                </div>
                <div class="form-group">
                    <label for="level_nama">Nama Level</label>
                    <input type="text" class=form-control id="level_nama" name="level_nama" value="{{ $data->level_nama }}">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/level" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection