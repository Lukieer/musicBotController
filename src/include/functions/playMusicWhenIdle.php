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
    class playMusicWhenIdle
    {        
        public function init($ts, $cfg, $clients, $Main, $TeamSpeak)
        {
            foreach($clients as $client) 
            {
                if(!empty($client) && isset($client['client_database_id']))
                {
                    if($client['client_type'] == 0 && isset($cfg['settings'][$client['client_database_id']]))
                    {
                        if($Main->inGroup($cfg['musicbot_groups'], explode(",",$client['client_servergroups'])))
                        {
                            $cfg['isAlone'] ? $status = $Main->channelClientCount($clients, $client['cid']) == 1 ? $status = false : $status = true : $status = true;
                            if($status)
                            {
                                if($client['client_idle_time']/1000 >= $cfg['idleTime'])
                                {
                                    foreach($cfg['settings'][$client['client_database_id']] as $cmd)
                                    {
                                        $ts->sendMessage(1, $client['clid'], $cmd);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }