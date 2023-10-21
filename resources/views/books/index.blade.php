@extends('layout.main')
@section('title', 'Data Buku')

@section('content')
    @if ($message = Session::get('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            {{ $message }}
        </div>
    @endif

    <a class="btn btn-primary mb-2" href="{{ route('books.create') }}">Tambah Buku</a>
    <a target="_blank" class="btn btn-danger mb-2" href="{{ route('books.print') }}?search={{old('search')}}">Export PDF</a>
    <a target="_blank" class="btn btn-success mb-2" href="{{ route('books.export.excel') }}">Export Excel</a>

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <form action="">
                    <input type="text" placeholder="Cari Buku" name="search" class="form-control" />
                </form>
            </div>
        </div>

        <div class="card-body">
            <table class="table" width=100%>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($books as $book)
                        <tr>
                            <th>{{ $no++ }}</th>
                            <th>{{ $book->code }}</th>
                            <th>{{ $book->title }}</th>
                            <th>
                                @foreach ($book->authors as $author)
                                    {{ $author->name }} <br>
                                @endforeach
                            </th>
                            <th>{{ $book->publisher->name }}</th>
                            <td>
                                <a class="btn btn-dark btn-sm" href="{{ route('books.edit', [$book->id]) }}"><i
                                        class="fa fa-pencil-alt"></i></a> |
                                <a class="btn btn-danger btn-sm" href="{{ route('books.del.confirm', [$book->id]) }}"><i
                                        class="fa fa-trash-alt"></i></a>
                                <a class="btn btn-outline-danger btn-sm" target="_blank" href="{{ route('books.print.detail', [$book->id]) }}"><i
                                        class="fa fa-file-pdf"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td style="text-align: center;" colspan="4"><b>Data masih kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $books->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>


@endsection