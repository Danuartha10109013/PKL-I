@extends('layouts.main')

@section('title')
PT. Trisurya Solusindo Utama || Customer
@endsection

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<div class="container px-5 pb-5 mt-5">
    <h1 class="fw-bold mb-4 text-center" style="font-size: 32px; color: #ff4e50;" data-aos="fade-down">
        Customer
    </h1>
    <div class="row gx-1 gy-1 justify-content-center">
        @foreach ($data as $d)
        <div class="col-md-2" data-aos="fade-up">
            <div class="card text-center border-0 shadow-sm position-relative hover-animate">
                <div class="card-body d-flex justify-content-center align-items-center p-3">
                    <img src="{{ asset('storage/'.$d->logo) }}" class="img-fluid logo-image shadow" alt="{{ $d->company_name }}">
                </div>
                <a href="{{ $d->link }}" target="_blank" class="hover-overlay">
                    <div class="overlay-content text-center">
                        <i class="fas fa-link fa-2x mb-2"></i> <!-- Font Awesome link icon -->
                        <p class="m-0 fw-bold" style="color: white; font-size: 1.1rem;">{{ $d->company_name }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    AOS.init();
</script>

<style>
    /* Styling for the cards */
    .card {
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        background: linear-gradient(135deg, #ff4e50, #3b5998); /* Red to Blue gradient */
        opacity: 0; /* Start with the card invisible */
        transform: scale(0.8) translateX(-50%); /* Start with the card smaller and centered */
        animation: revealFromCenter 0.5s forwards; /* Animation from center */
    }

    @keyframes revealFromCenter {
        0% {
            opacity: 0;
            transform: scale(0.8) translateX(-50%);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateX(0);
        }
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
        transform: scale(1.1); /* Image scales up on hover */
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px) scale(1.05); /* Card scales up on hover */
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
        border-radius: 8px;
    }

    .card:hover .hover-overlay {
        opacity: 1;
    }

    .overlay-content p {
        font-size: 1rem;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }

    .overlay-content i {
        color: white;
        transition: transform 0.3s ease;
    }

    .card:hover .overlay-content i {
        transform: rotate(360deg); /* Icon rotation on hover */
    }

    /* Reduce gap between rows and columns */
    .row.gx-1 {
        margin-left: -0.5rem; /* Reduced margin */
        margin-right: -0.5rem; /* Reduced margin */
    }

    .row.gy-1 > [class*="col-"] {
        margin-bottom: 0.5rem; /* Reduced bottom spacing */
    }

    /* Hover animation */
    .hover-animate:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

</style>

@endsection
