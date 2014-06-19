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
* dashlet for dashboard
* @author: Michael Batz <michael@yourcmdb.org>
*/
abstract class Dashlet
{
	//dashlet refresh interval [ms]
	protected $refresh;
	
	//dashlet parameters
	protected $parameter;

	/**
	* Create a new dashlet
	* @param $refresh	refresh interval [ms]
	* @param $parameter	dashlet parameter
	*/
	function __construct($refresh, DashletParameter $parameter)
	{
		$this->refresh = $refresh;
		$this->parameter = $parameter;
	}

	public function getRefreshInterval()
	{
		return $this->refresh;
	}


	/**
	* return HTML last updated output string
	*/
	public function getHtmlLastUpdateString()
	{
		$displayUpdateString = $this->parameter->getValue("displayUpdateString");
		$output = "";
		if($displayUpdateString != "false")
		{
			$output .= "<div class=\"updatestring\">Last Update: ";
			$output .= date("d.m.Y - H:i");
			$output .= "</div>";
		}
		return $output;
	}

	/**
	* return HTML output of dashlet
	*/
	abstract public function getHtmlContentString();

}
?>
