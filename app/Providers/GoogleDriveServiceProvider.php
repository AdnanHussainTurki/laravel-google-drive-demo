<?php

namespace App\Providers;

use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
            $client = new \Google_Client;
            $service = new \Google_Service_Drive($client);

        \Storage::extend('google', function ($app, $config) use ($service, $client) {
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $adapter = new GoogleDriveAdapter($service, $config['folderId']);
            
            return new \League\Flysystem\Filesystem($adapter);
        });

    }
}
