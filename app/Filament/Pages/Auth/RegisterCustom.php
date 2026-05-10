<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegisterCustom extends Register
{
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);
        
        // Set is_verified to false - user akan verify email di halaman terpisah
        $data['is_verified'] = false;
        
        return $data;
    }

    protected function handleRegistration(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = parent::handleRegistration($data);

        // Assign the 'pemohon' role to the user
        $pemohonRole = Role::where('name', 'pemohon')->first();
        if ($pemohonRole) {
            $user->assignRole($pemohonRole);
        }

        // Store email in session for verify-email page
        Session::put('unverified_email', $user->email);
        
        // PENTING: Logout user jika ada yang terlogin, karena registrasi tidak boleh auto-login
        if (Auth::check()) {
            Auth::logout();
        }

        // Show success notification
        Notification::make()
            ->title('Akun berhasil dibuat!')
            ->body('Silakan verifikasi email Anda untuk melanjutkan.')
            ->success()
            ->send();

        return $user;
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.auth.verify-email');
    }


    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique($this->getUserModel())
                ->maxLength(255),

            TextInput::make('instansi')
                ->label('Instansi')
                ->required()
                ->maxLength(255),

            TextInput::make('no_hp')
                ->label('Nomor HP')
                ->tel()
                ->required()
                ->maxLength(20),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->required()
                ->rule(\Illuminate\Validation\Rules\Password::default()),

            TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->revealable()
                ->required()
                ->same('password'),
        ]);
    }
}