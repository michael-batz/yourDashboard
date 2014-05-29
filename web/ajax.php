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
* yourDashboard AJAX Loader
* loads content parts for the dashboard
* for usage in ajax functions 
* @author: Michael Batz <michael@yourcmdb.org>
*/

//load base functions and header
require("include/base.php");

//open controller
$controller = new Controller();


//check, which content should be loaded
$content = getHttpGetVar("content", "");
switch($content)
{
	case "dashlet":
			$dashboard = $controller->getDashboardObject(getHttpGetVar("dashboard", "default"));
			$dashletRow = getHttpGetVar("row", 0);
			$dashletId = getHttpGetVar("id", 0);
			loadDashlet($dashboard, $dashletRow, $dashletId);
		break;

	default:
		break;
}


/**
* Loads and prints out the content of a specific dashlet
* @param $dashboard	Dashboard object
* @param $dashletRow	Row of the dashlet
* @param $dashletId	Id of the dashlet
*/
function loadDashlet($dashboard, $dashletRow, $dashletId)
{
	try
	{
		echo $dashboard->getDashlet($dashletRow, $dashletId)->getHtmlContentString();
	}
	catch(Exception $e)
	{
		echo $dashboard->getErrorDashlet($e->getMessage())->getHtmlContentString();
	}
}

?>
