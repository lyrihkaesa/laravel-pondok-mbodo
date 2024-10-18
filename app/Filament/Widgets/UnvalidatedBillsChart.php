<?php

namespace App\Filament\Widgets;

use App\Models\StudentBill;
use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UnvalidatedBillsChart extends ChartWidget
{
    public static function canView(): bool
    {
        /**
         * @var \App\Models\User::class $user
         */
        $user = auth()->user();
        return $user->can('widget_UnvalidatedBillsChart');
    }
    protected static ?string $heading = 'Total Santri Belum Validasi Tagihan per Sekolah';

    protected function getData(): array
    {
        $startDate = now()->subMonths(6); // Ambil data dari 6 bulan terakhir
        $endDate = now();

        $studentData = DB::table('student_bill')
            ->join('students', 'student_bill.student_id', '=', 'students.id')
            ->select(
                DB::raw("to_char(bill_date_time, 'YYYY-MM') as period"),
                'students.current_school',
                DB::raw('count(DISTINCT student_bill.student_id) as student_count') // Hitung jumlah distinct student_id
            )
            ->whereNull('validated_at') // Belum divalidasi
            ->whereBetween('bill_date_time', [$startDate, $endDate])
            ->groupBy('students.current_school', DB::raw("to_char(bill_date_time, 'YYYY-MM')"))
            ->get();

        $data = [];
        $periods = []; // Untuk menyimpan setiap periode
        $currentSchools = ['PAUD/TK', 'MI', 'SMP', 'MA', 'Takhasus']; // Daftar current_school

        foreach ($studentData as $row) {
            $periods[$row->period] = true;
            $data[$row->current_school][$row->period] = $row->student_count;
        }

        // Mengisi nilai kosong dengan 0
        foreach ($currentSchools as $school) {
            foreach ($periods as $period => $value) {
                $data[$school][$period] = $data[$school][$period] ?? 0;
            }
        }

        if (empty($data)) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }
        return [
            'datasets' => [
                [
                    'label' => 'PAUD/TK',
                    'data' => array_values($data['PAUD/TK']),
                    'borderColor' => 'pink',
                ],
                [
                    'label' => 'MI',
                    'data' => array_values($data['MI']),
                    'borderColor' => 'red',
                ],
                [
                    'label' => 'SMP',
                    'data' => array_values($data['SMP']),
                    'borderColor' => 'yellow',
                ],
                [
                    'label' => 'MA',
                    'data' => array_values($data['MA']),
                    'borderColor' => 'green',
                ],
                [
                    'label' => 'Takhasus',
                    'data' => array_values($data['Takhasus']),
                    'borderColor' => 'blue',
                ],
            ],
            'labels' => array_keys($periods), // Bulan/Tahun atau Minggu/Tahun
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
