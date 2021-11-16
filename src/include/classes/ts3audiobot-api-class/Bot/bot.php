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

class bot extends request {

    public $auth;
    public $id;
/**
 * 
 *  __construct - Register new bot
 * 
 * @param array    $auth  Login options
 * @param int      $id    Bot id
 * 
 * @return boolean 1
 * 
 */
    public function __construct(Array $auth, int $id)
    {
        $this->auth = $auth;
        $this->id = $id;

        return true;
    }
/**
 * 
 * botInfo - Info about the bot.
 * 
 * @return string botInfo
 * 
 */
	public function botInfo()
    {
		return parent::request($this->auth, $this->id, '(/bot/info/client');
	}
/**
 * 
 * play - Automatically tries to decide whether the link is a special resource (like youtube) or a direct resource (like ./hello.mp3) and starts it.
 * 
 * @param   string  $string - Youtube or Patch to music
 * 
 * @return  array
 * 
 */
    public function play(string $string)
    {
        return parent::request($this->auth, $this->id, '(/play/'.urlencode($string));
    }
/**
 * 
 * setVolume - Sets the volume level of the music.
 * 
 * @param   int  $vol - Volume
 * 
 * @return array
 * 
 */
	public function setVolume(int $vol)
	{
		return parent::request($this->auth, $this->id, '/(/volume/'.$vol);
	}
/**
 * 
 * next - Plays the next song in the playlist.
 * 
 * @return array
 * 
 */
    public function next()
	{
		return parent::request($this->auth, $this->id, '(/next');
	}
/**
 * 
 *  previous - Plays the previous song in the playlist.
 * 
 * @return array
 * 
 */
    public function previous()
    {
	    return parent::request($this->auth, $this->id, '(/previous');
    }
/**
 * 
 * pause - Well, pauses the song. Undo with !play.
 * 
 * @return array
 * 
 */
    public function pause()
	{
		return parent::request($this->auth, $this->id, '(/pause');
	}
/**
 * 
 * pause - Lets you format multiple parameter to one.
 * 
 * @param  array  $param - paramets
 * 
 * @return array
 * 
 */
    public function print($param)
	{
		$param = implode(",",$param);
		return parent::request($this->auth, $this->id, '(/print/'.$param);
	}
/**
 * 
 * rng - Gets a random number.
 * 
 * @param  int  $first - First number.
 * @param  int  $second - Second number.
 * 
 * @return array
 * 
 */
    public function rng($first = 1, $second = 1)
	{
		return parent::request($this->auth, $this->id, '(/rng/'.$first.'/'.$second);
	}
/**
 * 
 * seek - Jumps to a timemark within the current song.
 * 
 * @param  string  $position - Position.
 * 
 * @return array
 * 
 */
    public function seek($position)
	{
		return parent::request($this->auth, $this->id, '(/seek/'.$position);
	}

/**
 * 
 * seek - Tells you the name of the current song.
 * 
 * @return array
 * 
 */
    public function song()
	{
		return parent::request($this->auth, $this->id, '(/song/');
	}
/**
 * 
 * pause - Stops the current song.
 * 
 * @return array
 * 
 */
    public function stop()
	{
		return parent::request($this->auth, $this->id, '(/stop');
	}
/**
 * 
 * take - Take a substring from a string..
 * 
 * @return array
 * 
 */
    public function take()
	{
		return parent::request($this->auth, $this->id, '(/take');
	}
/**
 * 
 * version - Gets the current build version.
 * 
 * @return array
 * 
 */
    public function version()
	{
		return parent::request($this->auth, $this->id, '(/version');
	}
/**
 * 
 * add - Adds a new song to the queue.
 * 
 * @param   string  $string - Youtube or Patch to music
 * 
 * @return  array
 * 
 */
    public function add(string $add)
	{
		return parent::request($this->auth, $this->id, '(/add/'.urlencode($add));
	}

	public function disconnect()
	{
		return parent::request($this->auth, $this->id, '(/bot/disconnect');
	}
	public function save($name)
	{
		return parent::request($this->auth, $this->id, '(/bot/save/'.$name);
	}

}
