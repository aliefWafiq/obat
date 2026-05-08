@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <h1>List Buat Program</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <a href="{{ route('viewBuatProgram') }}" class="btn btn-primary mb-3">Tambah Program</a>
    @if($buatProgram->isEmpty())
    <p>Tidak ada data program.</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buatProgram as $program)
            <tr>
                <td><img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->nama }}" style="max-width: 100px;"></td>
                <td>
                    <a href="{{ route('viewEditProgram', $program->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('deleteProgram', $program->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection