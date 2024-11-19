@extends('layouts.main')

@section('title')
PT. Trisurya Solusindo Utama || Customer
@endsection

@section('content')
<div class="container px-5 pb-5 mt-5">
    <h1 class="fw-bold mb-4 text-center" style="font-size: 24px">Customer</h1>
    <div class="row gx-1 gy-1"> <!-- Reduced gap between columns -->
        @foreach ($data as $d)
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm position-relative">
                <div class="card-body d-flex justify-content-center align-items-center p-2">
                    <img src="{{ asset('storage/'.$d->logo) }}" class="img-fluid logo-image shadow" alt="{{ $d->company_name }}">
                </div>
                <a href="{{ $d->link }}" target="_blank" class="hover-overlay">
                    <div class="overlay-content text-center">
                        <p class="m-0 fw-bold" style="color: white">{{ $d->company_name }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    /* Styling for the cards */
    .card {
        overflow: hidden;
        /* position: relative; */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 120px; /* Make the card shorter */
    }

    .logo-image {
        max-height: 110px; /* Adjust logo size */
        max-width: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Added shadow for logos */
        border-radius: 8px; /* Optional for rounded edges */
    }

    .card:hover img {
        transform: scale(1.1);
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    /* Overlay styling */
    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        text-decoration: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .card:hover .hover-overlay {
        opacity: 1;
    }

    .overlay-content p {
        font-size: 0.85rem;
        margin: 0;
    }

    /* Reduce gap between rows and columns */
    .row.gx-1 {
        margin-left: -0.5rem; /* Reduced margin */
        margin-right: -0.5rem; /* Reduced margin */
    }

    .row.gy-1 > [class*="col-"] {
        margin-bottom: 0.5rem; /* Reduced bottom spacing */
    }
</style>
@endsection
