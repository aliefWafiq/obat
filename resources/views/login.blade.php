<h1>SIGN IN</h1>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<form action="/login/action" method="POST">
    @csrf
    <input type="number" name="phoneNumber" placeholder="Nomor Hp">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Sign Up</button>
</form>