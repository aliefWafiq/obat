<h1>EDIT USER</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/user/update/{{ $users->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="{{ $users->username }}">

    <label for="phoneNumber">Nomor Hp:</label>
    <input type="text" id="phoneNumber" name="phoneNumber" value="{{ $users->phoneNumber }}">

    <label for="alamat">Alamat:</label>
    <textarea id="alamat" name="alamat">{{ $users->alamat }}</textarea>

    <label for="role">Role:</label>
    <select id="role" name="role">
        <option value="user" {{ $users->role === 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $users->role === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>

    <button type="submit">Update</button>
</form>