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
* yourDashboard HTML header
* @author: Michael Batz <michael@yourcmdb.org>
*/
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- bootstrap setup -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<!-- favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

		<!-- CSS: bootstrap, typeahead, smartmenues, bootstrap-datepicker and yourCMDB custom -->
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/yourdashboard.css" rel="stylesheet" />
		<?php
			foreach(getDashletCssFiles() as $cssFile)
			{
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/dashlets/$cssFile\" />";
			}
		?>


		<!-- JS: jQuery, bootstrap, typeahead, smartmenues, bootstrap-datepicker and yourCMDB custom -->
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/yourdashboard.js"></script>

		<title>yourDashboard</title>
	</head>
	<body>
		<noscript><p>You need to enable JavaScript for yourCMDB.</p></noscript>
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
