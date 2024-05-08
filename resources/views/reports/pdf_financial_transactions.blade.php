<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>

    @vite('resources/css/app.css')

    <style type="text/css">
        body {
            font-family: "Arial", sans-serif;
        }
    </style>
</head>

<body class="w-max bg-white">
    <div class="p-4">
        <header class="mb-4 flex flex-col items-center justify-between">
            <div class="flex w-full flex-row items-center justify-start">
                <img src="{{ asset('favicon-150x150.png') }}" alt="Logo" class="mr-2 h-24 w-24">
                <div class="flex flex-1 flex-col items-center justify-center">
                    <h1 class="text-center text-2xl font-bold">{{ $yayasan->name }}</h1>
                    <p class="text-center">Alamat</p>
                    <p class="text-center"><i>email | website | Telp. nomor</i></p>
                </div>
            </div>
            <hr class="my-4 w-full border-2 border-gray-900">
        </header>
        {{-- End Header --}}

        <section class="flex flex-col items-center justify-center">
            <h1 class="text-2xl font-bold">LAPORAN KEUANGAN</h1>
            <p>Tanggalnya</p>
        </section>
        {{-- End Title --}}

        <table class="table-fix mt-6 w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Keterangan</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Debit</th>
                    <th class="border px-4 py-2">Kredit</th>
                    <th class="border px-4 py-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="border px-4 py-2">{{ $transaction['transaction_at'] }}</td>
                        <td class="border px-4 py-2">{{ $transaction['name'] }}</td>
                        <td class="border px-4 py-2">{{ $transaction['count'] }}</td>
                        <td class="border px-4 py-2">{{ isset($transaction['debit']) ? $transaction['debit'] : '' }}
                        </td>
                        <td class="border px-4 py-2">{{ isset($transaction['credit']) ? $transaction['credit'] : '' }}
                        </td>
                        <td class="border px-4 py-2">{{ $transaction['balance'] }}</td>
                    </tr>
                @endforeach
                {{-- @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center"><b>Tidak Ada Data</b></td>
                    </tr>
                @endforelse --}}
            </tbody>
            <tfoot>
                <tr class="bg-gray-100">
                    <th colspan="2" class="border px-4 py-2 text-start">TOTAL</th>
                    <th class="border px-4 py-2">{{ $totalCount ?? 'Rp 0' }}</th>
                    <th class="border px-4 py-2">{{ $totalDebit ?? 'Rp 0' }}</th>
                    <th class="border px-4 py-2">{{ $totalCredit ?? 'Rp 0' }}</th>
                    <th class="border px-4 py-2">{{ $totalBalance ?? 'Rp 0' }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
