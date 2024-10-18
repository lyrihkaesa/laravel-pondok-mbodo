<?php

namespace App\Filament\Widgets;

use App\Models\Wallet;
use App\Models\Student;
use App\Models\Employee;
use App\Enums\StudentStatus;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        /**
         * @var \App\Models\User::class $user
         */
        $user = auth()->user();
        return $user->can('widget_StatsOverview');
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Santri Aktif', Student::where('status', StudentStatus::ACTIVE)->count())
                ->description(Student::where('status', StudentStatus::ENROLLED)->count() . ' Mendaftar')
                ->descriptionIcon(StudentStatus::ENROLLED->getIcon()),
            Stat::make('Jumlah Pengurus', Employee::query()->whereDoesntHave('user.roles', function (Builder $query) {
                $query->where('name', 'super_admin');
            })->count()),
        ];
    }
}
