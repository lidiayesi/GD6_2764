@extends('layouts.main')

@section('title', 'Edit Promotor')

@section('content')
<h1 class="mb-3">Edit Promotor</h1>
<form action="{{ route('promotor.update', $promotor->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('partials.promotor-fields')
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('promotor.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection