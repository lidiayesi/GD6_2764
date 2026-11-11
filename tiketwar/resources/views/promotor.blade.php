@extends('layouts.main')

@section('title', 'Daftar Promotor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Promotor</h1>
    <a href="{{ route('promotor.create') }}" class="btn btn-primary">Tambah Promotor</a>
</div>
<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Nama Promotor</th>
            <th>Kontak</th>
            <th>Jumlah Konser</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daftarPromotor as $promotor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $promotor->nama }}</td>
                <td>{{ $promotor->kontak }}</td>
                <td>{{ $promotor->konsers_count }}</td>
                <td>
                    <a href="{{ route('promotor.edit', $promotor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('promotor.destroy', $promotor->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus promotor ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada promotor.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection