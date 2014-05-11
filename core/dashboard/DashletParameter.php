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
* Parameter for dashlet
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletParameter
{

	//parameter array
	private $parameter;

	function __construct()
	{
		$this->parameter = Array();
	}

	public function getKeys()
	{
		return array_keys($this->parameter);
	}

	public function getValue($key)
	{
		return $this->parameter[$key];
	}
	
	public function addEntry($key, $value)
	{
		$this->parameter[$key] = $value;
	}

}
?>
