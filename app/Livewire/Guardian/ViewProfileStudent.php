<?php

namespace App\Livewire\Guardian;


use App\Models\Student;
use Filament\Infolists;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class ViewProfileStudent extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public $token;

    public function mount($token): void
    {
        $this->token = $token;
    }

    #[Computed()]
    private function student(): Student
    {
        try {
            $payload = \Firebase\JWT\JWT::decode($this->token, new \Firebase\JWT\Key(env('JWT_SECRET'), 'HS256'));
            return  Student::with(['user:id,profile_picture_1x1'])->where('nip', $payload->student_nip)->firstOrFail();;
        } catch (\Exception $e) {
            redirect()->route('guardian.login');
            return new Student();
        }
    }

    public function studentInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->student)
            ->schema([
                Infolists\Components\Section::make(__('Personal Information'))
                    ->schema([
                        Infolists\Components\Grid::make()
                            ->schema([
                                Infolists\Components\ImageEntry::make('profile_picture_1x1')
                                    ->label(__('Profile Picture 1x1'))
                                    ->circular(),
                                Infolists\Components\ImageEntry::make('user.profile_picture_1x1')
                                    ->label(__('Avatar User'))
                                    ->circular(),
                            ])
                            ->columns(2)
                            ->columnSpan(1),
                        Infolists\Components\Grid::make()
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label(__('Full Name')),
                                Infolists\Components\TextEntry::make('status')
                                    ->label(__('Status'))
                                    ->badge(),
                                Infolists\Components\TextEntry::make('nip')
                                    ->label(__('Nip'))
                                    ->badge()
                                    ->color('pink')
                                    ->copyable(),

                            ])
                            ->columns(2)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public function render(): View
    {
        return view('livewire.guardian.view-profile-student');
    }
}
