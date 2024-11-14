@extends('layouts.main')
@section('title')
PT. Trisurya Solusindo Utama || Product
@endsection
@section('content')
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="{{asset('bgrr2.png')}}" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Produk ICA</h5>
                <p>Icain</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="{{asset('bgrr2.png')}}" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Produk ICA</h5>
                <p>Icain</p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="{{asset('bgrr2.png')}}" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Produk ICA</h5>
                <p>Icain</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container px-5 pb-5 mt-5">
    <h1 class="fw-bolder text-center mb-4">Product Gallery</h1>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($data as $d)
                    <div class="col mb-5">
                        <div class="card h-100 shadow-lg border-0 rounded">
                            <!-- Product image -->
                            @if($d->gambar)
                                @php
                                    $images = json_decode($d->gambar); // Decode the JSON string into an array
                                @endphp
                                <div id="carousel{{ $d->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ Storage::url($image) }}" class="d-block w-100 card-img-top rounded" alt="Product Image">
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
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder mb-2">{{ $d->name }}</h5>
                                    <!-- Product price-->
                                    <p class="text-muted mb-0">Rp. {{ number_format($d->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-primary mt-auto w-100" href="#">View Product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection
