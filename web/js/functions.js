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

//definition of functions

/**
* Loads the content of a dashlet
*/
function loadDashlet(dashboardname, dashletRow, dashletid)
{
	$( "#dashlet-" + dashletRow + "-" + dashletid ).load("ajax.php?content=dashlet&dashboard=" + dashboardname  + "&row=" + dashletRow  + "&id=" + dashletid);
};

/**
* Starts the dashlet loader
* loads dashlet for the first time
* reloads the content every interval milliseconds
*/
function startDashletLoader(dashboardname, dashletRow, dashletid, interval)
{
	//load dashlet for the first time
	loadDashlet(dashboardname, dashletRow, dashletid);

	//set up reloading of dashlet
	$( window  ).load(function()
	{
		window.setInterval(function() {loadDashlet(dashboardname, dashletRow, dashletid)}, interval);
	});
};

/**
* adds an alarm with given ID to alarm store
*/
function addAlarm(id)
{
	//check if alarm already is in store
	var alarms = document.cookie;
	if(alarms.indexOf(id + "=") < 0)
	{
		//if not: set cookie and play alarm sound
		document.cookie = id + "=true";
		document.getElementById('dashboard-AlarmAudio').play();
	}
}
