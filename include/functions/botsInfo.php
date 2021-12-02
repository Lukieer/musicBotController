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
    class botsInfo
    {        
        public function init($ts, $cfg, $clients, $Main, $TeamSpeak)
        {

            $ts3ab = new Lukieer\TS3AudioBot\Api\Instance($cfg['ts3audiobot']['url'], $cfg['ts3audiobot']['login'], $cfg['ts3audiobot']['password']);

            $botList = $ts3ab->botList();

            $count_offline = 0;
            $count_starting = 0;
            $count_online = 0;

            foreach($botList as $once)
            {
                if($once['Status'] == 0)
                {
                    $count_offline++;
                } elseif($once['Status'] == 1)
                {
                    $count_starting++;
                } elseif($once['Status'] == 2) {
                    $count_online++;
                }
            }

            $system = $ts3ab->systemInfo();

            $last_key_cpu = $system['cpu'][array_key_last($system['cpu'])];
            $last_key_cpu = substr(str_replace("0.", "", $last_key_cpu),0,3);

            
            $last_key_cpu = substr($last_key_cpu, 0, 2) . '.' . substr($last_key_cpu, 2);
            

            $a = array_filter($system['memory']);
            $average_memory = floor(array_sum($a)/count($a));


            $average_memory = $this->isa_convert_bytes_to_specified($average_memory, 'M').PHP_EOL;



            $count = count($botList);

            $desc = '[center][size=15][COLOR=#ff5500][b]» Status botów muzycznych «[/b][/COLOR][/size]';
            $desc .= '\n\n';
            $desc .= "[size=13]Aktualnie, jest [COLOR=#ff5500][b]{$count}[/b][/color] utworzonych botów, w tym [COLOR=#ff5500][b]{$count_online}[/b][/color] botów online, [COLOR=#ff5500][b]{$count_offline}[/b][/color] botów offline, oraz [COLOR=#ff5500][b]{$count_starting}[/b][/color] w trakcie łączenia!\n[/size]";
            $desc .= "\n[hr]\n";
            $desc .= "[size=13] W tym momencie aplikacja TS3AudioBot zużywa średnio [COLOR=#ff5500][b]{$last_key_cpu}[/b][/color] CPU oraz [COLOR=#ff5500][b]{$average_memory} MB[/b][/color] RAMU!\n";
            $desc .= '[/size]\n[hr]\n';

            foreach($ts->channelList()['data'] as $once) $channelList[$once['cid']] = $once;

            foreach($clients as $client)
            {
                if($Main->inGroup($cfg['musicbot_groups'], explode(",",$client['client_servergroups'])))
                {
                    $prepare = $this->get_index($client['client_unique_identifier'], $client['client_nickname']).' : [COLOR=#ff5500][b]'.$channelList[$client['cid']]['channel_name'].'[/b][/color]\n';
                    $test = $desc . $prepare;
                    if(strlen($test) < 8192)
                    {
                        $desc .= $prepare;
                    } else {
                        break;
                    }
                }
            }




            $ts->channelEdit($cfg['channel_id'], ['channel_description' => $desc]);
        
        }
        /**
         * Convert bytes to the unit specified by the $to parameter.
         * 
         * @param integer $bytes The filesize in Bytes.
         * @param string $to The unit type to convert to. Accepts K, M, or G for Kilobytes, Megabytes, or Gigabytes, respectively.
         * @param integer $decimal_places The number of decimal places to return.
         *
         * @return integer Returns only the number of units, not the type letter. Returns 0 if the $to unit type is out of scope.
         *
         */
        function isa_convert_bytes_to_specified($bytes, $to, $decimal_places = 1) {
            $formulas = array(
                'K' => number_format($bytes / 1024, $decimal_places),
                'M' => number_format($bytes / 1048576, $decimal_places),
                'G' => number_format($bytes / 1073741824, $decimal_places)
            );
            return isset($formulas[$to]) ? $formulas[$to] : 0;
        }
        public function get_index($uq, $nick)
        {
            
            return '[URL=client://1/'.$uq.']'.$nick.'[/URL]';
        }
    }