<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>

    <style type="text/css">
        body {
            font-family: "Arial", sans-serif;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            border-color: #ccc;
            width: 100%;
        }

        .tg td {
            font-family: Arial;
            font-size: 12px;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: #ccc;
            color: #333;
            background-color: #fff;
        }

        .tg th {
            font-size: 12px;
            font-weight: bold;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: #ccc;
            color: #333;
            background-color: #f0f0f0;
        }

        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        h1 {
            font-size: 1.5rem;
            line-height: 2rem;
            margin: 0;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
            padding-bottom: 2px;
        }

        h2 {
            font-size: 1.25rem;
            line-height: 1.75rem;
            margin: 0;
        }

        h3 {
            font-size: 1rem;
            line-height: 1.5rem;
            margin: 0;
        }

        p {
            margin: 0;
            font-size: 16px;
        }

        .py-2 {
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .pb-2 {
            padding-bottom: 2px;
        }

        .px-2 {
            padding-left: 2px;
            padding-right: 2px;
        }

        .nowarp {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <table style="width: 100%">
        <tr>
            <td><img class="px-2" src="{{ asset('favicon-150x150.png') }}" width="90" height="90"></td>
            <td class="text-center">
                <h1>{{ $yayasan->name }}</h1>
                <p class="pb-2">{{ $yayasan->address }}</p>
                <p class="pb-2">
                    <i>{{ $yayasan->email . ' | ' . config('app.url', 'https://pondokmbodo.com') . ' | ' . $yayasan->phone }}</i>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
    </table>
    <section class="text-center">
        <h2>LAPORAN KEUANGAN {{ $wallet->wallet_code }}</h2>
        <p>{{ $startDate }} - {{ $endDate }}</p>
    </section>
    <br>
    <table class="tg">
        <thead>
            <tr>
                <th class="nowarp">Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @if (empty($transactions))
                <tr>
                    <td colspan="6" class="text-center">Tidak Ada Data</td>
                </tr>
            @endif
            @foreach ($transactions as $transaction)
                <tr>
                    <td class="nowarp">{{ $transaction['transaction_at'] }}</td>
                    <td>{{ $transaction['name'] }}</td>
                    <td class="text-center">{{ $transaction['count'] }}</td>
                    <td>{{ isset($transaction['debit']) ? $transaction['debit'] : '' }}</td>
                    <td>{{ isset($transaction['credit']) ? $transaction['credit'] : '' }}</td>
                    <td>{{ $transaction['balance'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-start">TOTAL</th>
                <th class="text-center">{{ $totalCount ?? '0' }}</th>
                <th class="text-start">{{ $totalDebit ?? 'Rp 0' }}</th>
                <th class="text-start">{{ $totalCredit ?? 'Rp 0' }}</th>
                <th class="text-start">{{ $totalBalance ?? 'Rp 0' }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
