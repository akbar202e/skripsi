<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterCustom extends Register
{
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
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

        return $user;
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
                ->unique($this->getUserModel()),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->rule(\Illuminate\Validation\Rules\Password::default()),
        ]);
    }
}