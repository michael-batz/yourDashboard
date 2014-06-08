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
		$outagesCategory = $this->parameter->getValue("outagesCategory");
		
		//open connector
		$connector = new ConnectorOpenNMS($restUrl, $restUser, $restPassword);

		//get current outages as SimpleXmlObject
		$outagesXml = simplexml_load_string($connector->getData("outages?ifRegainedService=null&orderBy=ifLostService&order=desc"));

		//if outagesCategory is defined, get all nodes of category
		if($outagesCategory != "")
		{
			//get all nodes
			$nodeFilter = Array();
			$nodesXml = simplexml_load_string($connector->getData("nodes?limit=0"));
			foreach($nodesXml->xpath('//node') as $node)
			{
				//check categories of the node
				foreach($node->categories as $category)
				{
					//if node is in category defined in $outagesCategory
					$nodeCategoryName = (string) $category["name"];
					if($nodeCategoryName == $outagesCategory)
					{
						//add node to filter
						$nodeId = (string)$node["id"];
						$nodeFilter[] = $nodeId;
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
		$output .= "<table>";
		foreach($outagesRecord as $outage)
		{
			switch($outage["type"])
			{
				case "nodeDown":
					$output .= "<tr class=\"critical\"><td>{$outage['nodelabel']}</td></tr>";
					break;

				case "interfaceDown":
					$output .= "<tr class=\"major\"><td>{$outage['nodelabel']}</td></tr>";
					break;

				case "nodeLostService":
					$output .= "<tr class=\"minor\"><td>{$outage['nodelabel']}</td></tr>";
					break;
			}
		}

		$output  .= "</table>";

		//return output
		return $output;
	}

}
?>
