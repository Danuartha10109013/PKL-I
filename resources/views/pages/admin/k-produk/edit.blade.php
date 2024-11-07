@extends('layouts.admin.main')
@section('title', 'Edit Produk || Admin')
@section('pages', 'Edit Produk')

@section('content')
<div class="card">
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <h4>Edit Produk || {{$data->name}}</h4>
        </div>
        <form action="{{ route('admin.product.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- For update request -->

            <div class="form-control">
                <!-- Kode Produk (Read-only) -->
                <div class="mb-3">
                    <label for="kode_produk" class="form-label">Kode Produk</label>
                    <input type="text" name="kode_produk" class="form-control" value="{{ $data->kode_produk }}" readonly>
                </div>

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required>{{ $data->deskripsi }}</textarea>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" value="{{ $data->harga }}" required>
                </div>

                <!-- Spesifikasi (Dynamic fields) -->
                <div class="mb-3">
                    <label for="sfesifikasi" class="form-label">Spesifikasi</label>
                    <div id="specificationsContainer">
                        @php
                            $specs = json_decode($data->sfesifikasi); // Decode the JSON string into an array
                        @endphp
                        @foreach($specs as $spec)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="sfesifikasi[]" value="{{ $spec }}" required>
                            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">-</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary" onclick="addSpecification()">+</button>
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" name="gambar[]" class="form-control" multiple>
                    <!-- Show current images -->
                    @if ($data->gambar)
                        <div class="mt-2">
                            @foreach (json_decode($data->gambar) as $image)
                                <img src="{{ asset('storage/' . $image) }}" width="100px" alt="Product Image">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Jenis ID -->
                <div class="mb-3">
                    <label for="jenis_id" class="form-label">Jenis Produk</label>
                    <input type="number" name="jenis_id" class="form-control" value="{{ $data->jenis_id }}" required>
                </div>

                <!-- Kategori ID -->
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori Produk</label>
                    <input type="number" name="kategori_id" class="form-control" value="{{ $data->kategori_id }}" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Produk</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    // Function to add a new specification input field
    function addSpecification() {
        // Get the container where the input fields will be added
        const container = document.getElementById('specificationsContainer');
        
        // Create a new div element that will hold the new input field and the remove button
        const inputGroup = document.createElement('div');
        
        // Assign the appropriate classes for styling
        inputGroup.className = 'input-group mb-2';
        
        // Set the inner HTML of the new div with an input field and remove button
        inputGroup.innerHTML = `
            <input type="text" class="form-control" name="sfesifikasi[]" placeholder="Enter specification" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">-</button>
        `;
        
        // Append the newly created input group to the container
        container.appendChild(inputGroup);
    }

    // Function to remove a specification input field when the "-" button is clicked
    function removeField(button) {
        // Get the parent div of the button (which is the input group div)
        const inputGroup = button.parentElement;
        
        // Remove the input group from the container
        inputGroup.remove();
    }
</script>
@endsection
@endsection
