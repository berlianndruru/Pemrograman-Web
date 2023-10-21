
@extends('layout.main')
   
@section('title','Data Publisher')
    
@section('content')
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
        {{ $message }}
    </div>
@endif
<a class ="btn btn-primary mb-2" href="{{route('publishers.createpublishers')}}">Tambah Publisher</a>
<div class="card">
    <div class="card-header">
        <div class="card-tools">
        <form action="">
            <input type="text" placeholder= "Cari Publisher"name="search" class="form-control"  />
        </form>
     </div>
</div>
    <div class="card-body">
        <table class="table" width='100%'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Publisher</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @forelse ($publishers as $publisher)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$publisher->name}}</td>                
                        <td>
                            <a class ="btn btn-dark btn-sm"href="{{route('publishers.editpublishers',[$publisher->id])}}">
                                <i class="fa fa-pencil-alt"></i>
                                </a> |
                            <a class = "btn btn-danger btn-sm" href="{{route('publishers.del.confirmpublishers',[$publisher->id])}}">
                             <i class="fa fa-trash-alt"></i>
                            </a>
                            </a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td style="text-align: center;" colspan="4"><b>Data Kosong</b></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{$publishers->withQueryString()->links('pagination::bootstrap-5')}}
    </div>
</div>
@endsection
