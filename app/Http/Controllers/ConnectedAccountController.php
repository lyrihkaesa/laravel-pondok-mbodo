<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConnectedAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class ConnectedAccountController extends Controller
{
    public function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Retrieve authentication information from the provider
        $userSocialite = Socialite::driver($provider)->user();

        $connectedAccount = ConnectedAccount::where('provider', $provider)->where('provider_id', $userSocialite->getId())->first();

        if ($connectedAccount) {
            Auth::login($connectedAccount->user);
            Session::regenerate();
            return redirect()->route('filament.admin.pages.my');
        }

        $userModel = Auth::user();

        if (!$userModel) {
            return redirect()->route('filament.admin.auth.login');
        }

        $connectedAccount = new ConnectedAccount();
        $connectedAccount->user_id = auth()->user()->id;
        $connectedAccount->provider = $provider;
        $connectedAccount->provider_id = $userSocialite->getId();
        $connectedAccount->nickname = $userSocialite->getNickname();
        $connectedAccount->name = $userSocialite->getName();
        $connectedAccount->email = $userSocialite->getEmail();
        $connectedAccount->avatar_path = $userSocialite->getAvatar();
        $connectedAccount->token = $userSocialite->token;
        $connectedAccount->secret = $userSocialite->tokenSecret;
        $connectedAccount->refresh_token = $userSocialite->refreshToken;
        $connectedAccount->expires_at = $userSocialite->expiresIn;
        $connectedAccount->save();

        // Redirect to the appropriate page after successful authentication
        return redirect()->route('filament.admin.pages.my');
    }
}
