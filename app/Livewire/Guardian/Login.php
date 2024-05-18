<?php

namespace App\Livewire\Guardian;

use Filament\Forms;
use App\Models\Student;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label(__('Nip Childern'))
                    ->placeholder(__('Nip Placeholder'))
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label(__('Guardian Phone'))
                    ->placeholder(__('Phone Placeholder'))
                    ->helperText(__('Phone Helper Text'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ])
            ->statePath('data');
    }

    public function viewProfileStudent(): void
    {
        $this->data = $this->form->getState();

        // Cari student berdasarkan nip dan nomor telepon wali
        $student = Student::where('nip', $this->data['nip'])
            ->whereHas('guardians', function ($query) {
                $query->where('phone', $this->data['phone']);
            })->first();

        // Cek apakah student ditemukan
        if (!$student) {
            // Jika tidak ditemukan, tampilkan pesan error pada field 'nip'
            $this->addError('data.nip', __('Students not found, make sure the NIP data and parents telephone numbers are correct!'));
            $this->form->fill([
                'nip' => $this->data['nip'],
            ]);
            return;
        }

        // Membuat token JWT dengan data siswa
        $payload = [
            'student_nip' => $student->nip,
            'exp' => time() + (60 * 30), // 30 menit setelah dibuat
        ];

        // Membuat JwtToken
        $JwtToken = \Firebase\JWT\JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        redirect()->route('guardian.view-profile-student', [
            'token' => $JwtToken,
        ]);
    }

    public function render(): View
    {
        return view('livewire.guardian.login');
    }
}
