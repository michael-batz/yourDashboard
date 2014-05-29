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
* dashboard configuration - reads xml configuration and generate dashboards
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashboardConfig
{

	//array of dashboard objects (name -> dashboard object)
	private $dashboards;

	/**
	* Creates a dashboard configuration object
	*/
	function __construct($xmlfilename)
	{
		$this->dashboards = Array();

		//read xml file and generate objects
		$xmlobject = simplexml_load_file($xmlfilename);

		//go through all dashboard sections
		foreach($xmlobject->xpath('//dashboard')  as $dashboard)
		{
			//save dashboard name
			$dashboardName = (string)$dashboard['name'];

			//generate dashlets and rows
			$dashboardDashlets = Array();
			foreach($dashboard->row as $row)
			{
				$dashboardDashletsRow = Array();
				foreach($row->dashlet as $dashlet)
				{
					//save class
					$dashletClass = (string)$dashlet['class'];

					//save refresh interval
					$dashletRefresh = (string)$dashlet['refresh'];
					
					//save parameters
					$dashletParameter = new DashletParameter();
					foreach($dashlet[0]->parameter as $parameter)
					{
						$key = (string)$parameter['key'];
						$value = (string)$parameter['value'];
						$dashletParameter->addEntry($key, $value);
					}

					//create dashlet
					if(class_exists($dashletClass))
					{
						$dashboardDashletsRow[] = new $dashletClass($dashletRefresh, $dashletParameter);
					}
					else
					{
						$dashletParameter = new DashletParameter();
						$dashletParameter->addEntry("message", "Dashlet class not found");
						$dashboardDashletsRow[] = new DashletError($dashletRefresh, $dashletParameter);
					}
				}
				$dashboardDashlets[] = $dashboardDashletsRow;
			}

			//generate and save dashboard object
			$this->dashboards[$dashboardName] = new Dashboard($dashboardName, $dashboardDashlets);
		}
	}


	/**
	* return dashboard object for the given name
	* @param $name		name of the dashboard
	*/
	public function getDashboard($name)
	{
		if(isset($this->dashboards[$name]))
		{
			return $this->dashboards[$name];
		}
		else
		{
			throw new DashboardException("Dashboard $name not found");
		}
	}

	/**
	* return the names of all configured dashboards
	*/
	public function getDashboardNames()
	{
		return array_keys($this->dashboards);
	}
}
?>
