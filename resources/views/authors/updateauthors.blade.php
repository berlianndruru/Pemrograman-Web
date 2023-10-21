@extends('layout.main')

@section('title', 'Update Author')

@section('content')

    <!--menggunakan route harus diikuti dengan nama
            apabila menggunakan urls harus mengguanakan urls -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('authors.updateauthors') }}">
                <!--untuk setiap method post harus menggunakan @csrf -->
                <input type="hidden" name="id" value="{{ $authors->id }}">
                @csrf
                <div class="form-group">
                    <label for="">Nama</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                        value="{{ $authors->name }}" name="name" />
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('authors.indexauthors') }}'">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </button>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-refresh"></i> Ubah
                </button>
            </form>
        </div>
    </div>
@endsection
