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

/**
* yourDashboard bootstrap
* must be included
* @author Michael Batz <michael@yourcmdb.org>
*/

//define base directories
$scriptBaseDir = dirname(__FILE__);
$coreBaseDir = realpath("$scriptBaseDir");

//configure class loading
require_once "ClassLoader.php";
//class loading: yourDashboard
new ClassLoader("yourDashboard", "$coreBaseDir");
?>
