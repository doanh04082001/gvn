<?php

namespace App\Repositories\Traits;

trait DeviceToken
{
    /**
     * Store user's device token
     *
     * @param \App\Models\User|\App\Models\Customer $user
     * @param mixed $token
     *
     * @return void
     */
    public function storeDeviceToken($user, $token)
    {
        if (!$token) {
            return;
        }

        if (isAdmin() || isWeb()) {
            session(['user.device_token' => $token]);
        }

        if (!$this->getDeviceToken($user, $token)) {
            $user->deviceTokens()->create(['token' => $token]);
        }
    }

    /**
     * Delete user's device token
     *
     * @return void
     */
    public function deleteDeviceToken()
    {
        $token = isApi() || isSaleApi()
            ? auth()->payload()->get('device_token')
            : session('user.device_token');

        if ($storedToken = $this->getDeviceToken(auth()->user(), $token)) {
            $storedToken->forceDelete();
        }
    }

    /**
     * Get user's device token
     *
     * @param \App\Models\User|\App\Models\Customer $user
     * @param mixed $token
     *
     * @return \App\Models\DeviceToken|null
     */
    private function getDeviceToken($user, $token)
    {
        if ($user) {
            return $user->deviceTokens()->where('token', $token)->first();
        }
    }
}
