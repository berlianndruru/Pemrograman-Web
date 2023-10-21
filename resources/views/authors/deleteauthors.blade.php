@extends('layout.main')

@section('title', 'Hapus Data Author')

@section('content')
    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('authors.deleteauthors') }}">
                    <!--untuk setiap method post harus menggunakan @csrf -->
                    @csrf
                    <input type="hidden" name="id" value="{{ $author->id }}" name="id" />
                    <p>
                        Author : <br>
                        <input type="text" name="author" value="{{ $author->name }}" disabled/>
                    </p>
        
                    <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('authors.indexauthors') }}'">
                        <i class="fa fa-arrow-circle-left"></i> Kembali
                    </button>
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
@endsection