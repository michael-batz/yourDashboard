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
		echo "<div class=\"dashletContainer\">\n";
		//go through all rows
		for($j=0; $j < count($this->dashlets); $j++)
		{
			$row = $this->dashlets[$j];
			echo "<div class=\"dashletRow\">\n";
			for($i=0; $i < count($row); $i++)
			{
				$refreshInterval = $row[$i]->getRefreshInterval();

				echo "<div class=\"dashlet\" id=\"dashlet-$j-$i\">\n";
				echo "<script language=\"JavaScript\">startDashletLoader('$this->name', $j, $i, $refreshInterval)</script>\n";
				echo "</div>\n\n";
			}
			echo "</div>\n";
		}
		echo "</div>\n";
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
