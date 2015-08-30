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
			$location = "";
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
		$output .= "<img class=\"DashletClock-clock\" src=\"data:image/svg+xml;base64," . base64_encode($this->generateSVGClock($localTimestamp)) . "\" />";
		$output .= "<div class=\"DashletClock-timestring\">";
		$output .= "<p class=\"DashletClock-location\">$location</p>";
		$output .= "<p>";
		$output .= gmdate($clockFormatDate, $localTimestamp);
		$output .= "<br />";
		$output .= gmdate($clockFormatTime, $localTimestamp);
		$output .= "</p>";
		$output .= "</div>";
		return $output;
	}

	private function generateSVGClock($localTimestamp)
	{
		//calculate position of hands
		$minutes = gmdate('i', $localTimestamp);
		$hours = gmdate('h', $localTimestamp);
		$angleMinutes = ($minutes/60) * 360;
		$angleHours = (($hours/12) * 360) + ($minutes/60) * 30;

		//set image size
		$width = 100;
		$height = 100;

		//generate SVG header
		$svg = "";
		$svg .= '<?xml version="1.0" encoding="UTF-8"?>';
		$svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
		$svg .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ev="http://www.w3.org/2001/xml-events" ';
		$svg .= 'version="1.1" baseProfile="full" width="'.$width.'px" height="'.$width.'px">';
		$svg .= '<g transform="translate('. $width / 2 .', '. $height / 2 .') scale('. ($width/220) .', '. ($height/220) .')">';

		//clock border
		$svg .= '<circle cx="0" cy="0" r="100" fill="none" stroke="black" stroke-width="5"/>';

		//definition of 5min block
		$svg .= '<g id="5min">';
		//hour mark
		$svg .= '<line x1="0" y1="-85" x2="0" y2="-100" stroke="black" stroke-width="5" />';
		//min mark
		$svg .= '<line x1="0" y1="-90" x2="0" y2="-98" stroke="grey" stroke-width="3" transform="rotate(6,0,0)" />';
		$svg .= '<line x1="0" y1="-90" x2="0" y2="-98" stroke="grey" stroke-width="3" transform="rotate(12,0,0)" />';
		$svg .= '<line x1="0" y1="-90" x2="0" y2="-98" stroke="grey" stroke-width="3" transform="rotate(18,0,0)" />';
		$svg .= '<line x1="0" y1="-90" x2="0" y2="-98" stroke="grey" stroke-width="3" transform="rotate(24,0,0)" />';
		$svg .= '</g>';

		//repition of 5min block
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(30,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(60,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(90,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(120,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(150,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(180,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(210,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(240,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(270,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(300,0,0)" />';
		$svg .= '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#5min" transform="rotate(330,0,0)" />';

		//definition of hands
		$svg .= '<line x1="0" y1="0" x2="0" y2="-50" stroke="red" stroke-width="5" transform="rotate('.$angleHours.',0,0)"/>';
		$svg .= '<line x1="0" y1="0" x2="0" y2="-80" stroke="black" stroke-width="5" transform="rotate('.$angleMinutes.',0,0)"/>';

		//SVG footer
		$svg .= '</g>';
		$svg .= '</svg>';

		return $svg;
	}

}
?>
