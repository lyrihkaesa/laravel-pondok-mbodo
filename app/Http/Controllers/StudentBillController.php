<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\OrganizationCategory;
use App\Enums\StudentCurrentSchool;

class StudentBillController extends Controller
{
    public function generatePdfReport(Request $request)
    {
        $this->authorize('export_student::bill');

        $billDateTimeStart = Carbon::parse($request->bill_date_time_start);
        $billDateTimeEnd = Carbon::parse($request->bill_date_time_end);

        $students = Student::withOut('user')
            ->with(['products' => function ($query) use ($billDateTimeStart, $billDateTimeEnd) {
                $query->whereNull('validated_at')
                    ->whereBetween('bill_date_time', [$billDateTimeStart, $billDateTimeEnd]);
            }])
            ->select('id', 'name', 'nip', 'status', 'current_school')
            ->where('status', 'Aktif')
            ->whereIn('category', $request->category)
            ->whereIn('current_school',  $request->current_school)
            ->get();

        $student_total_bills = 0;
        foreach ($students as $student) {
            $total_bills = 0;

            foreach ($student->products as $product) {
                if ($product->pivot->validated_at === null) {
                    $total_bills += $product->pivot->product_price;
                }
            }

            $student_total_bills += $total_bills;
            $student->total_bills = $total_bills;
            $student->total_bills_formated = $total_bills === 0 ? "Lunas" : Number::currency($total_bills, 'IDR');
        }

        $students = $students
            ->sortBy(function ($student) {
                return $student->total_bills;
            })
            ->sortByDesc(function ($student) {
                return $student->current_school;
            });

        $yayasan = Organization::query()
            ->where('category', OrganizationCategory::YAYASAN)
            ->first();



        // GENERATE PDF
        $pdf = PDF::loadView('reports.pdf_student_bills', [
            'students' => $students,
            'yayasan' => $yayasan,
            'startDate' => $billDateTimeStart->isoFormat('DD MMMM Y, HH:mm:ss'),
            'endDate' => $billDateTimeEnd->isoFormat('DD MMMM Y, HH:mm:ss'),
            'student_total_bills' => Number::currency($student_total_bills, 'IDR'),
        ]);

        $pdf->setPaper('a4');
        $pdf->render();

        return $pdf->stream(__('Student Bill Report') . ' ' . $billDateTimeStart->isoFormat('DD-MM-YYYY HH:mm:ss') . ' - ' . $billDateTimeEnd->isoFormat('DD-MM-YYYY HH:mm:ss') . '.pdf');
    }
}
