<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webhook Data</title>
</head>
<body>
    <h3> Data listening from webhook</h3>
    @foreach ($data as $row)
        <h3>Product {{ $loop->iteration }}</h3>
        <p>Product Name : {{ $row->product_name }}</p>
        <p>Product Price : {{ $row->price }}</p>
        <p>Product Size : {{ $row->size }}</p>
        <p>Product Quantity : {{ $row->quantity }}</p>
        <br>
    @endforeach
</body>
</html>