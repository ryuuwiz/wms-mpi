<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
    @endif

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

    <div class="mt-4 text-center">
        @if (filament()->hasPasswordReset())
            <a href="{{ filament()->getRequestPasswordResetUrl() }}" class="text-primary-600 hover:text-primary-500">
                {{ __('filament-panels::pages/auth/login.actions.request_password_reset.label') }}
            </a>
        @endif
    </div>
</x-filament-panels::page.simple>
