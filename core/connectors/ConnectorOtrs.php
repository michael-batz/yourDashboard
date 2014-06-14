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

	//soap client
	private $soapClient;

	function __construct($soapUrl, $soapUser, $soapPassword)
	{
		$this->soapUrl = $soapUrl;
		$this->soapUser = $soapUser;
		$this->soapPassword = $soapPassword;

		//create soapClient with user credentials
		$soapOptions = Array(	"location" 	=> $soapUrl, 
					"uri" 		=> "urn:otrs-com:soap:functions");
		$this->soapClient = new SoapClient(null, $soapOptions);
	}


	/**
	* Gets tickets from OTRS
	* @param $resource resource
	*/
	public function getTickets($queue)
	{
		//define request
		$soapMessage = Array();
		$soapMessage[] = new SoapParam($this->soapUser, "UserLogin");
		$soapMessage[] = new SoapParam($this->soapPassword, "Password");
		$soapMessage[] = new SoapParam("ARRAY", "Result");
		$soapMessage[] = new SoapParam(10, "Limit");

		//soap call
		$result = $this->soapClient->__soapCall("TicketSearch", $soapMessage);

		return $result;
	}

}
?>
