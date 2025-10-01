<?php
// app/Http/Livewire/Profile/TwoFactorAuthenticationForm.php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    public $showingQrCode = false;
    public $showingConfirmation = false;
    public $showingRecoveryCodes = false;
    public $code;

    public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable)
    {
        $this->resetErrorBag();

        $enable(Auth::user());

        $this->showingQrCode = true;
        $this->showingConfirmation = true;
        $this->showingRecoveryCodes = false;

        $this->dispatch('browser-notification', [
            'title' => 'Two factor authentication enabled.',
        ]);
    }

    public function confirmTwoFactorAuthentication(ConfirmTwoFactorAuthentication $confirm)
    {
        $this->resetErrorBag();

        if (!$this->code) {
            $this->addError('code', 'Please enter a verification code.');
            return;
        }

        $confirm(Auth::user(), $this->code);

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = true;
        $this->code = '';

        session()->flash('status', 'two-factor-authentication-confirmed');
    }

    public function showRecoveryCodes()
    {
        $this->showingRecoveryCodes = true;
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate)
    {
        $generate(Auth::user());

        $this->showingRecoveryCodes = true;

        $this->dispatch('browser-notification', [
            'title' => 'Recovery codes regenerated.',
        ]);
    }

    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable)
    {
        $disable(Auth::user());

        $this->showingQrCode = false;
        $this->showingConfirmation = false;
        $this->showingRecoveryCodes = false;

        $this->dispatch('browser-notification', [
            'title' => 'Two factor authentication disabled.',
        ]);
    }

    public function getEnabledProperty()
    {
        return !is_null(Auth::user()->two_factor_secret);
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('profile.two-factor-authentication-form');
    }
}