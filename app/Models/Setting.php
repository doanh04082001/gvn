<?php

namespace App\Models;

class Setting extends BaseModel
{
    /**
     * Example
     * CONTACT_INFO config field = {
     *      'longitude' => '10.772478867207235',
     *      'latitude' => '106.69126472479346',
     *      'address' => 'Lầu 2, Twints Towers 11, 85 Cách Mạng Tháng Tám, Bến Thành, Quận 1, Thành phố Hồ Chí Minh',
     *      'email' => 'info@shilin.com',
     *      'phone' => '0123456789',
     *      'facebook_link' => 'https://facebook.com',
     *      'zalo_link' => 'https://oa.zalo.me/home',
     * }
     */
    const CONTACT_CODE = 'CONTACT_INFO';

    /**
     * Example
     * SITE_CODE config field = {
     *      'site_name' => 'Shilin',
     *      'title' => 'Shilin',
     *      'bio' => 'Shilin',
     * }
     */
    const SITE_CODE = 'SITE_CODE';

    /**
     * Example
     * SHIPPING_METHOD config field = {
     *      'default' => 'shilin',
     *      'ahamove' => {
     *          'name' => 'Ahamove Test User',
     *          'mobile' => '84908842280',
     *          'api_key' => '8b59b7b5fe231e5aa0dfbc15779851a8',
     *          'status' => '1',
     *      },
     *      'shilin' => {
     *          'name' => 'Shilin',
     *          'default_shipping_fee' => '15000',
     *          'order_prepare_time' => '25',
     *          'status' => '1',
     *      },
     *      ...
     * }
     */
    const SHIPPING_METHOD = 'SHIPPING_METHOD';

    const DEFAULT_SHIPPING_METHOD = 'default';

    const AHAMOVE_SHIPPING_METHOD = 'ahamove';

    const SHILIN_SHIPPING_METHOD = 'shilin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'config',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'json',
    ];
}
