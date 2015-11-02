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
namespace yourDashboard\connectors;

use \SoapClient;
use \SoapParam;

/**
* connector to OTRS
* @author: Michael Batz <michael@yourcmdb.org>
*/
class ConnectorOtrs
{

	//base URL for the OTRS SOAP API
	private $soapUrl;

	//user for the OTRS SOAP API
	private $soapUser;

	//password for the OTRS SOAP API
	private $soapPassword;

	//soap options
	private $soapOptions;

	function __construct($soapUrl, $soapUser, $soapPassword)
	{
		$this->soapUrl = $soapUrl;
		$this->soapUser = $soapUser;
		$this->soapPassword = $soapPassword;
		$this->soapOptions = Array(	"location" 	=> $soapUrl, 
						"uri" 		=> "urn:otrs-com:soap:functions");
	}


	/**
	* Gets tickets from OTRS
	* @param $queues array of queues to get tickets
	* @param $states array of ticket states to search
	* @param $limit max count of output entries
	* @return array with ticketIDs
	*/
	public function getTickets($queues, $states, $limit)
	{
		//soap call to get all new or open tickets of queue $queue
		$soapClient = new SoapClient(null, $this->soapOptions);
		$soapMessage = Array();
		$soapMessage[] = new SoapParam($this->soapUser, "UserLogin");
		$soapMessage[] = new SoapParam($this->soapPassword, "Password");
		$soapMessage[] = new SoapParam("ARRAY", "Result");
		$soapMessage[] = new SoapParam($limit, "Limit");
		foreach($queues as $queue)
		{
			$soapMessage[] = new SoapParam($queue, "Queues");
		}
		foreach($states as $state)
		{
			$soapMessage[] = new SoapParam($state, "States");
		}
		$soapMessage[] = new SoapParam("unlock", "Locks");
		$soapMessage[] = new SoapParam("Down", "OrderBy");
		$soapMessage[] = new SoapParam("Age", "SortBy");
		//returns a single ticketId or an array of ticketIds, if multiple tickets were found
		$tickets = $soapClient->__soapCall("TicketSearch", $soapMessage);

		//check if ticket is array
		if(is_array($tickets))
		{
			return $tickets['TicketID'];
		}
		elseif($tickets != null)
		{
			return array($tickets);
		}
		else
		{
			return array();
		}
	}

	public function getTicketSummary($ticketId)
	{
		//soap call: get ticket
		$soapClient = new SoapClient(null, $this->soapOptions);
		$soapMessage = Array();
		$soapMessage[] = new SoapParam($this->soapUser, "UserLogin");
		$soapMessage[] = new SoapParam($this->soapPassword, "Password");
		$soapMessage[] = new SoapParam($ticketId, "TicketID");
		$ticket = $soapClient->__soapCall("TicketGet", $soapMessage);

		//generate output array
		$output = Array();
		$output['TicketNumber'] = $ticket->TicketNumber;
		$output['Title'] = $ticket->Title;
		$output['TicketID'] = $ticket->TicketID;
		$output['Age'] = $ticket->Age;
		return $output;
	}
}
?>
