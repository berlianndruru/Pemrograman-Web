@extends('layout.main')

@section('title', 'Update Buku')

@section('content')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('books.store') }}">
                <!--untuk setiap method POST harus menggunakan @csrf -->
                @csrf
                <div class="form-group">
                    <label for="">Kode</label>
                    <input class="form-control @error('code') is-invalid @enderror" value="{{ $book->code }}" type="text"
                        name=code />
                    @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Judul</label>
                    <input class="form-control @error('title') is-invalid @enderror" value="{{ $book->title }}"
                        type="text" name="title" />
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Publisher</label>
                    <select class="form-control"id="id_publisher">
                        @foreach ($publishers as $p)
                            <option {{ $p->id == $book->id_publisher ? 'selected' : '' }} value="{{ $p->id }}">
                                {{ $p->name }}</option>
                        @endforeach
                    </select>
        </div>
        <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('books.index') }}'">
            <i class="fa fa-arrow-circle-left"></i> Kembali
        </button>
        <button class="btn btn-success" type="submit">
            <i class="fa fa-refresh"></i> Ubah
        </button>
        </form>
    </div>
    </div>
@endsection