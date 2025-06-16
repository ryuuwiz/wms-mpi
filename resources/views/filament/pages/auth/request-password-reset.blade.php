<x-filament-panels::page.simple>
    <x-slot name="subheading">
        {{ __('filament-panels::pages/auth/request-password-reset.actions.login.before') }}

        {{ $this->loginAction }}
    </x-slot>

    <x-filament-panels::form wire:submit="request">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page.simple>
