<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('Phone'))
            ->placeholder(__('Phone Placeholder'))
            ->helperText(__('Phone Helper Text'))
            ->tel()
            ->mask(\Filament\Support\RawJs::make(<<<'JS'
                $input.replace(/^0/, '62');
            JS))
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $credentials = [
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];

        if (
            ! Filament::auth()->attempt($credentials, $data['remember'] ?? false)
        ) {
            throw ValidationException::withMessages([
                'data.phone' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
