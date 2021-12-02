<?php
/**
 * @file
 * musicBotController - Free php bot for managing ts3audiobot
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @package     musicBotController
 * @author      Maciej 'Lukieer' Skarbek
 * @copyright   Copyright (c) All rights reserved.
 * 
 */
date_default_timezone_set('Europe/Warsaw');
###########################################
define("Version","1.2.0");     
define("Author","Maciej \"Lukieer\" Skarbek");         
define("End", PHP_EOL);
define("Red", "\e[0;31m");
define("Reset", "\e[0m");
###########################################
system('clear');
echo "
░█████╗░░█████╗░███╗░░██╗██████╗░██╗░░░██╗
██╔══██╗██╔══██╗████╗░██║██╔══██╗╚██╗░██╔╝
██║░░╚═╝███████║██╔██╗██║██║░░██║░╚████╔╝░
██║░░██╗██╔══██║██║╚████║██║░░██║░░╚██╔╝░░
╚█████╔╝██║░░██║██║░╚███║██████╔╝░░░██║░░░
░╚════╝░╚═╝░░╚═╝╚═╝░░╚══╝╚═════╝░░░░╚═╝░░░
".End;

echo End;
echo "» Welcome to Candy musicBotController ".Version." by ".Author.End.End;

echo "Loading bot files...".End;
# Load bot files
require_all_files( __DIR__."/include/classes" );
require_once("include/classes/ts3audiobot-api-class/Autoloader.php");
$config = require "include/configs/config.php";

# Use
use mskarbek\musicBotController;
use mskarbek\musicBotController\Main;
use mskarbek\musicBotController\TeamSpeak;
use mskarbek\musicBotController\Exception;

# Start class
$Main = new Main();

# Get enabled functions
$functions = $Main->getFunctions($config['plugins']);
foreach($functions as $name => $e)
{
    require_once("include/functions/".$name.".php");
    $$name = new $name;
}

# Connect to teamspeak server
$Main->print("Connecting to TeamSpeak server...");
$TeamSpeak = new TeamSpeak($Main, $config['teamspeak']['address'], $config['teamspeak']['port'], $config['teamspeak']['voice_port'], $config['teamspeak']['login'], $config['teamspeak']['password'], $config['teamspeak']['channel_id'], $config['teamspeak']['nickname']);
$ts = $TeamSpeak->getQuery();

# Check ts3 connection
if($ts->isConnected())
{
    $Main->print("Successfully connected to teamspeak server!");
} else {
    $Main->print("Can't connect to teamspeak server!");
    throw new Exception("Can't connect to teamspeak server!");
}
$Main->print(End."Logs:");

while($ts->isConnected())
{

    $clientList = $ts->clientList("-uid -groups -times -voice");

    if($clientList['success'] && !empty($clientList['data']))
    {
        foreach($functions as $function => $cfg)
        {
            if($Main->ifCan($functions, $function))
            {
                $$function->init($ts, $cfg, $clientList['data'], $Main, $TeamSpeak);
            }
        }
        usleep($config['usleep']);
    } else {
        $Main->print("Bot get Flood Ban!");
        throw new Exception('Bot get Flood Ban!');
    }
}
$Main->print("Connection lost.");


function require_all_files($dir) {
    foreach( glob( "$dir/*" ) as $path ){
        if ( preg_match( '/\.php$/', $path ) ) {
            require_once $path;  
        } elseif ( is_dir( $path ) ) {
            require_all_files( $path );  
        }
    }
}

