<!DOCTYPE html>
<html lang="en">
    <style>
        @media screen, print {
            body {
                font-family: 'Calibri', 'Helvetica', 'Arial', sans-serif;
                font-size: 12pt;
            }
    
    
            table.data {
                border: 1px solid;
                width: 100%;
                border-collapse: collapse;
            }
    
            table.data > tbody > tr > td {
                border: 1px solid;
                padding: 1px 2px;
            }
    
            table.data > thead > tr > th {
                border: 1px solid;
                background-color: #eaeaea;
                padding: 1px 2px;
            }
    
    
            .left {
                text-align: left;
            }
    
            .right {
                text-align: right;
            }
    
            .center {
                text-align: center;
            }
    
            .bg-gray {
                background-color: #eaeaea;
                padding: 10px !important;
                font-weight: bold;
            }
        }
    </style>
<body>
    <h1>Data Master Buku</h1>
    <table class="data" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Penerbit Buku</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter =1;
            @endphp

            @foreach($books as $book)
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $book->code }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->publisher->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>