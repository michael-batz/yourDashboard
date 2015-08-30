<?php
/********************************************************************
* This file is part of yourDashboard.
*
* Copyright 2014-2015 Michael Batz
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
namespace yourDashboard\config;

/**
* customizing configuration - reads xml configuration and provides configuration
* about customizing the UI of yourDashboard
* @author: Michael Batz <michael@yourcmdb.org>
*/
class CustomizingConfig
{

	//title of the dashboard
	private $title;

	//logo
	private $logo;

	//show header
	private $showHeader;

	//show dashboard selector
	private $showSelector;

	/**
	* Creates a customizing configuration object
	*/
	function __construct($xmlfilename)
	{
		//read xml file and generate objects
		$xmlobject = simplexml_load_file($xmlfilename);

		$this->title = (string)$xmlobject->title[0];
		$this->logo = (string)$xmlobject->logo[0];
		$this->showHeader = (string)$xmlobject->{'show-header'}[0];
		$this->showSelector = (string)$xmlobject->{'show-selector'}[0];
	}


	/**
	* return dashboard title
	*/
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* return logo filename
	*/
	public function getLogo()
	{
		return $this->logo;
	}

	/**
	* return show header option
	*/
	public function getShowHeader()
	{
		return $this->showHeader;
	}

	/**
	* return show selector option
	*/
	public function getShowSelector()
	{
		return $this->showSelector;
	}

}
?>
