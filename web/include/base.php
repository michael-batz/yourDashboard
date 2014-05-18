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
* base functions
* @author: Michael Batz <michael@yourcmdb.org>
*/

/**
* autoloading of classes
*/
function __autoload($className)
{
	$scriptBaseDir = dirname(__FILE__);
	$coreBaseDir = realpath("$scriptBaseDir/../../core");
	$paths = array('', 'dashboard', 'dashboard/dashlets', 'config', 'controller');
	$filename = $className.'.php';
	foreach($paths as $path)
	{
		if(file_exists("$coreBaseDir/$path/$filename"))
		{
			include "$coreBaseDir/$path/$filename";
		}
	}
}

/**
* gets an HTTP GET variable or returns a default value
*/
function getHttpGetVar($variableName, $defaultValue)
{
	if(isset($_GET["$variableName"]))
	{
		return $_GET["$variableName"];
	}
	else
	{
		return $defaultValue;
	}
}

/**
* gets an HTTP POST variable or returns a default value
*/
function getHttpPostVar($variableName, $defaultValue)
{
	if(isset($_POST["$variableName"]))
	{
		return $_POST["$variableName"];
	}
	else
	{
		return $defaultValue;
	}
}
?>
