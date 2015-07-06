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
* yourDashboard HTML header
* @author: Michael Batz <michael@yourcmdb.org>
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>yourDashboard</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
		<script src="js/functions.js" type="text/javascript"></script>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<link rel="stylesheet" type="text/css" href="css/default.css" />
		<?php
			foreach(getDashletCssFiles() as $cssFile)
			{
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/dashlets/$cssFile\" />";
			}
		?>
	</head>
	<body>
		<?php
			//alarm handling
			if($alarmConfig->isEnabled())
			{
				$alarmSoundfile =  $alarmConfig->getSoundfile();
				echo "<audio id=\"dashboard-AlarmAudio\" src=\"$alarmSoundfile\" preload=\"auto\"></audio>";
			}
			
			//show header
			if($customizingConfig->getShowHeader())
			{?>
				<div class="header">
					<h1>
						<img src="<?php echo $customizingConfig->getLogo(); ?>" alt="logo" />
						<?php echo $customizingConfig->getTitle(); ?>
					</h1>
				</div>
			<?php
			}

			//show dashboard selector
			if($customizingConfig->getShowSelector())
			{?>
				<div class="dashboardSelector">
					<form name="dashboardSelector" action="index.php" method="get">
					Dashboard:
					<select name="dashboard" onchange="javascript:document.forms['dashboardSelector'].submit()">
						<?php
							foreach($dashboardConfig->getDashboardNames() as $allDashboardsName)
							{
								if($allDashboardsName == $dashboardName)
								{
									echo "<option selected=\"selected\">$allDashboardsName</option>";
								}
								else
								{
									echo "<option>$allDashboardsName</option>";
								}
							}
							?>
						</select>
					</form>
				</div>
			<?php
			}?>
