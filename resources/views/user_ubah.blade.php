@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Edit')
{{-- Content body: main page content --}}
@section('content')
<div class="container">
    <!-- general form elements disabled -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>
        <!-- /.card-header -->

        <form method="post" action="../ubah_simpan/{{ $data->user_id }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}">
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" value="{{ $data->password }}">
                </div>
                <div class="form-group">
                  <label for="level">Level ID</label>
                  <input type="number" class="form-control" id="level_id" name="level_id" value="{{ $data->level_id }}">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/user" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection