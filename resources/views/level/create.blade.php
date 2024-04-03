@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
<div class="container">
  <!-- general form elements disabled -->
    <div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Tambah Level Baru</h3>
    </div>
    <!-- /.card-header -->

    <form method="post" action="/level">

        {{ csrf_field() }}

        <div class="card-body">
            <div class="form-group">
                <label for="level_kode">Kode Level</label>
                <input type="text" class="form-control" id="level_kode" name="level_kode" placeholder="Masukkan Kode Level">
            </div>
            <div class="form-group">
              <label for="level_nama">Nama Level</label>
              <input type="text" class="form-control" id="level_nama" name="level_nama" placeholder="Masukkan Nama Level">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/level" class="btn btn-danger">Cancel</a>
        </div>
      </form>    
    <!-- /.card-body -->
    </div>
</div>
@endsection