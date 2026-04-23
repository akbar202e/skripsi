<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Services\OtpService;
use App\Models\User;

class VerifyEmail extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static string $view = 'filament.pages.auth.verify-email';
    protected static bool $shouldRegisterNavigation = false;

    public static function getSlug(): string
    {
        return 'verify-email';
    }

    public ?string $email = null;
    public bool $otpSent = false;
    private const RESEND_COOLDOWN = 10; // seconds

    public function mount(): void
    {
        // Get email dari auth user atau session (dari register)
        if (Auth::check()) {
            $this->email = Auth::user()->email;
        } elseif (Session::has('unverified_email')) {
            $this->email = Session::get('unverified_email');
        } else {
            redirect()->route('filament.admin.auth.login')->send();
        }
    }

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->disabled()
                ->default($this->email)
                ->required(),

            TextInput::make('otp')
                ->label('Kode OTP')
                ->required()
                ->maxLength(6)
                ->minLength(6)
                ->helperText('Masukkan kode 6 digit yang dikirim ke email Anda')
                ->rule(function ($state) {
                    return function ($attribute, $value, $fail) {
                        if (!$this->otpSent) {
                            $fail('Kirim kode OTP terlebih dahulu');
                        }

                        if ($value && !OtpService::verifyOtp($this->email, $value)) {
                            $fail('Kode OTP tidak valid atau telah kedaluwarsa');
                        }
                    };
                }),
        ])->statePath('data');
    }

    public function sendOtp(): void
    {
        // Check rate limiting
        $cooldownKey = "otp_cooldown_{$this->email}";
        $timestamp = Cache::get($cooldownKey);
        
        if ($timestamp && now()->diffInSeconds($timestamp) < self::RESEND_COOLDOWN) {
            $remainingTime = self::RESEND_COOLDOWN - now()->diffInSeconds($timestamp);
            Notification::make()
                ->title('Tunggu sebentar')
                ->body("Silakan tunggu {$remainingTime} detik sebelum mengirim ulang kode OTP")
                ->warning()
                ->send();
            return;
        }

        try {
            $otp = OtpService::generateOtp($this->email);
            OtpService::sendOtp($this->email, $otp);

            $this->otpSent = true;

            // Set cooldown cache
            Cache::put($cooldownKey, now(), now()->addSeconds(self::RESEND_COOLDOWN));

            Notification::make()
                ->title('Kode OTP telah dikirim')
                ->body("Kode OTP telah dikirim ke email {$this->email}")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal mengirim OTP')
                ->body('Silakan coba lagi')
                ->danger()
                ->send();
        }
    }

    public function verify(): void
    {
        $data = $this->form->getState();

        // Validate OTP
        if (!OtpService::verifyOtp($this->email, $data['otp'])) {
            Notification::make()
                ->title('Kode OTP tidak valid')
                ->danger()
                ->send();
            return;
        }

        // Update user is_verified
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $user->update(['is_verified' => true]);
        }

        // Clear session
        Session::forget('unverified_email');

        Notification::make()
            ->title('Email berhasil diverifikasi')
            ->success()
            ->send();

        // Redirect to login or dashboard
        if (Auth::check()) {
            redirect()->route('filament.admin.dashboard');
        } else {
            redirect()->route('filament.admin.auth.login');
        }
    }
}
