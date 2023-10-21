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
    <h1>Detail Buku</h1>
    <table width="50%">
        <tr>
            <td>Kode</td>
            <td>{{ $book->code }}</td>
        </tr>
        <tr>
            <td>Judul</td>
            <td>{{ $book->title }}</td>
        </tr>
        <tr>
            <td>Publisher</td>
            <td>{{ $book->publisher->name }}</td>
        </tr>
    </table>
<p></p>
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Author</th>
            </tr>
        </thead>
        <tbody>
            @php
            $i =1;
            @endphp

            @foreach($book->authors as $author)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $author->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>