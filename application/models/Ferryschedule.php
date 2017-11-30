<?php

/**
 * Gets data about the ferry schedule from the ferryschedule.xml document

 */
class Ferryschedule extends CI_Model {

	private $xml;

	/**
	 * loads a simplexmlelement object from our xml file
	 */
	function __construct()
	{
		parent::__construct();
		$this->xml = simplexml_load_file("../data/ferryschedule.xml");
	}

	/**
	 * Returns all the ports from the xml file
	 * @return the ports
	 */
	function getPorts()
	{
		$ports = array();
		foreach ($this->xml->ports->children() as $port)
		{
			$ports[(string) $port['code']] = $port->__toString();
		}
		return $ports;
	}

	/**
	 * Finds all the sailings from the desired origin to the
	 * desired destination.
	 * @param type $origin the origin of the trip
	 * @param type $destination the trip destination
	 * @return string all of the sailings from origin to destination
	 */
	function findSailings($origin, $destination)
	{
		$result = array(); // the result array
		foreach ($this->xml->sailing as $sailing)
		{
			$depart = "";
			$arrive = "";
			$stops = "";
			if ($sailing['origin'] == $origin)
			{
				$depart = $sailing['depart'];
			}
			foreach ($sailing->stop as $stop)
			{
				if (empty($depart))
				{
					if ($stop['port'] == $origin)
					{
						$depart = $stop['depart'];
					}
				}
				if (!empty($depart))
				{
					if ($stop['port'] == $destination)
					{
						$arrive = $stop['arrive'];
						break;
					} else if ($stop['port'] != $origin)
					{
						$stops .= $stop['port'] . ",";
					}
				}
			}
			$stops = substr($stops, 0, strlen($stops) - 1);
			if (empty($arrive) && $sailing['destination'] == $destination)
			{
				$arrive = $sailing['arrive'];
			}
			if (empty($arrive) || empty($depart))
			{
				continue;
			}
			if ((int) $arrive >= 1300)
			{
				$numarrive = (int) $arrive;
				$numarrive -= 1200;
				$arrive = (string) $numarrive;
				$arrive = substr($arrive, 0, strlen($arrive) - 2)
						. ":" . substr($arrive, strlen($arrive) - 2, strlen($arrive))
						. " PM";
				if (strlen($arrive) == 7)
				{
					$arrive = "0" . $arrive;
				}
			} else
			{
				$arrive = substr($arrive, 0, 2)
						. ":" . substr($arrive, 2, 3) . " AM";
			}
			if ((int) $depart >= 1300)
			{
				$numdepart = (int) $depart;
				$numdepart -= 1200;
				$depart = (string) $numdepart;
				$depart = substr($depart, 0, strlen($depart) - 2)
						. ":" . substr($depart, strlen($depart) - 2, strlen($depart))
						. " PM";
				if (strlen($depart) == 7)
				{
					$depart = "0" . $depart;
				}
			} else
			{
				$depart = substr($depart, 0, 2)
						. ":" . substr($depart, 2, 3) . " AM";
			}
			$result[] = array('stops' => $stops, 'arrive' => $arrive, 'depart' => $depart);
		}
		return $result;
	}

}
