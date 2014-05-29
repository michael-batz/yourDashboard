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
* Access to configuration of yourDasgboard
*/
class Config
{

	//dashboard configuration object
	private $configDashboard;

	//customizing configuration object
	private $configCustomizing;

	/**
	* Creates a configuration object
	*/
	function __construct()
	{
		$configurationBase = realpath(dirname(__FILE__)."/../../etc");
		$this->configDashboard = new DashboardConfig("$configurationBase/dashboard-configuration.xml");
		$this->configCustomizing = new CustomizingConfig("$configurationBase/customizing-configuration.xml");
	}


	/**
	* Return dashboard configuration
	*/
	public function getDashboardConfig()
	{
		return $this->configDashboard;
	}

	/**
	* Return customizing configuration
	*/
	public function getCustomizingConfig()
	{
		return $this->configCustomizing;
	}

}




?>
