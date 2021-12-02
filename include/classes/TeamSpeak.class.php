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
namespace mskarbek\musicBotController;

use mskarbek\musicBotController\ts3admin;
use mskarbek\musicBotController\Exception;

class TeamSpeak {

    private $ts3admin;
    private $whoAmI;

    public function getQuery()
    {
        return $this->ts3admin;
    }

    public function getMyClid()
    {
        return $this->whoAmI['client_id'];
    }

    public function __construct($Main, $address, $port, $voice_port, $login, $password, $channel, $nick = 'Candy » MusicBots')
    {

        $this->ts3admin = new ts3admin($address, $port);
        $connect = $this->ts3admin->connect();
        if(!$connect['success'])
        {
            $Main->print(Red."ERROR! ".implode(",",$connect['errors']));
            throw new Exception("Can't connect to teamspeak server!");
        }

        $login = $this->ts3admin->login($login, $password);
        if(!$login['success'])
        {
            $Main->print(Red."ERROR! ".implode(",",$login['errors']));
            throw new Exception("Can't login to teamspeak server!");
        }

        $selectServer = $this->ts3admin->selectServer($voice_port);
        if(!$selectServer['success'])
        {
            $Main->print(Red."ERROR! ".implode(",",$selectServer['errors']));
            throw new Exception("Can't select teamspeak server!");
        }
        $this->ts3admin->setName($nick);
        $this->whoAmI = $this->ts3admin->whoAmi()['data'];
        $this->ts3admin->clientMove($this->getMyClid(), $channel);

        return $this->ts3admin;
    }

}