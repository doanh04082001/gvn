<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\UserRepository;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers, AdminRedirectsUsers;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest:admin')->except('logout');
        $this->userRepository = $userRepository;
    }

    public function provider()
    {
        return Socialite::driver('gitlab')->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver('gitlab')->user();
            if ($user != null) {
                $data = User::where('email', '=', $user->email)->first();
                if (is_null($data)) {
                    User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => date('Y-m-d H:i:s'),
                        'password' => null,
                        'social_id' => $user->id,
                        'social_type' => 'gitlab',
                    ]);
                }
                $data = User::where('email', '=', $user->email)->first();
                if ($data) {
                    $success = Auth::login($data, false);
                    return redirect()->route('apply_leaves.show');
                }
            }
        } catch (\Exception $e) {
            return redirect('/admin/login')->with('status', 'something_went_wrong');
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->{$this->username()},
            'password' => $request->password,
            'status' => User::STATUS_ACTIVE,
        ];
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $attempt = $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );

        if ($attempt && $deviceToken = $request->device_token) {
            $this->userRepository->storeDeviceToken(auth()->user(), $deviceToken);
        }

        return $attempt;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->userRepository->deleteDeviceToken();

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loggedOut()
    {
        return redirect()->route('admin.login');
    }
}
