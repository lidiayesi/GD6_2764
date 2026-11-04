@extends('layouts.main') 
  
@section('title', $konser['nama']) 
  
@section('content') 
    <a href="{{ route('konser.index') }}" class="btn btn-outline-secondary mb-3">&larr; Kembali ke 
daftar</a> 

@if ($konser['sisa'] == 0)
    @include('partials.alert', ['tipe' => 'danger', 'pesan' => 'Maaf, tiket untuk konser ini sudah ludes terjual (Sold Out)!'])
@elseif ($konser['sisa'] < 10)
    @include('partials.alert', ['tipe' => 'warning', 'pesan' => 'Buruan war! Tiket hampir habis, sisa ' . $konser['sisa'] . ' tiket lagi.'])
@endif
  
    <div class="card"> 
        <div class="card-body"> 
            <h1 class="card-title h3">{{ $konser['nama'] }}</h1> 
            <p class="text-muted mb-1">Kota: {{ $konser['kota'] }}</p> 
            <p><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($konser['tanggal'])) }}</p>
            <p class="mb-1">Harga: Rp{{ number_format($konser['harga'], 0, ',', '.') }}</p> 
            <p>Sisa tiket: {{ $konser['sisa'] }}</p> 
  
            @if ($konser['sisa'] > 0) 
                <button class="btn btn-primary">War Tiket Sekarang</button> 
            @else 
                <button class="btn btn-secondary" disabled>Sold Out</button> 
            @endif 
        </div> 
    </div> 
@endsection 