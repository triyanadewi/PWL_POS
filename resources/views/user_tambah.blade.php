@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
<div class="container">
  <!-- general form elements disabled -->
    <div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Tambah User Baru</h3>
    </div>
    <!-- /.card-header -->

    <form method="post" action="/user/tambah_simpan">

        {{ csrf_field() }}

        <div class="card-body">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
            </div>
            <div class="form-group">
              <label for="level">Level ID</label>
              <input type="number" class="form-control" id="level_id" name="level_id" placeholder="Masukkan Level ID">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/user" class="btn btn-danger">Cancel</a>
        </div>
      </form>    
    <!-- /.card-body -->
    </div>
</div>
@endsection