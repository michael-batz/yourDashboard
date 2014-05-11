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
* yourDashboard main page
* @author: Michael Batz <michael@yourcmdb.org>
*/

//load base functions and header
require("include/base.php");
require("include/header.inc.php");

//open dashboard
$controller = new Controller();
$dashboard = $controller->getDashboardObject();

//render dashboard
$dashboard->render();

//load footer
require("include/footer.inc.php");

?>
