<?php
/*
 * This file is apart of the ts3audiobot-api project.
 *
 * Copyright 		:: (C) 2021 Maciej Skarbek
 * Website			:: mskarbek.pl
 * Github			:: https://github.com/Lukieer/ts3audiobot-api
 * 
 * Created			:: 23 November 2020	
 * last modified	:: 17 March 2021
 * 
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Lukieer\TS3AudioBot\Api;


class Instance extends request {

    private $auth;
/**
 * 
 * __construct
 * 
 * Create new instance of TS3AudioBot connection
 * 
 * @param   string  $url - url to audioBot:port
 * @param   string  $login - login to audioBot
 * @param   string  $password - password to audioBot
 * 
 * @return  boolean  true
 * 
 */
    public function __construct(string $url, string $login, string $password)
    {
        $this->auth = ['url' => $url, 'login' => $login, 'password' => $password];
        return true;
    }
/**
 * 
 * bot
 * 
 * Create new object of bot.
 * 
 * @param   int $id - Bot id
 * 
 * @return  bot class
 * 
 */
    public function bot(int $id): bot
    {
        return new bot($this->auth, $id);
    }
/**
 * 
 * botList
 * 
 * List of bot
 * 
 * @param   int    $type - 1 = bot + ts3 info, $type = 0 - onlu bot info
 * 
 * @return  array  list of bots
 * 
 */
	public function botList($type = 0){
			
		$list = parent::request2($this->auth, 'bot/list');
		if($type == 1)
		{
			foreach($list as $key => $bot)
			{
				if(isset($bot['Id'])){
					$botinfo = $this->bot($bot['Id'])->botInfo();
					$list[$key]['cid'] = $botinfo['Channel'];
					$list[$key]['dbid'] = $botinfo['DatabaseId'];
					$list[$key]['nick'] = $botinfo['Name'];
				}
			}
		}
		return $list;
	}

	public function connect($name){

		return parent::request2($this->auth, 'bot/connect/template/'.$name);
	}
	
	public function systemInfo(){

		return parent::request2($this->auth, 'system/info');
	}

	public function delete($name)
	{
		return parent::request2($this->auth, 'settings/delete/'.$name);

	}

/**
 * 
 * Settings
 * 
 * Change settings of bot
 * 
 * @param   string  name of bot
 * 
 * @return  array 
 * 
 */
	public function settings(string $name): settings
	{
		return new settings($this->auth, $name);
	}

    
    

}
