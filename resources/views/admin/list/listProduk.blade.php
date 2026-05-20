@extends('layouts.adminLayout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('style/createProduk.css') }}" />
@endpush

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h1>Daftar Produk</h1>

            <a href="{{ route('viewEditStok') }}" class="back-btn">
                ← Edit Stok
            </a>
            <a href="{{ route('dashboard') }}" class="back-btn">
                ← Back Dashboard
            </a>
        </div>

        <div class="main-container">

            <!-- LEFT -->
            <div class="produk-list">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                <div class="table-header">
                    <h2>Daftar Produk</h2>

                    <div class="total-box">
                        Total: {{ count($produk) }}
                    </div>
                </div>

                @if($produk->isEmpty())
                    <div class="table-container">
                        <div style="padding: 3rem; text-align: center; color: #999;">
                            <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                            <p>Belum ada produk.</p>
                        </div>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($produk as $item)
                                <tr>
                                    <td>
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->namaProduk }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div
                                                style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $item->namaProduk }}</strong>
                                        <br>
                                        <small style="color: #999;">{{ Str::limit($item->deskripsi, 10) }}</small>
                                    </td>
                                    <td>{{ $item->category->namaCategory ?? 'N/A' }}</td>
                                    <td>
                                        <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="status {{ $item->stok > 0 ? 'active' : 'completed' }}">
                                            {{ $item->stok }} unit
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('viewEditProduk', $item->id) }}" class="action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('deleteProduk', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- RIGHT -->
            <div class="create-box">

                <h2>Create Produk</h2>

                <form action="/produk/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="gambar">Gambar:</label>
                        @error('gambar')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="file" id="gambar" name="gambar">
                    </div>

                    <div>
                        <label for="kodeProduk">Kode Produk:</label>
                        @error('kodeProduk')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" id="kodeProduk" name="kodeProduk" value="{{ old('kodeProduk') }}">
                    </div>

                    <div>
                        <label for="namaProduk">Nama Produk:</label>
                        @error('namaProduk')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" id="namaProduk" name="namaProduk" value="{{ old('namaProduk') }}">
                    </div>

                    <div>
                        <label for="deskripsi">Deskripsi:</label>
                        @error('deskripsi')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div>
                        <label for="idCategory">Kategori:</label>
                        @error('idCategory')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <select id="idCategory" name="idCategory">
                            <option value="">Pilih Kategori</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('idCategory') == $category->id ? 'selected' : '' }}>
                                    {{ $category->namaCategory }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="harga">Harga:</label>
                        @error('harga')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="number" id="harga" name="harga" value="{{ old('harga') }}">
                    </div>

                    <div>
                        <label for="stok">Stok:</label>
                        @error('stok')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="number" id="stok" name="stok" value="{{ old('stok') }}">
                    </div>

                    <button type="submit">
                        Create Produk
                    </button>

                </form>

            </div>

        </div>
    </div>
@endsection