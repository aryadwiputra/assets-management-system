<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .qr-code {
            border: 1px solid #000;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
        }

        .qr-code h2 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        .qr-code img {
            max-width: 100%;
            height: auto;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin: 50px 0;
        }
    </style>
</head>

<body>
    <h1>QR Codes</h1>
    <div class="container">
        @foreach ($assets as $asset)
            <div class="qr-code">
                <h2>{{ $asset->name }}</h2>
                <img src="{{ public_path('storage/asset/qr/' . $asset->slug . '.png') }}" alt="QR Code">
            </div>
        @endforeach
    </div>
</body>

</html>
