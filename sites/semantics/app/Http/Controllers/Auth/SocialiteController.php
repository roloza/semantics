<?php


namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

/**
 * Class SocialiteController
 * @package App\Http\Controllers\Auth
 */
class SocialiteController extends Controller
{
    //
    // GOOGLE : https://developers.google.com/identity/sign-in/web/sign-in
    // GOOGLE : https://console.cloud.google.com/apis/credentials
    // Les tableaux des providers autorisés
    /**
     * @var string[]
     */
    protected $providers = [ "google", "github", "facebook" ];
    protected $provider;

    public function __construct(Request $request)
    {
        $this->provider = $request->provider;

    }

    /**
     * redirection vers le provider
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        if (!in_array($this->provider, $this->providers)) {
            abort(404); // Si le provider n'est pas autorisé
        }
        return Socialite::driver($this->provider)->redirect();
    }

    /**
     * Callback du provider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback()
    {
        if (!in_array($this->provider, $this->providers)) {
            abort(404); // Si le provider n'est pas autorisé
        }

        $providerUser = Socialite::driver($this->provider)->user();

        $name = $providerUser->getName() ?? $providerUser->getNickname();
        $user = User::firstOrCreate(
            ['email' => $providerUser->getEmail()],
            ['provider_id' => $providerUser->getId(), 'name' => $name ?? $providerUser->getEmail(), 'provider' => $this->provider]
        );

        // Log the user in
        auth()->login($user, true);

        // Redirect To dashboard
        return redirect(route('accueil'));
    }

}