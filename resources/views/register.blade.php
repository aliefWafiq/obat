<h1>SIGN UP</h1>
<form action="/register/action" method="POST">
    @csrf
    @error('username')
        <div class="error">{{ $message }}</div>
    @enderror
    <input type="text" name="username" placeholder="Name">
    @error('phoneNumber')
        <div class="error">{{ $message }}</div>
    @enderror
    <input type="number" name="phoneNumber" placeholder="Nomor Hp">
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Sign Up</button>
</form>