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
namespace yourDashboard\dashboard\dashlets;

use yourDashboard\dashboard\Dashlet;

/**
* error dashlet: shown when dashlet class not found
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletError extends Dashlet
{

	/**
	* parameters:
	* - message: error message
	*/
	public function getHtmlContentString()
	{
		$output = "<h1 class=\"text-center\">Ooops: Dashlet Error</h1>";
		$output .= "<img class=\"DashletError-icon\" src=\"img/icons/critical.png\" />";
		$output .= "<div class=\"DashletError-text\"><p>";
		$output .= "Sorry, there was an error loading the dashlet.";
		$output .= "<br />";
		$output .= "reason: ". $this->parameter->getValue("message");
		$output .= "<br />";
		$output .= "We will try to reload the dashlet in the configured interval...";
		$output .= "</p>";
		$output .= "</div>";
		return $output;
	}

}
?>
