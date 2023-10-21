@extends('layout.main')

@section('title', 'Tambah Buku')

@section('content') <!--menggunakan route harus diikuti dengan nama apabila menggunakan urls harus mengguanakan urls -->

    <form method="POST" action="{{ route('books.store') }}">
        <div class="row">
            <div class="card col-5 mr-2">
                <div class="card-body">
                        <!--untuk setiap method POST harus menggunakan @csrf -->
                        @csrf
                        <div class="form-group">
                            <label for="">Kode</label>
                            <input class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" type="text"
                                name=code />
                            @error('code')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                type="text" name="title" />
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label for="">Publisher</label>
                            <select class="form-control @error('id_publisher') is-invalid @enderror" name="id_publisher">
                                <option value="" disabled selected>Pilih Publisher</option>
                                @foreach ($publishers as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('id_publisher')
                                <span class="invalid-feedback"> {{ $message }}</span>
                            @enderror
                        </div>
    
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> Simpan
                        </button>    
                    </div>
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <h2>Pilih Author</h2>
                        <table id='table-author' class="table">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Nama Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($authors as $author)
                                    <tr>
                                        <td><input name='author[]' value="{{ $author->id }}" type="checkbox" /></td>
                                        <td>{{ $author->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script>
        //ready function
        //agar semua di load ketika halaman sudah selesai load
        $function() {
            $('#table-author').DataTable();
        }
    </script>