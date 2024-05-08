<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialTransaction;

class FinancialTransactionController extends Controller
{
    public function generatePdfReport(Request $request)
    {
        $transactionDebit = FinancialTransaction::query()
            ->select('name', DB::raw('MAX(transaction_at) as transaction_at'), DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(*) as count'))
            ->when($request->wallet_id, function ($query) use ($request) {
                $query->where('to_wallet_id', $request->wallet_id);
            }, function ($query) {
                $query->where('to_wallet_id', 'YAYASAN');
            })
            ->whereBetween('transaction_at', [
                $request->start_transaction_at ?? now()->startOfMonth(),
                $request->end_transaction_at ?? now()->endOfMonth()
            ])
            ->groupBy('name')
            ->get()
            ->map(function ($transaction) {
                return [
                    'name' => $transaction->name,
                    'transaction_at' => $transaction->transaction_at,
                    'debit' => $transaction->total_amount,
                    'credit' => null,
                    'count' => $transaction->count,
                ];
            });

        $transactionCredit = FinancialTransaction::query()
            ->select('name', DB::raw('MAX(transaction_at) as transaction_at'), DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(*) as count'))
            ->when($request->wallet_id, function ($query) use ($request) {
                $query->where('from_wallet_id', $request->wallet_id);
            }, function ($query) {
                $query->where('from_wallet_id', 'YAYASAN');
            })
            ->whereBetween('transaction_at', [
                $request->start_transaction_at ?? now()->startOfMonth(),
                $request->end_transaction_at ?? now()->endOfMonth()
            ])
            ->groupBy('name')
            ->get()
            ->map(function ($transaction) {
                return [
                    'name' => $transaction->name,
                    'transaction_at' => $transaction->transaction_at,
                    'debit' => null,
                    'credit' => $transaction->total_amount,
                    'count' => $transaction->count,
                ];
            });


        $totalCount = 0;
        $totalDebit = 0;
        $totalBalance = 0;
        $totalCredit = 0;

        $transactions = $transactionDebit->merge($transactionCredit)->values()->map(function ($transaction) use (&$totalCount, &$totalDebit, &$totalCredit, &$totalBalance) {
            $totalCount += $transaction['count'];

            if (isset($transaction['debit'])) {
                $totalBalance += $transaction['debit'];
                $totalDebit += $transaction['debit'];
                $transaction['debit'] = Number::currency($transaction['debit'], 'IDR');
            } else {
                $totalBalance -= $transaction['credit'];
                $totalCredit += $transaction['credit'];
                $transaction['credit'] = Number::currency($transaction['credit'], 'IDR');
            }

            $transaction['balance'] = Number::currency($totalBalance, 'IDR');
            $transaction['transaction_at'] = Carbon::parse($transaction['transaction_at'])->isoFormat('D MMMM Y');
            return $transaction;
        });

        $totalDebit = Number::currency($totalDebit, 'IDR');
        $totalCredit = Number::currency($totalCredit, 'IDR');
        $totalBalance = Number::currency($totalBalance, 'IDR');
        $startDate = Carbon::parse($request->start_transaction_at ?? now()->startOfMonth())->isoFormat('D MMMM Y');
        $endDate = Carbon::parse($request->end_transaction_at ?? now()->endOfMonth())->isoFormat('D MMMM Y');

        $yayasan = Organization::query()
            ->where('slug', 'yayasan-pondok-pesantren-ki-ageng-mbodo')
            ->first();

        $pdf = PDF::loadView('reports.pdf_financial_transactions_v2', [
            'transactions' => $transactions,
            'yayasan' => $yayasan,
            'totalCount' => $totalCount,
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
            'totalBalance' => $totalBalance,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        $pdf->setPaper('a4',);
        $pdf->render();
        return $pdf->stream(__('Financial Report') . ' ' . now()->isoFormat("D MMMM Y") . '.pdf');
    }
}
