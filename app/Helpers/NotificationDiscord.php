<?php

use Illuminate\Support\Facades\Http;

function NotificationDiscord($title, $description){

    if(config('services.discord.url') != null){

        return Http::post(config('services.discord.url'), [
            'content' => "APP-Pembelian",
            'embeds' => [
                [
                    'title'         => $title,
                    'description'   => $description,
                    'color' => '7506394',
                ]
            ],
        ]);

    }

}

?>