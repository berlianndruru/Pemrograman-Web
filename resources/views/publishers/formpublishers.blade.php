@extends('layout.main')

@section('title', 'Tambah Publisher')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Terdapat Error pada aplikasi : </h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('publishers.storepublishers') }}">
                <!--untuk setiap method post harus menggunakan @csrf -->
                @csrf
                <div class="form-group">
                    <label for="">Nama Publisher</label>
                    <input class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text"
                        name="name" />
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
