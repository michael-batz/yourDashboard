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

		$return = $connector->getTickets($queue);

		//generate output
		$output = htmlspecialchars(print_r($return, true));

		//return output
		return $output;
	}

}
?>
