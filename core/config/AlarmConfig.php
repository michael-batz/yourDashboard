<?php
/********************************************************************
* This file is part of yourDashboard.
*
* Copyright 2014 Michael Batz
*
*
* yourDashboard is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* yourDashboard is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with yourDashboard.  If not, see <http://www.gnu.org/licenses/>.
*
*********************************************************************/

/**
* alarm configuration - reads xml configuration and provides configuration
* about alarming options of dashboard content
* @author: Michael Batz <michael@yourcmdb.org>
*/
class AlarmConfig
{

	//alarming enabled
	private $enabled;

	//soundfile
	private $soundfile;

	/**
	* Creates an alarming configuration object
	*/
	function __construct($xmlfilename)
	{
		//read xml file and generate objects
		$xmlobject = simplexml_load_file($xmlfilename);

		$this->enabled= (string)$xmlobject->enabled[0];
		$this->soundfile = (string)$xmlobject->soundfile[0];
	}


	/**
	* return if dashboard is enabled
	*/
	public function isEnabled()
	{
		return $this->enabled;
	}

	/**
	* return soundfile
	*/
	public function getSoundfile()
	{
		return $this->soundfile;
	}
}
?>
