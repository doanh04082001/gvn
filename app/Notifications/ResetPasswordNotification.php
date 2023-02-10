<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Create a new notification instance.
     *
     * @param void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param string $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Thông báo đặt lại mật khẩu'))
            ->line(Lang::get('Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.'))
            ->action(Lang::get('Đặt lại mật khẩu'), $url)
            ->line(Lang::get('Liên kết đặt lại mật khẩu này sẽ hết hạn sau :count phút.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get('Nếu bạn không yêu cầu đặt lại mật khẩu, bạn không cần thực hiện thêm hành động nào.'));
    }
}
