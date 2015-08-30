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
namespace yourDashboard\dashboard;

use yourDashboard\dashboard\dashlets\DashletError;

/**
* a concrete dashboard
* @author: Michael Batz <michael@yourcmdb.org>
*/
class Dashboard
{
	//name of the dashboard
	private $name;

	//array of dashlets on dashboard
	private $dashlets;

	/**
	* create a new dashboard
	* @param $name		name of the dashboard
	* @param $dashlets	Array of dashlets shown on the dashboard
	*/
	function __construct($name, $dashlets)
	{
		$this->name = $name;
		$this->dashlets = $dashlets;
	}

	/**
	* Generate HTML output of dashboard
	*/
	public function render()
	{
		//go through all rows
		for($j=0; $j < count($this->dashlets); $j++)
		{
			$row = $this->dashlets[$j];

			//calculate width of columns in bootstrap grid
			$colWidth = floor(12 / count($row));
			if($colWidth < 1)
			{
				$colWidth = 1;
			}

			echo "<div class=\"row dashboard-dashlet-row\">\n";
			for($i=0; $i < count($row); $i++)
			{
				$refreshInterval = $row[$i]->getRefreshInterval();

				echo "<div class=\"col-md-$colWidth dashboard-dashlet\">\n";
				echo "<div class=\"dashboard-dashlet-content table-responsive\" id=\"dashlet-$j-$i\">\n";
				echo "<img src=\"img/icons/waiting.gif\" alt=\"loading...\" class=\"progressbar\" />\n";
				echo "<p class=\"progressbar\">Loading dashlet, please wait...</p>";
				echo "<script type=\"text/javascript\">startDashletLoader('$this->name', $j, $i, $refreshInterval)</script>\n";
				echo "</div>\n";
				echo "</div>\n\n";
			}
			echo "</div>\n";
		}
	}

	/**
	* Return Dashlet object for the given index
	* @param $row		row of dashlet object
	* @param $index		index of dashlet object
	*/
	public function getDashlet($row, $index)
	{
		return $this->dashlets[$row][$index];
	}

	/**
	* Returns an DashletError object, if something went wrong
	*/
	public function getErrorDashlet($errorMessage)
	{
		$dashletParameter = new DashletParameter();
		$dashletParameter->addEntry("message", $errorMessage);
		return new DashletError(30, $dashletParameter);
	}
}
?>
