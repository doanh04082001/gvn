<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use Google_Client;
use Google_Service_Drive;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use League\Flysystem\Filesystem;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            $client = new Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            return new Filesystem(
                new GoogleDriveAdapter(
                    new Google_Service_Drive($client),
                    $config['folderId']
                )
            );
        });
    }
}
