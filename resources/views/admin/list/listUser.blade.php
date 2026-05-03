@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Data User</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($users->isEmpty())
        <p>No users found.</p>
        @else
        @foreach ($users as $item)
        <div>
            <p>{{ $item->username }} - Nomor Hp: {{ $item->phoneNumber }} - Role: {{ $item->role }}</p>
            <a href="{{ route('viewEditUser', $item->id) }}">Edit</a>
            <form action="{{ route('deleteUser', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
        @endforeach
        @endif
    </section>
</div>