{{-- print_label.blade.php --}}

<!DOCTYPE html>
<html>

<head>
    <style>
        .qrcode {
            width: 100px;
            height: 100px;
            margin-left: 50px;
        }

        .noinventaris {
            margin-left: 50px;
        }

        .label-container {
            margin-left: 50px;
            border: 1px solid;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            @foreach ($labels as $label)
                <div class="col-md-4">
                    <div class="label-container">
                        <img src="{{ $label['qrcode'] }}" class="qrcode img-thumbnail" alt="Label Inventaris">
                        <p class="noinventaris">{{ $label['no_inventaris'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="page-break"></div>

        {{-- print halaman windows.print --}}
        <script>
            window.print();
        </script>
    </div>
</body>

</html>
