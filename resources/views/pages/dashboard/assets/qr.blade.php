<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Label</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }

        .label {
            display: flex;
            align-items: center;
            border: 1px solid #000;
            padding: 10px;
            background-color: #fff;
            width: 400px;
        }

        .label .qr-code {
            flex: 1;
            text-align: center;
        }

        .label .qr-code img {
            width: 100px;
            height: 100px;
        }

        .label .details {
            flex: 2;
            padding-left: 15px;
            text-align: left;
        }

        .label .details h1 {
            font-size: 16px;
            margin: 0 0 10px;
        }

        .label .details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .label .details .asset-code {
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>
    @foreach ($assets as $asset)
    <div class="label">
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=PropertyOfCitanusaGroup" alt="QR Code">
        </div>
        <div class="details">
            <h1>Property Of</h1>
            <p>Citanusa Group</p>
            <p class="asset-code">ASSET CODE<br>IT0824XXX</p>
        </div>
    </div>
    @endforeach
</body>
</html>
