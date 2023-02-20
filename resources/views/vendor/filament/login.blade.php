<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="flex justify-center">
        <div class="text-sm text-gray-600 mt-4">
            <a class="underline" href="{{ route('register') }}">
                {{ __('Register') }}
            </a>
            <span class="px-2">|</span>
            <a class="underline" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>
    </div>
</form>
