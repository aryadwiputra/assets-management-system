<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Mutasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h1>Data Mutasi</h1>
    <p>{{ date('Y-m-d H:i') }}</p>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis suscipit explicabo corrupti quia neque beatae
        expedita inventore sint officiis! Sint.</p>

    <table>
        <tbody>
            <tr>
                <th>Nama Dokumen</th>
                <td>{{ $mutation->name }}</td>
            </tr>
            <tr>
                <th>Lokasi Tujuan</th>
                <td>{{ $mutation->location->name }}</td>
            </tr>
            <tr>
                <th>Proyek</th>
                <td>{{ $mutation->project->name }}</td>
            </tr>
            <tr>
                <th>Penanggung Jawab</th>
                <td>{{ $mutation->pic->name }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $mutation->description }}</td>
            </tr>
            <tr>
                <th>Komentar</th>
                <td>{{ $mutation->comment }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ strtoupper($mutation->status) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Table for assets --}}
    <h2>Assets</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Lokasi Awal</th>
                <th>Pengguna</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mutation->assets as $asset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->location->name }}</td>
                    <td>{{ $asset->employee->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
