@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <form action="/program/create" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="gambar">Gambar:</label>
        <input type="file" id="gambar" name="gambar">

        <label for="tagProgram">Tag Program:</label>
        <input type="text" id="tagProgram" name="tagProgram">

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul">

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi"></textarea>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection