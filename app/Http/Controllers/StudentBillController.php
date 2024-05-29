<?php

namespace App\Http\Controllers;

use App\Enums\StudentCurrentSchool;
use App\Models\Student;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\OrganizationCategory;

class StudentBillController extends Controller
{
    public function generatePdfReport(Request $request)
    {
        $this->authorize('export_student::bill');

        $students = Student::withOut('user')
            ->with(['products' => function ($query) {
                $query->whereNull('validated_at');
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
            ->sortByDesc(function ($student) {
                return $student->current_school;
            })
            ->sortBy(function ($student) {
                return $student->total_bills;
            });

        $yayasan = Organization::query()
            ->where('category', OrganizationCategory::YAYASAN)
            ->first();

        $date = now()->isoFormat('DD MMMM Y, HH:mm:ss');

        // GENERATE PDF
        $pdf = PDF::loadView('reports.pdf_student_bills', [
            'students' => $students,
            'yayasan' => $yayasan,
            'date' => $date,
            'student_total_bills' => Number::currency($student_total_bills, 'IDR'),
        ]);

        $pdf->setPaper('a4');
        $pdf->render();

        return $pdf->stream(__('Student Bill Report') . ' ' . $date . '.pdf');
    }
}
