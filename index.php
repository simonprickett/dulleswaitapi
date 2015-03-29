<?php
/*
 * Washington Dulles Security Wait Time API.
 * 
 * Simple security wait time API that scrapes the MWAA mobile web
 * page and reports on how long in minutes you can expect to spend 
 * passing through security at each of the two checkpoints.
 *
 * Author: Simon Prickett (http://simonprickett.github.io/)
 *
 * You are free to use this and modify it as you like, but I'd be 
 * interested in knowing what anyone does with it.
 *
 */

// Go get the page
$iadUrl = 'http://www.mwaa.com/mobile/IAD/IADWaitTime.html';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $iadUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

$pageHtml = curl_exec($ch);
curl_close($ch);

// Now parse it
$dom = new DOMDocument();
$dom->loadHTML($pageHtml);

// Get the wait times
$eastWait = -1;
$westWait = -1;
$spans = $dom->getElementsByTagName('span');
foreach($spans as $span) {
	$pos = strpos($span->nodeValue, 'minute');

	if ($pos > 0) {
		// -2 gets rid of the &nbsp;
		$waitTime = trim(substr($span->nodeValue, 0, $pos - 2));
		if ($eastWait === -1) {
			$eastWait = $waitTime;
		} else {
			$westWait = $waitTime;
		}
	}
}

// Get the last updated time
$paras = $dom->getElementsByTagName('p');
$lastUpdated = '';

foreach($paras as $para) {
	if (strpos($para->nodeValue, '* Last updated at') !== false) {
		// 19 = length of * Last updated at plus 2 for the &nbsp;
		$lastUpdated = trim(substr($para->nodeValue, 19));
		break;
	}
}

// Time zone
$dt = new DateTime($lastUpdated, new DateTimeZone('America/New_York'));

$jsonOut = '{ "airports": [ { "iata": "IAD", "name" : "Washington Dulles", "lastUpdated": "' . $lastUpdated . '", "lastUpdatedTimestamp": ' . $dt->getTimestamp() . ', "checkpoints": [ { "name": "East", "wait" : ' . $eastWait . ' }, { "name": "West", "wait" : ' . $westWait . ' } ] } ] }';

// Send the response with appropriate content type
header('Content-Type: application/json');
print $jsonOut;
?>