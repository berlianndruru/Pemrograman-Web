@extends('layout.main')

@section('title', 'Tambah Author')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('authors.storeauthors') }}">
                @csrf
                <div class="form-group">
                    <label for="">Nama</label>
                    <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" name="name" />
                    @error('name')
                        <span class="invalid-feedback"> {{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i>Simpan
                </button>
            </form>
        </div>
    </div>
@endsection