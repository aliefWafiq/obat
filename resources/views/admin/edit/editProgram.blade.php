@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <form action="/program/update/{{ $buatProgram->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="gambar">Gambar:</label>
        <input type="file" id="gambar" name="gambar">

        <label for="tagProgram">Tag Program:</label>
        <input type="text" id="tagProgram" name="tagProgram" value="{{ $buatProgram->tagProgram }}">

        <label for="judul">Judul:</label>
        <input type="text" id="judul" name="judul" value="{{ $buatProgram->judul }}">

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi">{{ $buatProgram->deskripsi }}</textarea>
        
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection