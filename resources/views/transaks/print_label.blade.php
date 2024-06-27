<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Labels</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qrcode {
            width: 50px;
            height: 50px;
            margin: 10px;

        }

        .noinventaris {
            font-size: 1rem;
            font-weight: bold;
        }

        .label-container {}

        .card {
            /* agar img qrcode dan noinventaris yang ada di card itu center */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 10px;
            border: 1px solid;
            padding: 5px;
            width: 10rem;
        }

        .no-gutters {  
            margin-right: 0;
            margin-left: 0;
        }

        .no-gutters>[class*='col-'] {
            padding-right: 0;
            padding-left: 0;
        }

        .img-container {
            padding: 0;
            /* Remove padding between images */
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
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
                            <div class="row no-gutters">
                                <div class="col-6 img-container">
                                    <img src="{{ $label['qrcode'] }}" class="qrcode img-thumbnail"
                                        alt="Label Inventaris">
                                </div>
                                <div class="col-6 img-container">
                                    <img src="{{ $label['foto_jenjang'] }}" class="qrcode img-thumbnail"
                                        alt="Logo Instansi">
                                </div>
                            </div>
                            <p class="noinventaris text-center">{{ $label['no_inventaris'] }}</p>
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
