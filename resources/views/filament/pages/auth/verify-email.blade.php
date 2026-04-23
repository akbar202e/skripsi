<x-filament-panels::page>
    <div class="mx-auto max-w-sm space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold">{{ __('Verifikasi Email') }}</h1>
            <p class="mt-2 text-gray-600">
                Silakan masukkan kode OTP yang telah dikirim ke email Anda
            </p>
        </div>

        <form wire:submit="verify" class="space-y-6">
            {{ $this->form }}

            <div class="flex flex-col gap-4">
                <x-filament::button
                    wire:click="sendOtp"
                    type="button"
                    color="info"
                    class="w-full"
                >
                    {{ __('Kirim OTP') }}
                </x-filament::button>

                <x-filament::button
                    type="submit"
                    class="w-full"
                >
                    {{ __('Verifikasi Email') }}
                </x-filament::button>
            </div>

            <div class="text-center text-sm">
                <p>
                    Kembali ke
                    <a href="{{ route('filament.admin.auth.login') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-filament-panels::page>
