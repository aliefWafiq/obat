@extends('layouts.adminLayout')

@section('content')
<div class="main-content" style="height: 100vh; display: flex; flex-direction: column;">
    <header class="header" style="flex-shrink: 0;">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Virtual Website</h1>
        </div>
    </header>

    <div style="flex: 1; padding: 1.5rem; background: #f8fafc; box-sizing: border-box; display: flex; flex-direction: column; overflow: hidden;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); flex: 1; display: flex; flex-direction: column; overflow: hidden; padding: 0.5rem; position: relative;">
            <iframe src="{{ url('/') }}" style="width: 100%; height: 100%; border: none; border-radius: 12px;"></iframe>
        </div>
    </div>
</div>
@endsection
