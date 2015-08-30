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
namespace yourDashboard\dashboard\dashlets;

use yourDashboard\dashboard\Dashlet;
use yourDashboard\connectors\ConnectorOpenNMS;

/**
* dashlet to show OpenNMS outages
* @author: Michael Batz <michael@yourcmdb.org>
*/
class DashletOpenNMSOutages extends Dashlet
{

	public function getHtmlContentString()
	{
		//get parameters
		$title = $this->parameter->getValue("title");
		$restUrl = $this->parameter->getValue("restUrl");
		$restUser = $this->parameter->getValue("restUser");
		$restPassword = $this->parameter->getValue("restPassword");
		$outagesCategory = $this->parameter->getValueArray("outagesCategory");
		$maxEntries = $this->parameter->getValue("maxEntries");
		$linkUrlBase = $this->parameter->getValue("linkUrlBase");
		$createAlarms = $this->parameter->getValue("createAlarms");
		$alarmMinTime = $this->parameter->getValue("alarmMinTime");
		$alarmMaxTime = $this->parameter->getValue("alarmMaxTime");

		//set default values
		if($alarmMinTime == "")
		{
			$alarmMinTime = 0;
		}
		if($alarmMaxTime == "")
		{
			$alarmMaxTime = 300;
		}
		
		//open connector
		$connector = new ConnectorOpenNMS($restUrl, $restUser, $restPassword);

		//get current outages as SimpleXmlObject
		$outagesXml = simplexml_load_string($connector->getData("outages?ifRegainedService=null&orderBy=ifLostService&order=desc&limit=0"));
		if($outagesXml === FALSE)
		{
			throw new DashletException("Error connecting to OpenNMS");
		}

		//if outagesCategory is defined, get all nodes of category
		if(count($outagesCategory) > 0)
		{
			//get all nodes
			$nodeFilter = Array();
			$nodesXml = simplexml_load_string($connector->getData("nodes?limit=0"));
			if($nodesXml === FALSE)
			{
				throw new DashletException("Error connecting to OpenNMS");
			}

			foreach($nodesXml->xpath('//node') as $node)
			{
				//check categories of the node
				foreach($node->categories as $category)
				{
					//if node is in category defined in $outagesCategory
					$nodeCategoryName = (string) $category["name"];
					if(array_search($nodeCategoryName, $outagesCategory) !== FALSE)
					{
						//add node to filter
						$nodeId = (string)$node["id"];
						$nodeFilter[] = $nodeId;
						continue 2;
					}
				}
			}
			
		}

		//create outage array
		$outagesRecord = Array();
		foreach($outagesXml->xpath('//outage') as $outage)
		{
			$outageId = (string) $outage['id'];
			$outageNodeId = (string) $outage->serviceLostEvent[0]->nodeId[0];
			$outageNode = (string) $outage->serviceLostEvent[0]->nodeLabel[0];
			$outageUei = (string) $outage->serviceLostEvent[0]->uei[0];
			$outageTimestamp = strtotime((string) $outage->serviceLostEvent[0]->time[0]);

			//if nodeFilter is defined and node is not in filter -> go to the next outage
			if(isset($nodeFilter) && array_search($outageNodeId, $nodeFilter) === FALSE)
			{
				continue;
			}

			switch($outageUei)
			{
				case "uei.opennms.org/nodes/nodeDown":
					//show only one record per node
					if(	isset($outagesRecord[$outageNodeId]["timestamp"]) && 
						$outagesRecord[$outageNodeId]["timestamp"] >= $outageTimestamp &&
						$outagesRecord[$outageNodeId]["type"] == "nodeDown")
					{
						break;
					}
					$outagesRecord[$outageNodeId] = array("id" => $outageId, "nodelabel" => $outageNode, "timestamp" => $outageTimestamp, "type" => "nodeDown");
					break;
				case "uei.opennms.org/nodes/interfaceDown":
					//show only one record per node
					if(	isset($outagesRecord[$outageNodeId]["timestamp"]) && 
						($outagesRecord[$outageNodeId]["type"] == "nodeDown" || 
						($outagesRecord[$outageNodeId]["type"] == "interfaceDown" && $outagesRecord[$outageNodeId]["timestamp"] >= $outageTimestamp)))
					{
						break;
					}
					$outagesRecord[$outageNodeId] = array("id" => $outageId, "nodelabel" => $outageNode, "timestamp" => $outageTimestamp, "type" => "interfaceDown");
					break;
				case "uei.opennms.org/nodes/nodeLostService":
					//show only one record per node
					if(    	isset($outagesRecord[$outageNodeId]["timestamp"]) &&
						($outagesRecord[$outageNodeId]["type"] != "nodeLostService" || 
						($outagesRecord[$outageNodeId]["type"] == "nodeLostService" && $outagesRecord[$outageNodeId]["timestamp"] >= $outageTimestamp)))
					{
						break;
					}
					$outagesRecord[$outageNodeId] = array("id" => $outageId, "nodelabel" => $outageNode, "timestamp" => $outageTimestamp, "type" => "nodeLostService");
					break;

			}
		}

		//generate output
		$output = "";
		$output .= "<h1>$title</h1>";
		$output .= "<table class=\"severity\">";
		$i = 0;
		//if there are no outages
		if(count($outagesRecord) <= 0)
		{
			$output .= "<tr class=\"cleared\"><td colspan=\"2\">no outages</td></tr>";
		}
		foreach($outagesRecord as $outage)
		{
			//check, if output is too long
			if($maxEntries != "" && $i >= $maxEntries)
			{
				break;
			}

			//calculate outage interval
			$outageInterval = time() - $outage["timestamp"];

			//create alarm if configured for every outage in the given interval
			if($createAlarms == "true" && $outageInterval >= $alarmMinTime && $outageInterval <= $alarmMaxTime )
			{
				echo "<script type=\"text/javascript\">addAlarm('outage-".$outage["id"]."');</script>";
			}

			//define outageIntervalString
			$outageIntervalString = "$outageInterval sec";
			if($outageInterval > 60)
			{
				$outageIntervalString = round($outageInterval / 60) . " min";
			}
			if($outageInterval > 3600)
			{
				$outageIntervalString = round($outageInterval / 3600) . " h";
			}
			if($outageInterval > 86400)
			{
				$outageIntervalString = round($outageInterval / 86400) . " d";
			}

			//create output
			switch($outage["type"])
			{
				case "nodeDown":
					$output .= "<tr class=\"major\"><td><a href=\"$linkUrlBase/element/nodeList.htm?nodename={$outage['nodelabel']}\" target=\"_blank\">{$outage['nodelabel']}</a></td>";
					$output .= "<td>($outageIntervalString)</td></tr>";
					break;

				case "interfaceDown":
					$output .= "<tr class=\"minor\"><td><a href=\"$linkUrlBase/element/nodeList.htm?nodename={$outage['nodelabel']}\" target=\"_blank\">{$outage['nodelabel']}</a></td>";
					$output .= "<td>($outageIntervalString)</td></tr>";
					break;

				case "nodeLostService":
					$output .= "<tr class=\"warning\"><td><a href=\"$linkUrlBase/element/nodeList.htm?nodename={$outage['nodelabel']}\" target=\"_blank\">{$outage['nodelabel']}</a></td>";
					$output .= "<td>($outageIntervalString)</td></tr>";
					break;
			}
			
			$i++;
		}


		//message, if output was too long
		if($maxEntries != "" && count($outagesRecord) > $maxEntries)
		{
			$countMissing = count($outagesRecord) - $maxEntries;
			$output .= "<tr class=\"major\"><td colspan=\"2\">$countMissing more nodes with outages...</td></tr>";
		}

		$output  .= "</table>";

		//return output
		return $output;
	}

}
?>
