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

abstract class request {
/**
 * 
 * request - request to bot instance
 * 
 * @param  	  array     $auth - auth info
 * @param	  int		$id - bot id
 * @param 	  string    $api - Api function
 * 
 * @return array
 * 
 */
    public function request(array $auth, int $id, string $api)
    {
        $login = $auth['login'];
		$password = $auth['password'];
		$url = $auth['url'];
		$url = $url.'/api/bot/use/'.$id.'/'.$api;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
		$result = curl_exec($ch);
		
		curl_close($ch);  
		return json_decode($result, true);
    }
/**
 * 
 * request2 - request to bot application
 * 
 * @param  	  array     $auth - auth info
 * @param 	  string    $api - Api function
 * 
 * @return array
 * 
 */
	public function request2(array $auth, string $api)
    {
        $login = $auth['login'];
		$password = $auth['password'];
		$url = $auth['url'];
		$url = $url.'/api/'.$api;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
		$result = curl_exec($ch);
		curl_close($ch);  
		
		return json_decode($result, true);
    }

}
