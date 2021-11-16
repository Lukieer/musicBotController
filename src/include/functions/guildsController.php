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
    class guildsController
    {        
        public function init($ts, $cfg, $clients, $Main, $TeamSpeak)
        {
            $channelList = $ts->channelList()['data'];
            foreach($channelList as $channel)
            {
                $channels[$channel['cid']] = $channel;
            }
            $channelList = $channels;
            unset($channels);


            switch($cfg['mode'])
            {
                case "openapps":
                    try {
                        $pdo = new PDO("mysql:host=" . $cfg['database']['address'] . ";dbname=" . $cfg['database']['database'] . "", $cfg['database']['login'], $cfg['database']['password']);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch(PDOException $e) {
                        throw new Exception("Nie udało się połączyć z bazą danych!");
                        return false;
                    }

                    $request = $pdo->query("SELECT `cids`, `name`,`type`, `teleport` FROM ".$cfg['database']['table']);
                    $guilds = $request->fetchAll(PDO::FETCH_ASSOC);

                    foreach($guilds as $guild)
                    {
                        $clans[$guild['name']] = ['cids' => explode(", ",$guild['cids']), 'type' => $guild['type'], 'channel' => $guild['teleport']];
                    }

            }

            if(!empty($clans))
            {
                foreach($clans as $name => $clan)
                {
                    $channels = array();
                    $first_channel = $clan['cids'][0];
                    $last_channel = $clan['cids'][array_key_last($clan['cids'])];
                    foreach($clan['cids'] as $cid)
                    {

                        foreach($channelList as $channel)
                        {
                            if($channel['cid'] == $cid)
                            {
                                $channels[$channel['cid']] = $channel;
                            }
                        }

                        foreach($Main->getSubChannels($channelList, $cid) as $channel)
                        {
                            $channels[$channel['cid']] = $channel;
                        }

                    }

                    $bots = [];
                    foreach($channels as $channel)
                    {
                        foreach($Main->channelClientList($clients, $channel['cid']) as $client)
                        {
                            if($Main->inGroup($cfg['musicbot_groups'], explode(",",$client['client_servergroups'])))
                            {
                                $bots[] = $client;
                            }
                        }
                    }

                    $i = 0;
                    foreach($bots as $bot)
                    {
                        $i++;
                        $correctName = str_replace(["[NAME]", "[num]"], [$name, $i], $cfg['botName']);
                        if($correctName != $bot['client_nickname'])
                        {
                            echo 1;
                            $ts->sendMessage(1, $bot['clid'], str_replace(["[NAME]", "[num]"], [$name, $i], $cfg['name_command'] . " " . $cfg["botName"]));
                        }
                    }

                    if(isset($cfg['sectors'][$clan['type']]))
                    {
                        if($cfg['sectors'][$clan['type']] != count($bots))
                        {

                            if(count($bots) > $cfg['sectors'][$clan['type']])
                            {
                                $over = count($bots) - $cfg['sectors'][$clan['type']];
                            } else {
                                $needed = $cfg['sectors'][$clan['type']] - count($bots);
                            }

                            if(isset($over))
                            {
                                foreach($bots as $bot)
                                {
                                    if($over != 0)
                                    {
                                        if($ts->clientMove($bot['clid'], $cfg['musicbot_channel'])['success'])
                                        {
                                            foreach($clients as $key => $client)
                                            {
                                                if($client['clid'] == $bot['clid'])
                                                {
                                                    $clients[$key]['cid'] = $cfg['musicbot_channel'];
                                                }
                                            }
                                            $ts->sendMessage(1, $bot['clid'], str_replace("[db]", $client['client_database_id'], $cfg['backName']));
                                            $over--;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            }
                            if(isset($needed))
                            {
                                $i = 0;
                                foreach($Main->channelClientList($clients, $cfg['musicbot_channel']) as $client)
                                {
                                    if($needed != 0)
                                    {
                                        $i++;
                                        $ts->sendMessage(1, $client['clid'], str_replace(["[NAME]", "[num]"], [$name, count($bots)+$i], $cfg['setName']));
                                        $ts->clientMove($client['clid'], $clan['channel']);
                                        foreach($clients as $key => $client)
                                        {
                                            if($client['clid'] == $bot['clid'])
                                            {
                                                $clients[$key]['cid'] = $clan['channel'];
                                            }
                                        }
                                        $needed--;
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }