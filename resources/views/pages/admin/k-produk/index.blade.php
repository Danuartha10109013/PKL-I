@extends('layouts.admin.main')
@section('title', 'Kelola Produk || Admin')
@section('pages', 'Kelola Produk')

@section('content')
<div class="card">
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <h4>Kelola Produk</h4>

            <div>
                <!-- Button to Filter by Kategori -->
                <button onclick="showFilterKategori()" style="border:none; background:none; cursor: pointer;">
                    <i class="material-symbols-rounded opacity-5">filter</i> Filter Kategori
                </button>
            </div>

            <div>
                <!-- Button to Filter by Jenis -->
                <button onclick="showFilterJenis()" style="border:none; background:none; cursor: pointer;">
                    <i class="material-symbols-rounded opacity-5">filter</i> Filter Jenis
                </button>
            </div>

            <script>
            function showFilterKategori() {
                Swal.fire({
                    title: 'Filter by Kategori',
                    html:
                        '<ul style="list-style: none; padding: 0;">' +
                        '<li><button class="mb-3 btn btn-primary" onclick="applyFilter(\'Kategori A\')">Kategori A</button></li>' +
                        '<li><button class="mb-3 btn btn-primary" onclick="applyFilter(\'Kategori B\')">Kategori B</button></li>' +
                        '<li><button class="mb-3 btn btn-primary" onclick="applyFilter(\'Kategori C\')">Kategori C</button></li>' +
                        '</ul>',
                    showConfirmButton: false
                });
            }

            function showFilterJenis() {
                Swal.fire({
                    title: 'Filter by Jenis',
                    html:
                        '<ul style="list-style: none; padding: 0;">' +
                        '<li><button onclick="applyFilter(\'Jenis A\')">Jenis A</button></li>' +
                        '<li><button onclick="applyFilter(\'Jenis B\')">Jenis B</button></li>' +
                        '<li><button onclick="applyFilter(\'Jenis C\')">Jenis C</button></li>' +
                        '</ul>',
                    showConfirmButton: false
                });
            }

            function applyFilter(filter) {
                Swal.fire({
                    icon: 'success',
                    title: `Filter applied: ${filter}`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            </script>
            
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="material-symbols-rounded">add</i> &nbsp;Add Product</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Spesifikasi</th>
                        <th>Gambar</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->kategori_id }}</td>
                        <td>{{ $d->jenis_id }}</td>
                        <td>{{ $d->harga }}</td>
                        <td class="align-middle">
                            <!-- Slider for Images -->
                            @if($d->gambar)
                                @php
                                    $images = json_decode($d->gambar); // Decode the JSON string into an array
                                @endphp
                                <div id="carousel{{ $d->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($image) }}" class="d-block w-100" alt="Product Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $d->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $d->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            <!-- List for Specifications -->
                            @if($d->sfesifikasi)
                                @php
                                    $specifications = json_decode($d->sfesifikasi); // Decode the JSON string into an array
                                @endphp
                                <ul class="list-unstyled">
                                    @foreach ($specifications as $spec)
                                        <li>{{ $spec }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        
                        <td class="text-center align-middle">
                         <!-- Edit Button -->
                        <a href="{{route('admin.product.edit',$d->id)}} " class="btn btn-warning"><i class="material-symbols-rounded">edit</i> &nbsp;Edit</a>

                       <!-- Delete Button -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal{{ $d->id }}">
                            <i class="material-symbols-rounded">delete</i> &nbsp;Delete
                        </button>

                    </td>
                    </tr>
                    
                    

                    <script>
                        function addSpecification() {
                            const container = document.getElementById('specificationsContainer');
                            const inputGroup = document.createElement('div');
                            inputGroup.classList.add('input-group', 'mb-2');
                            inputGroup.innerHTML = `
                                <input type="text" class="form-control" name="sfesifikasi[]" required>
                                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">-</button>
                            `;
                            container.appendChild(inputGroup);
                        }

                        function removeField(button) {
                            button.closest('.input-group').remove();
                        }

                       
                    </script>

                    <!-- Delete Product Modal -->
                    <div class="modal fade" id="deleteProductModal{{ $d->id }}" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.product.delete', $d->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this product?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>

       <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="kode_produk" class="form-label">Product Code</label>
                                <input type="text" class="form-control" style="outline: 2px solid grey;" id="kode_produk" name="kode_produk" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" style="outline: 2px solid grey;" style="outline: 2px solid grey;" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control" id="deskripsi" style="outline: 2px solid grey;" name="deskripsi" rows="3" required></textarea>
                            </div>
                            
                            <!-- Dynamic Specifications -->
                            <div class="mb-3">
                                <label class="form-label">Specifications</label>
                                <div id="specificationsContainer">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="sfesifikasi[]"  placeholder="Enter specification" required>
                                        <button type="button" class="btn btn-outline-primary" onclick="addSpecification()">+</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dynamic Image Uploads -->
                            <div class="mb-3">
                                <label class="form-label">Images</label>
                                <div id="imagesContainer">
                                    <div class="input-group mb-2">
                                        <input type="file" class="form-control" name="gambar[]"  accept="image/*" required>
                                        <button type="button" class="btn btn-outline-primary" onclick="addImage()">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="harga" class="form-label">Price</label>
                                <input type="number" class="form-control" id="harga" style="outline: 2px solid grey;" name="harga" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="jenis_id" class="form-label">Type</label>
                                <select class="form-select" id="jenis_id" style="outline: 2px solid grey;" name="jenis_id" required>
                                    <option value="" selected disabled>Select Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Category</label>
                                <select class="form-select" id="kategori_id" style="outline: 2px solid grey;" name="kategori_id" required>
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- JavaScript for Adding More Fields -->
        <script>
            function addSpecification() {
                const container = document.getElementById('specificationsContainer');
                const inputGroup = document.createElement('div');
                inputGroup.className = 'input-group mb-2';
                inputGroup.innerHTML = `
                    <input type="text" class="form-control" name="sfesifikasi[]" placeholder="Enter specification" required>
                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">-</button>
                `;
                container.appendChild(inputGroup);
            }

            function addImage() {
                const container = document.getElementById('imagesContainer');
                const inputGroup = document.createElement('div');
                inputGroup.className = 'input-group mb-2';
                inputGroup.innerHTML = `
                    <input type="file" class="form-control" name="gambar[]" accept="image/*" required>
                    <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">-</button>
                `;
                container.appendChild(inputGroup);
            }

            function removeField(button) {
                button.parentElement.remove();
            }
        </script>


    </div>
</div>
@endsection