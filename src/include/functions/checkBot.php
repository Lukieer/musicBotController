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
    class checkBot
    {        
        public function init($ts, $cfg, $clients, $Main, $TeamSpeak)
        {
            $count = 0;
            $bots = array();
            foreach($clients as $client)
            {
                $clGroups = explode(",",$client['client_servergroups']);
                if($client['client_type'] == 0 && $Main->inGroup($cfg['musicbot_groups'], $clGroups) && $client['cid'] == $cfg['musicbot_cid'])
                {
                    $bots[] = $client;
                    $count++;
                    if($count > $cfg['max_bots'])
                    {
                        $ts->sendMessage(1, $client['clid'], $cfg['disconnect_command']);
                        $count--;
                    }
                }
            }

            if(count($bots) < $cfg['min_bots'])
            {
                $ts3ab = new Lukieer\TS3AudioBot\Api\Instance($cfg['ts3audiobot']['url'], $cfg['ts3audiobot']['login'], $cfg['ts3audiobot']['password']);
                $botList = $ts3ab->botList();
                $ok = false;
                foreach($botList as $bot)
                {
                    if($bot['Status'] == 0)
                    {
                        $ts3ab->connect($bot['Name']);
                        $ok = true;
                        break;
                    }
                }
                if(!isset($ok) && isset($bots[0]))
                {
                    $ts->sendMessage(1, $bots[0], "!bot connect to ".$cfg['teamspeak']);
                    $chat = $ts->readChatMessage('textprivate')['data'];
                    $matches = explode("Id: ", $chat['msg'])[1];
                    $matches = explode(" Name:",$matches)[0];
                    $ts3ab->bot($matches)->save('AutoSave-'.$bots[0].substr(md5(microtime()),rand(0,26),3));
                }
            }
        }
    }