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
function loadDashlet(dashboardname, dashletid)
{
	$( "#dashlet-" + dashletid ).load("ajax.php?content=dashlet&dashboard=" + dashboardname  + "&id=" + dashletid);
};

/**
* Starts the dashlet loader
* loads dashlet for the first time
* reloads the content every interval milliseconds
*/
function startDashletLoader(dashboardname, dashletid, interval)
{
	//load dashlet for the first time
	loadDashlet(dashboardname, dashletid);

	//set up reloading of dashlet
	window.setInterval(function() {loadDashlet(dashboardname, dashletid)}, interval);
};
