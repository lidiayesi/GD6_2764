<?php 
  
use Illuminate\Support\Facades\Route; 
  
$daftarKonser = [ 
    1 => ['nama' => 'Coldplay - Music of the Spheres', 'kota' => 'Jakarta', 'harga' => 1500000, 'sisa' => 25, 'tanggal' => '2027-11-15'], 
    2 => ['nama' => 'NCT Dream - The Dream Show', 'kota' => 'Jakarta', 'harga' => 1200000, 'sisa' => 0, 'tanggal' => '2027-05-18'], 
    3 => ['nama' => 'Dewa 19 - Pesta Rakyat', 'kota' => 'Yogyakarta', 'harga' => 450000, 'sisa' => 120, 'tanggal' => '2027-08-10'], 
    4 => ['nama' => 'The Weeknd - After Hours Till Dawn', 'kota' => 'Surabaya', 'harga' => 3500000, 'sisa' => 4, 'tanggal' => '2027-03-29'], 
    5 => ['nama' => 'Hindia - Remember Fest', 'kota' => 'Bandung', 'harga' => 500000, 'sisa' => 18, 'tanggal' => '2027-09-28'], 
]; 
  
Route::get('/', function () { 
    return view('home'); 
})->name('home'); 
  
Route::get('/konser', function () use ($daftarKonser) { 
    return view('konser', compact('daftarKonser')); 
})->name('konser.index'); 
  
Route::get('/konser/{id}', function ($id) use ($daftarKonser) { 
    abort_unless(isset($daftarKonser[$id]), 404); 
  
    return view('konser-detail', [ 
        'id' => $id, 
        'konser' => $daftarKonser[$id], 
    ]); 
})->whereNumber('id')->name('konser.detail'); 
  
Route::view('/tentang', 'about')->name('tentang'); 