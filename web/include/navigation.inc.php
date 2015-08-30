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

/**
* yourDashboard navigation
* @author Michael Batz <michael@yourcmdb.org>
*/
	//get data
	//$menuitems = $config->getViewConfig()->getMenuItems();
	//$objectGroups = $config->getObjectTypeConfig()->getObjectTypeGroups();

	//navbar header
	echo "<nav class=\"navbar dashboard-navigation\">";
	//mobile view
	echo "<div class=\"navbar-header\">";
	echo "<button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#dashboard-navigation-collapse\">";
        echo "<span class=\"sr-only\">Toggle navigation</span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
        echo "<span class=\"icon-bar\"></span>";
	echo "</button>";

	//title
	echo "<h1><a href=\"index.php\"><img src=\"img/logo_small.png\" alt=\"yourDashboard\" />";
	echo $customizingConfig->getTitle() . "</a></h1>";
	echo "</div>";

	//menu
	echo "<div class=\"collapse navbar-collapse\" id=\"dashboard-navigation-collapse\">";
	echo "<ul class=\"nav navbar-nav navbar-right\">";
	//dashboard selector new
	echo "<li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">";
	echo "<span class=\"glyphicon glyphicon-th\"></span>Dashboard $dashboardName<span class=\"caret\"></span></a>";
	echo "<ul class=\"dropdown-menu\">";
	//walk through all object type groups
	foreach($dashboardConfig->getDashboardNames() as $allDashboardsName)
	{
		echo "<li><a href=\"index.php?dashboard=$allDashboardsName\">$allDashboardsName</a></li>";
	}
	echo "</ul>";
	echo "</li>";
	echo "</ul>";


	//footer
	echo "</div>";
	echo "</nav>";
?>
