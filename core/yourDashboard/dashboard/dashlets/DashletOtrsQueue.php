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
use yourDashboard\dashboard\DashletException;
use yourDashboard\connectors\ConnectorOtrs;

/**
* dashlet to show the last tickets of an OTRS queue
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletOtrsQueue extends Dashlet
{

	public function getHtmlContentString()
	{
		//get parameters
		$title = $this->parameter->getValue("title");
		$soapUrl = $this->parameter->getValue("soapUrl");
		$soapUser = $this->parameter->getValue("soapUser");
		$soapPassword = $this->parameter->getValue("soapPassword");
		$queue = $this->parameter->getValueArray("queue");
		$ticketStates = $this->parameter->getValueArray("ticketState");
		$ticketLock = $this->parameter->getValueArray("ticketLock");
		$maxEntries = $this->parameter->getValue("maxEntries");
		$linkUrlBase = $this->parameter->getValue("linkUrlBase");
		$createAlarms = $this->parameter->getValue("createAlarms");
		$alarmMinTime = $this->parameter->getValue("alarmMinTime");
		$alarmMaxTime = $this->parameter->getValue("alarmMaxTime");

		//set default values
		if($alarmMinTime == "")
		{
			$alarmMinTime = 0;
		}
		if($alarmMaxTime == "")
		{
			$alarmMaxTime = 300;
		}
	
		//set default value for ticketState
		if(count($ticketStates) == 0)
		{
			$ticketStates = Array("new", "open");
		}
	
		//set default value for ticketLock
		if(count($ticketLock) == 0)
		{
			$ticketLock = Array("unlock");
		}

		//open connector
		$connector = new ConnectorOtrs($soapUrl, $soapUser, $soapPassword);

		//get ticketIDs
		$tickets = $connector->getTickets($queue, $ticketStates, $ticketLock, $maxEntries + 1);

		//start output
		$output = "<h1 class=\"text-center\">$title</h1>";
		$output .= "<table class=\"dashboard-severity\">";

		//output of ticket summary
		$i = 0;
		foreach($tickets as $ticketId)
		{
			if($i >= $maxEntries)
			{
				break;
			}
			$ticket = $connector->getTicketSummary($ticketId);

			//create alarm if configured for every alarm in the given interval
			if($createAlarms == "true" && $ticket['Age'] >= $alarmMinTime && $ticket['Age'] <= $alarmMaxTime )
			{
				echo "<script type=\"text/javascript\">addAlarm('otrsticket-".$ticket["TicketID"]."');</script>";
			}

			
			$output .= "<tr class=\"dashboard-severity-warning\">";
			$output .= "<td class=\"dashboard-nowrap\"><a href=\"$linkUrlBase/index.pl?Action=AgentTicketZoom;TicketID={$ticket['TicketID']}\" target=\"_blank\">{$ticket['TicketNumber']}</a></td>";
			$output .= "<td>{$ticket['Title']}</td>";
			$output .= "<td class=\"dashboard-nowrap\">(".$this->getAgeString($ticket['Age']).")</td>";
			$output .= "</tr>";
			$i++;
		}

		//output, if there are further tickets
		if(count($tickets) > $maxEntries)
		{
			$output .= "<tr class=\"dashboard-severity-warning\"><td colspan=\"3\">more tickets in configured queues...</td></tr>";
		}

		//output if no tickets were found
		if(count($tickets) <= 0)
		{
			$output .= "<tr class=\"dashboard-severity-cleared\"><td colspan=\"3\">no tickets in configured queues.</td></tr>";
		}

		//output footer
		$output .= "</table>";

		//return output
		return $output;
	}

	private function getAgeString($age)
	{
		$ageString = "$age sec";
		if($age > 60)
		{
			$ageString = round($age / 60) . " min";
		}
		if($age > 3600)
		{
			$ageString = round($age / 3600) . " h";
		}
		if($age > 86400)
		{
			$ageString = round($age / 86400) . " d";
		}
		return $ageString;
	}
}
?>
