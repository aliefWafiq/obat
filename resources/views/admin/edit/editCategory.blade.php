<h1>EDIT CATEGORY</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/category/update/{{ $category->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="namaCategory">Nama Kategori:</label>
    <input type="text" id="namaCategory" name="namaCategory" value="{{ $category->namaCategory }}">

    <button type="submit">Update</button>
</form>