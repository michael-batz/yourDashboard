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
* dashlet for dashboard
* @author: Michael Batz <michael@yourcmdb.org>
*/
abstract class Dashlet
{

	//dashlet parameters
	private $parameter;

	/**
	* Create a new dashlet
	* @param $parameter	dashlet parameter
	*/
	function __construct(DashletParameter $parameter)
	{
		$this->parameter = $parameter;
	}

	/**
	* generate HTML output of dashlet
	*/
	abstract public function render();

}
?>
