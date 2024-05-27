<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        table {
            font-size: 14px;
        }

        .table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .table thead th {
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 1px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

    </style>
</head>

<body>
    <h5>LAPORAN KEUANGAN</h5>
    <hr>
    <span>Total Pendapatan : Rp. {{ number_format($data['pendapatan']) }}</span> <br>
    <span>Total Pesanan : {{ number_format($data['pesanan']) }} </span>
    <table class="table table-bordered table-striped" style="text-align: center">
        <thead>
            <tr>
                <th>#ID</th>
                <th>No Resi</th>
                <th>Nama Barang</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['data'] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->data_ekspedisi->no_resi }}</td>
                    <td>{{ $item->data_ekspedisi->nama_barang }}</td>
                    <td>Rp. {{ number_format($item->data_ekspedisi->biaya) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
