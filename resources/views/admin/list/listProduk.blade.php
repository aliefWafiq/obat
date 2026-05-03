@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Data Produk</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        <a href="{{ route('viewCreateProduk') }}" class="btn btn-primary">Add Product</a>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($produk->isEmpty())
        <p>No products found.</p>
        @else
        @foreach ($produk as $item)
        <div>
            <p>{{ $item->namaProduk }} - Harga: {{ $item->harga }} - Stok: {{ $item->stok }}</p>
            <a href="{{ route('viewEditProduk', $item->id) }}">Edit</a>
            <form action="{{ route('deleteProduk', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
        @endforeach
        @endif
    </section>
</div>