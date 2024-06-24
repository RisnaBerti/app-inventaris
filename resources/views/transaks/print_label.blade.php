<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Labels</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qrcode {
            width: 100px;
            height: 100px;
            margin: 10px;
            
        }
        .noinventaris {
            font-size: 1rem;
            font-weight: bold;
        }
        .label-container {
        }
        .card {
            /* agar img qrcode dan noinventaris yang ada di card itu center */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: 10px;
            border: 1px solid;
            padding: 5px;
            width: 10rem;
        }
        @media print {
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Cetak Label Inventaris</h1>
        <div class="row">
            @foreach ($labels as $label)
                <div class="col-md-2">
                    <div class="label-container">
                        <div class="card">
                            <img src="{{ $label['qrcode'] }}" class="qrcode img-thumbnail" alt="Label Inventaris">
                            <p class="noinventaris">{{ $label['no_inventaris'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="page-break"></div>

        <script>
            window.print();
        </script>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
