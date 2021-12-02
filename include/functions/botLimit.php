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
 * 
 */ 
    class botLimit
    {        
        public function init($ts, $cfg, $clients, $Main, $TeamSpeak)
        {

            if($cfg['perServer']['status'])
            {

                $ts3ab = new Lukieer\TS3AudioBot\Api\Instance($cfg['ts3audiobot']['url'], $cfg['ts3audiobot']['login'], $cfg['ts3audiobot']['password']);
                $botList = $ts3ab->botList();

                $count = 0;
                foreach($botList as $bot)
                {
                    if($bot['Status'] == 2)
                    {
                        $bots[$bot['Server']][] = $bot;
                    }
                }

                foreach($bots as $server =>  $bots_on_server)
                {
                    $count = 0;
                    $disconnected = 0;
                    foreach($bots_on_server as $bot)
                    {
                        $count++;
                        if($count > $cfg['perServer']['limit'])
                        {
                            $disconnected++;
                            $ts3ab->bot($bot['Id'])->disconnect();
                        }
                    }
                    if($disconnected)
                    {
                        foreach($clients as $client)
                        {
                            if($Main->inGroup($cfg['notifyGroups'], explode(",",$client['client_servergroups'])))
                            {
                                $ts->sendMessage(1, $client['clid'], "[b][color=#FF0000]!!! UWAGA !!![/color][/b] Przekroczono dozwoloną ilość botów na serwerze [b]'{$server}'[/b]. [b]'{$disconnected}'[/b] botów zostało wyłączonych!");
                            }
                        }
                    }
                }
            }
            $bots = [];
            if($cfg['perChannel']['status'])
            {
                foreach($clients as $client)
                {
                    if($Main->inGroup($cfg['musicbot_groups'], explode(",",$client['client_servergroups'])))
                    {
                        $bots[$client['cid']][] = $client;
                    }
                }

                foreach($bots as $channel => $bots_on_channel)
                {
                    $count = 0;
                    foreach($bots_on_channel as $bot)
                    {
                        $count++;
                        if($count > $cfg['perChannel']['limit'])
                        {
                            $ts->sendMessage(1, $bot['clid'], "!bot disconnect");
                        }
                    }
                }

            }
        }
    }