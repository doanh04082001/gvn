<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use NotificationChannels\Fcm\Resources\WebpushConfig;
use NotificationChannels\Fcm\Resources\WebpushFcmOptions;

abstract class BaseNotification extends Notification
{
    /**
     * Set notification data for Database
     *
     * @param \App\Models\Customer|\App\Models\User $notifiable
     * @return array
     */
    abstract protected function data($notifiable);

    /**
     * Get the notification's delivery channels.
     *
     * @param \App\Models\Customer|\App\Models\User $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }

    /**
     * Get the fcm representation of the notification.
     *
     * @param \App\Models\Customer|\App\Models\User $notifiable
     *
     * @return \NotificationChannels\Fcm\FcmMessage
     */
    public function toFcm($notifiable)
    {
        $data = $this->data($notifiable);

        return FcmMessage::create()
            ->setData($this->encodeFcmPayload($notifiable))
            ->setNotification(
                FcmNotification::create()
                    ->setTitle($data['title'] ?? '')
                    ->setBody($data['body'] ?? '')
                    ->setImage($this->logo())
            )
            ->setWebpush(
                WebpushConfig::create()
                    ->setFcmOptions(WebpushFcmOptions::create()->setAnalyticsLabel('analytics_web'))
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics_android'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A')->setDefaultSound(true))
            )
            ->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
            );
    }

    /**
     * Set Fcm body data
     *
     * @param \App\Models\Customer|\App\Models\User $notifiable
     * @return array
     */
    private function encodeFcmPayload($notifiable)
    {
        return [
            'payload' => json_encode([
                'id' => $this->id,
                'read_at' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'data' => $this->data($notifiable),
                'total_unread' => $notifiable->totalUnreadNotifications() + 1
            ]),
        ];
    }

    /**
     * Get application logo url
     *
     * @return string
     */
    private function logo()
    {
        return asset('assets/images/icons/logo.png?t=' . microtime());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param \App\Models\Customer|\App\Models\User $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data($notifiable);
    }
}
