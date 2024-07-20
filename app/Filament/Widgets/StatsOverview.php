<?php

namespace App\Filament\Widgets;

use App\Models\Wallet;
use App\Models\Student;
use App\Models\Employee;
use App\Enums\StudentStatus;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->employee !== null;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Santri', Student::where('status', StudentStatus::ACTIVE)->count())
                ->description(Student::where('status', StudentStatus::ENROLLED)->count() . ' Mendaftar')
                ->descriptionIcon(StudentStatus::ENROLLED->getIcon()),
            Stat::make('Jumlah Pengurus', Employee::count()),
            Stat::make('Saldo Yayasan', Number::currency(Wallet::yayasan()->first()->balance, 'IDR')),
        ];
    }
}
