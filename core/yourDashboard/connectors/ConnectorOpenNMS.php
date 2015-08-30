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

/**
* connector to OpenNMS
* @author: Michael Batz <michael@yourcmdb.org>
*/
class ConnectorOpenNMS
{

	//base URL for the OpenNMS REST API
	private $restUrl;

	//user for the OpenNMS REST API
	private $restUser;

	//password for the OpenNMS REST API
	private $restPassword;

	function __construct($restUrl, $restUser, $restPassword)
	{
		$this->restUrl = $restUrl;
		$this->restUser = $restUser;
		$this->restPassword = $restPassword;
	}


	/**
	* Gets data from OpenNMS REST API
	* @param $resource resource
	* @returns String with XML data that were returned or FALSE if there was an error
	*/
	public function getData($resource)
	{
		//curl request
		$curl = curl_init();
		$curlOptions = array(
		CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
		CURLOPT_USERPWD => "{$this->restUser}:{$this->restPassword}",
		CURLOPT_URL => "{$this->restUrl}/{$resource}",
		CURLOPT_SSL_VERIFYPEER	=> FALSE,
		CURLOPT_RETURNTRANSFER => true);
		curl_setopt_array($curl, $curlOptions);
		$result = curl_exec($curl);
		$curlHttpResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		//error handling
		if($result == false)
		{
			return false;
		}
		//check HTTP response code and return result
		if($curlHttpResponse == "200" || $curlHttpResponse == "303")
		{
			return $result;
		}
		return false;
	}

}
?>
