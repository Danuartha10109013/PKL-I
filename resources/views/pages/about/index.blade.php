@extends('layouts.main')
@section('title')
PT. Trisurya Solusindo Utama || About
@endsection

@section('content')
<div class="container px-5 pb-5">
    <h1 class="fw-bold text-center mb-4" style="font-size: 32px; animation: fadeInDown 1s ease-out; color: #007bff;">
        <i class="fas fa-info-circle"></i> Tentang Kami
    </h1>
    
    <!-- About Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 mb-5" style="animation: fadeInUp 1s ease-out; background: linear-gradient(to right, #007bff, #00c6ff); color: white;">
                <div class="card-body text-center">
                    <h2 class="card-title fw-bold">{{$data->judul}}</h2>
                    <p class=" mt-3 " style="color: rgb(173, 173, 173)">{{$data->desc_judul}}</p>
                </div>
            </div>
        </div>
    </div>  
    
    <!-- Features Section -->
    @php
        $items = json_decode($data->item);
        $item_descs = json_decode($data->desc_item);
    @endphp
    <div class="row gy-4">
        @foreach ($items as $index => $item)
            <div class="col-md-6 col-lg-3" style="animation: fadeInLeft 1.2s ease-out;">
                <div class="feature-box p-4 bg-white text-center rounded shadow-sm border" style="transition: transform 0.3s;">
                    <div class="mb-3">
                        <i class="fas fa-star fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-center" style="font-size: 18px; color: #007bff;">{{ $item }}</h5>
                    <p class="text-muted">{{ $item_descs[$index] ?? 'Description not available' }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Mission/Vision Section -->
    <div class="mt-5" style="animation: fadeInUp 2s ease-out;">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="fw-bold text-center" style="font-size: 28px; color: #007bff;">
                    <i class="fas fa-bullseye"></i> Mission / Vision
                </h2>
                <p class="text-center text-muted mt-3">{{$data->visi}}</p>
                <div class="row mt-4">
                    @php
                      $misi_tagline = json_decode($data->misi_tagline);  
                      $misi = json_decode($data->misi);  
                    @endphp
                    @foreach ($misi_tagline as $index => $mt)
                        <div class="col-md-4 text-center">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h5 class="fw-bold">{{$mt}}</h5>
                            <p class="text-muted">{{$misi[$index] ?? 'Description not available'}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="mt-5" style="animation: fadeInUp 2.5s ease-out;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="fw-bold text-center" style="font-size: 28px; color: #007bff;">
                <i class="fas fa-map-marker-alt"></i> Lokasi Kami
            </h2>
            <p class="text-center text-muted mt-3">Lihat lokasi kami pada peta di bawah:</p>
            <div class="map-container mt-4">
                <iframe 
                    src="{{$data->link_map}}" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Company Info Section -->
<div class="mt-5" style="animation: fadeInUp 3s ease-out;">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h2 class="fw-bold" style="font-size: 28px; color: #007bff;">
                <i class="fas fa-phone-alt"></i> Hubungi Kami
            </h2>
            <p class="text-muted mt-3">Informasi kontak kami tersedia di bawah ini:</p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p><strong>Alamat:</strong> {{ $data->alamat }}</p>
                    <p><strong>Hotline:</strong> {{ $data->hotline }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $data->email }}" style="color: #007bff;">{{ $data->email }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Animations and Icons -->
<style>
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}
.feature-box:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}
</style>
@endsection
