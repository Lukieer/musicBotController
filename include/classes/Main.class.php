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
namespace mskarbek\musicBotController;

class Main {

    public function print($msg = '', $color = '')
    {
        echo $msg.Reset.PHP_EOL;
    }

    public function getFunctions($plugins)
    {
        foreach($plugins as $key => $plugin)
        {
            if($plugin['status'])
            {
                if(isset($plugin['interval']))
                {
                    $plugins[$key]['interval'] = $plugin['interval']['hours'] * 3600 + $plugin['interval']['minutes'] * 60 + $plugin['interval']['seconds'];
                } else {
                    $plugins[$key]['interval'] = 0;
                }
                
                $plugins[$key]['lastRun'] = time();
            } else {
                unset($plugins[$key]);
            }
        }

        return $plugins;
    }

    public function getSubChannels($channelList, $cid)
    {

        $array = [];

        foreach($channelList as $channel)
        {
            if($channel['pid'] == $cid)
            {
                $array[] = $channel;
            }
        }

        return $array;

    }

    public function channelClientList($clients, $cid)
    {
        $return = [];
        foreach($clients as $client)
        {
            if($client['cid'] == $cid)
            {
                $return[] = $client;
            }
        }
        return $return;
    }

    public function ifCan(&$functions, $name)
    {
        foreach($functions as $key => $function)
        {
            if($name == $key)
            {
                if(time() - $function['lastRun'] >= $function['interval'])
                {
                    $functions[$key]['lastRun'] = time();
                    return true;
                }
            }
        }
    }

    public function inGroup($groups, $clGroups)
    {
        foreach($groups as $group)
        {
            if(in_array($group, $clGroups))
            {
                return true;
            }
        }
        return false;
    }

    public function channelClientCount($clients, $cid)
    {
        $count = 0;
        foreach($clients as $client)
        {
            if($client['cid'] == $cid)
            {
                $count++;
            }
        }
        return $count;
    }

}