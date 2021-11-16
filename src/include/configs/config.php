<?php

return [
    'teamspeak' => [
        'address' => '', # TeamSpeak address
        'port' => '10011', # TeamSpeak query port
        'voice_port' => '', # TeamSpeak udp port
        'login' => '', # Login to query
        'password' => '', # Password to query
        'channel_id' => 2900, # ID of channel
        'nickname' => 'Candy » MusicBots' # Nickname of bot
    ],

    'usleep' => 50000, # Don't change it!

    "plugins" => [

        "playMusicWhenIdle" => [
            'status' => true, # Status 
            'musicbot_groups' => [113], # Groups ID of bots
            'isAlone' => true, # Send message if channel is empty?
            'idleTime' => 1, # AFK time in seconds
            'settings' => [

                # client database id => commands

                16549 => ['!play http://217.74.72.10:8000/rmf_maxxx', '!vol 30'],
                16799 => ['!play https://s3.slotex.pl/shoutcast/7320/stream?sid=1', '!vol 100'],
                16633 => ['!play http://217.74.72.10:8000/rmf_maxxx', '!vol 10'],
            ],
            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 1], # Interval
        ],

        "setChannelCommander" => [
            'status' => true,
            'musicbot_groups' => [113], # Groups ID of bots
            'ignored_groups' => [], # Ignored groups
            'command' => '!bot commander on', # Command to run commander
            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 1], # Interval
        ],

        "registerBot" => [
            'status' => true,
            'musicbot_groups' => [113], # Groups ID of bots
            'ignored_groups' => [], # Ignored groups
            'ignored_uids' => [], # Ignored uids
            'ignored_dbids' => [14871,16549], # Ignored dbids
            'lobby_channel_id' => 1161, # Lobby channel id
            'move_to_channel' => 1883, # Musicbot channel id
            'commands' => # Commands ([db] - client database_id)
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
            'musicbot_groups' => [113], # Groups ID of bots
            'musicbot_channel' => 1883, # Musicbot channel id
            'setName' => '!bot name Guild | [NAME] #[num]', # Nickname when moved to guild ([NAME] - guild name, [num] - number of guild)
            'backName' => '!bot name TSCuksy.PL | #[db]', # Nickname when moved to musicbot channel ([db] - client database id)
            
            'mode' => 'openapps', # At this version - only openapps
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
            "botName" => "Guild | [NAME] #[num]", # Nickname when moved to guild ([NAME] - guild name, [num] - number of guild)
            "name_command" => "!bot name", # Command to change a nickname of bot

            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 30], # Interval 
        ],

        "checkBot" => [
            'status' => true,
            'musicbot_cid' => 1883, # Musicbot channel id
            'musicbot_groups' => [113], # Groups ID of bots
            'min_bots' => 5, # Minimum bots in channel
            'max_bots' => 10, # Maximum bots in channel
            'teamspeak' => 'tscuksy.pl', # Addres of teamspeak server
            'disconnect_command' => '!bot disconnect', # Command to bot disconnect

            "ts3audiobot" => [
                "url" => '', # URL with port
                "login" => '', # Login (uid)
                "password" => '', # Password (token)
            ],

            'interval' => ['hours' => 0,'minutes' => 0,'seconds' => 5], # Interval 
        ],

    ],

];