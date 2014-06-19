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
* clock dashlet
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletClock extends Dashlet
{

	public function getHtmlContentString()
	{
		//get parameter
		$location = $this->parameter->getValue("location");
		$clockFormatDate = $this->parameter->getValue("clockFormatDate");
		$clockFormatTime = $this->parameter->getValue("clockFormatTime");
		$clockDiffUTC = $this->parameter->getValue("clockDiffUTC");
		$clockSummertime = $this->parameter->getValue("clockSummertime");

		//set default values
		if($location == "")
		{
			$location = "London, UK";
		}
		if($clockFormatDate == "")
		{
			$clockFormatDate = "d.m.Y";
		}
		if($clockFormatTime == "")
		{
			$clockFormatTime = "H:i";
		}
		if($clockDiffUTC == "")
		{
			$clockDiffUTC = "0";
		}
		
		//calculate time
		$gmtTimestamp = time();
		$timeDiff = $clockDiffUTC;
		if($clockSummertime == "true")
		{
			$timeDiff += date("I");
		}
		$localTimestamp = $gmtTimestamp + ($timeDiff * 60 * 60);

		//generate output
		$output = "";
		$output .= "<p class=\"clockdashlet-location\">$location</p>";
		$output .= "<p class=\"clockdashlet-date\">". gmdate($clockFormatDate, $localTimestamp)  ."</p>";
		$output .= "<p class=\"clockdashlet-time\">". gmdate($clockFormatTime, $localTimestamp)  ."</p>";
		return $output;
	}

}
?>
