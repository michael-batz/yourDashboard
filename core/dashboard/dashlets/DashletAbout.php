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
* about dashlet: shows some information about yourdashboard
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletAbout extends Dashlet
{

	public function getHtmlContentString()
	{
		$controller = new Controller();
		$version = $controller->getVersion();

		$output = "<h1>about: yourDashboard</h1>";
		$output .= "<img class=\"DashletAbout-icon\" src=\"img/logo.png\" />";
		$output .= "<div class=\"DashletAbout-text\">";
		$output .= "<p>";
		$output .= "version: $version";
		$output .= "<br />";
		$output .= "&copy; 2014 Michael Batz";
		$output .= "<br />";
		$output .= "yourDasboard is free software. Your can redistribute/modify/use it under the terms of GPLv3";
		$output .= "<br />";
		$output .= "For more information, please see <a href=\"http://www.yourdashboard.org\">http://www.yourdashboard.org</a>";
		$output .= "</p>";
		$output .= "</div>";
		return $output;
	}

}
?>
