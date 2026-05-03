@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Data Kategori</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        <a href="{{ route('viewCreateCategory') }}" class="btn btn-primary">Add Category</a>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($categories->isEmpty())
        <p>No categories found.</p>
        @else
        @foreach ($categories as $item)
        <div>
            <p>{{ $item->namaCategory }}</p>
            <a href="{{ route('viewEditCategory', $item->id) }}">Edit</a>
            <form action="{{ route('deleteCategory', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
        @endforeach
        @endif
    </section>
</div>