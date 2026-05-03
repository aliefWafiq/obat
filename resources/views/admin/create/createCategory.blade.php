<h1>CREATE CATEGORY</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/category/create" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="namaCategory">Nama Kategori:</label>
    <input type="text" id="namaCategory" name="namaCategory">
    <button type="submit">Create</button>
</form>