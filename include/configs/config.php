<?php

return [
    'teamspeak' => [
        'address' => '',
        'port' => '10011',
        'voice_port' => '9987',
        'login' => '',
        'password' => '',
        'channel_id' => 2900,
        'nickname' => 'Candy » MusicBots'
    ],

    'usleep' => 50000,

    "plugins" => [

        "playMusicWhenIdle" => [
            'status' => true,
            'musicbot_groups' => [113],
            'isAlone' => true, # Czy wysyłać komendy, tylko jeśli ktoś jest na kanale
            'idleTime' => 1, # Czas AFK w sekundach
            'settings' => [

                # client database id => commands

                16549 => ['!play http://217.74.72.10:8000/rmf_maxxx', '!vol 30'],
                16799 => ['!play https://s3.slotex.pl/shoutcast/7320/stream?sid=1', '!vol 100'],
                16801 => ['!play http://217.74.72.10:8000/rmf_maxxx', '!vol 10'],
            ],
            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 1],  
        ],

        "setChannelCommander" => [
            'status' => true,
            'musicbot_groups' => [113],
            'ignored_groups' => [],
            'command' => '!bot commander on',
            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 1],  
        ],

        "registerBot" => [
            'status' => true,
            'musicbot_groups' => [113],
            'ignored_groups' => [],
            'ignored_uids' => [],
            'ignored_dbids' => [14871,16549],
            'lobby_channel_id' => 1161,
            'move_to_channel' => 1883,
            'commands' => 
            [
                '!bot name TSCuksy.PL | #[db]',
                '!setting set connect.name TSCuksy.PL | #[db]',
                '!settings set connect.channel "/1883"',
                '!setting set events.onalone "!stop"',
                '!setting set events.onparty "!play"',
                '!alias add yts "!search from youtube (!param 0)"',
                '!alias add ytp "!x (!search from youtube (!param 0)) (!search play 0)"',
            ],	
        ],

        "guildsController" => [
            'status' => true,
            'musicbot_groups' => [113],
            'musicbot_channel' => 1883,
            'setName' => '!bot name Guild | [NAME] #[num]',
            'backName' => '!bot name TSCuksy.PL | #[db]',
            
            'mode' => 'openapps',
            'database' => [
                "address" => "",
                "login" => "",
                "password" => "",
                "database" => "openapps",
                "table" => "guilds",
            ],

            'sectors' => [
                'Gildia' => 1,
                'VIP' => 2,
                'Gaming' => 3,
                'Premium' => 3,
                'Special' => 3,
                'Custom' => 3,
            ],

            "checkBotNames" => true,
            "botName" => "Guild | [NAME] #[num]",
            "name_command" => "!bot name",

            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 30],  
        ],

        "checkBot" => [
            'status' => true,
            'musicbot_cid' => 1883, // id kanału gdzie są boty
            'musicbot_groups' => [113], // grupa botów muzycznych
            'min_bots' => 5, // ile botów powinno być minimum botów na kanale
            'max_bots' => 10,
            'teamspeak' => 'tscuksy.pl',
            'disconnect_command' => '!bot disconnect',

            "ts3audiobot" => [
                "url" => '',
                "login" => '',
                "password" => '',
            ],

            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 5],  
        ],

        "botLimit" => [
            'status' => true,
            'musicbot_groups' => [113], // grupa botów muzycznych
            'notifyGroups' => [315],
            "ts3audiobot" => [
                "url" => '',
                "login" => '',
                "password" => '',
            ],

            'perServer' => [
                'status' => true,
                'limit' => 60,
            ],

            'perChannel' => [
                'status' => true,
                'limit' => 10,
            ],

            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 5],  
        ],

        'botsInfo' => [
            "status" => true,
            'channel_id' => 1883,
            'musicbot_groups' => [113], // grupa botów muzycznych
            "ts3audiobot" => [
                "url" => '',
                "login" => '',
                "password" => '',
            ],

            'interval' => ['hours' => 0,'minutes' => 1,'seconds' => 0],  
        ],

    ],

];