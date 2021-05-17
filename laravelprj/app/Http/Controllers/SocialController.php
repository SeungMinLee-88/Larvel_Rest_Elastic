<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
class SocialController extends Controller
{
    private $socialite;

    public function __construct(Socialite $socialite)
    {
        $this->middleware('guest', ['only' => 'execute']);
        $this->socialite = $socialite;
        parent::__construct();
    }

    public function execute(Request $request, $provider)
    {
        if (! $request->has('code')) {
            return $this->redirectToProvider($provider);
        }

        return $this->handleProviderCallback($provider);
    }

    public function redirectToProvider()
    {
        return $this->socialite->driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = \Socialite::driver('google')->user();
        if(User::where("email","=",$user->getEmail())->first()){
            flash(trans('account is aleady exist'));

            return redirect(route('sessions.create'));
        }
        $user = (User::whereEmail($user->getEmail())->first())
            ?: User::create([
                'name'  => $user->getName() ?: 'unknown',
                'email' => $user->getEmail(),
                'password' => bcrypt('123qwe'),
                'deptcode' => 'A1000',
            ]);
        $this->addMemberRole($user);
        flash(trans('account is created'));

        return redirect(route('sessions.create'));
    }

    protected function addMemberRole(User $user)
    {
        return $user->roles()->sync([2]);
    }
}
