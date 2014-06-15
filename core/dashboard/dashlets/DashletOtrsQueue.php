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
		$queue = $this->parameter->getValue("queue");
		$maxEntries = $this->parameter->getValue("maxEntries");
		$linkUrlBase = $this->parameter->getValue("linkUrlBase");
		
		//open connector
		$connector = new ConnectorOtrs($soapUrl, $soapUser, $soapPassword);

		//get ticketIDs
		$tickets = $connector->getTickets($queue, $maxEntries);

		//start output
		$output = "<h1>$title</h1>";
		$output .= "<table class=\"severity\">";

		//output of ticket summary
		foreach($tickets as $ticketId)
		{
			$ticket = $connector->getTicketSummary($ticketId);
			
			$output .= "<tr class=\"cleared\">";
			$output .= "<td><a href=\"$linkUrlBase/index.pl?Action=AgentTicketZoom;TicketID={$ticket['TicketID']}\">{$ticket['TicketNumber']}</a></td>";
			$output .= "<td>{$ticket['Title']}</td>";
			$output .= "<td>(".$this->getAgeString($ticket['Age']).")</td>";
			$output .= "</tr>";
		}

		//output if no tickets were found
		if(count($tickets) <= 0)
		{
			$output .= "<tr class=\"cleared\"><td colspan=\"3\">no tickets in $queue.</td></tr>";
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
