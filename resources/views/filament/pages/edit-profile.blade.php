<x-filament-panels::page>
    <x-filament-panels::form wire:submit="updateProfile">
        {{ $this->editProfileForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdateProfileFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updateProfile" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
    <x-filament-panels::form wire:submit="updateSocialMediaLink">
        {{ $this->editSocialMediaLinkForm }}
        {{-- <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdateSocialMediaLinkFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updateSocialMediaLink" class="h-5 w-5" />
        </div> --}}
    </x-filament-panels::form>
    <x-filament-panels::form wire:submit="updatePassword">
        {{ $this->editPasswordForm }}
        <div class="flex items-center justify-end gap-x-1">
            <x-filament-panels::form.actions :actions="$this->getUpdatePasswordFormActions()" />
            <x-filament::loading-indicator wire:loading wire:target="updatePassword" class="h-5 w-5" />
        </div>
    </x-filament-panels::form>
    <x-filament-panels::form>
        <x-filament::section aside>
            <x-slot name="heading">
                {{ __('Browser Sessions') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Manage and log out your active sessions on other browsers and devices.') }}
            </x-slot>
            <div class="grid gap-y-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                </p>

                <!-- Browser Sessions -->
                @if (count($this->sessions) > 0)
                    @foreach ($this->sessions as $session)
                        <div class="flex items-center">
                            <div class="pe-3">
                                @if ($session->device === 'desktop')
                                    <x-heroicon-o-computer-desktop class="h-8 w-8 text-gray-500" />
                                @elseif ($session->device === 'tablet')
                                    <x-heroicon-o-device-tablet class="h-8 w-8 text-gray-500" />
                                @else
                                    <x-heroicon-o-device-phone-mobile class="h-8 w-8 text-gray-500" />
                                @endif
                            </div>

                            <div class="font-semibold">
                                <div class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ $session->os_name ? $session->os_name . ($session->os_version ? ' ' . $session->os_version : '') : __('Unknown') }}
                                    -
                                    {{ $session->client_name ?: __('Unknown') }}
                                </div>

                                <div class="text-xs text-gray-600 dark:text-gray-300">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span
                                            class="text-primary-700 dark:text-primary-500">{{ __('This device') }}</span>
                                    @else
                                        <span class="text-gray-400">{{ __('Last active') }}:
                                            {{ $session->last_active }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Log Out Other Devices Confirmation Modal -->
                {{-- <x-filament::modal id="confirmingLogout" icon="heroicon-o-information-circle" icon-color="primary"
                    alignment="{{ $modals['alignment'] }}"
                    footer-actions-alignment="{{ $modals['formActionsAlignment'] }}" width="{{ $modals['width'] }}">
                    <x-slot name="trigger">
                        <div class="text-left">
                            <x-filament::button wire:click="confirmLogout">
                                {{ __('filament-companies::default.buttons.logout_browser_sessions') }}
                            </x-filament::button>
                        </div>
                    </x-slot>

                    <x-slot name="heading">
                        {{ __('filament-companies::default.modal_titles.logout_browser_sessions') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('filament-companies::default.modal_descriptions.logout_browser_sessions') }}
                    </x-slot>

                    <x-filament-forms::field-wrapper id="password" statePath="password"
                        x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-filament::input.wrapper>
                            <x-filament::input type="password"
                                placeholder="{{ __('filament-companies::default.fields.password') }}" x-ref="password"
                                wire:model="password" wire:keydown.enter="logoutOtherBrowserSessions" />
                        </x-filament::input.wrapper>
                    </x-filament-forms::field-wrapper>

                    <x-slot name="footerActions">
                        @if ($modals['cancelButtonAction'])
                            <x-filament::button color="gray" wire:click="cancelLogoutOtherBrowserSessions">
                                {{ __('filament-companies::default.buttons.cancel') }}
                            </x-filament::button>
                        @endif

                        <x-filament::button wire:click="logoutOtherBrowserSessions">
                            {{ __('filament-companies::default.buttons.logout_browser_sessions') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::modal> --}}
            </div>
        </x-filament::section>
    </x-filament-panels::form>
</x-filament-panels::page>
