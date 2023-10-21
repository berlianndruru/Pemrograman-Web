
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ini ada data buku</h1>
    @foreach ($books as $book)
        {{$book->code }}, {{$book->title }} <br>
    @endforeach
</body>
</html>