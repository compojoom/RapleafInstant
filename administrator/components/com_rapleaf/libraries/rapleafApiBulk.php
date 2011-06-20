<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  Copyright 2011 Daniel Dimitrov. (http://compojoom.com)
 *  All rights reserved
 *
 *  This script is part of the Hotspots project. The Hotspots project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
/*
 * Copyright 2010 Rapleaf
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
/**
 * Note that an exception is raised in the case that
 * an HTTP response code other than 200 is sent back
 * The error code and error body are displayed
 */

class RapleafApiBulk {

	private static $BASE_PATH = "https://personalize.rapleaf.com/v4/bulk?api_key=";
	private static $handle;
	private static $API_KEY = "0bc82d24058fbbd4bfdee227c4a2db1a";

	public function __construct() {
		self::$handle = curl_init();
		curl_setopt(self::$handle, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt(self::$handle, CURLOPT_TIMEOUT, 2.0);
		curl_setopt(self::$handle, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt(self::$handle, CURLOPT_USERAGENT, "RapleafApi/PHP5/1.1");
		curl_setopt(self::$handle, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	}

	/**
	 * Pre: Path is an extension to personalize.rapleaf.com
	 * Note that an exception is raised if an HTTP response code
	 * other than 200 is sent back. In this case, both the error code
	 * the error code and error body are accessible from the exception raised
	 * 
	 * @param $body = array();
	 * @return json
	 */
	public function getJsonResponse($body = array()) {
		$url = self::$BASE_PATH . self::$API_KEY;
		curl_setopt(self::$handle, CURLOPT_URL, $url);
		curl_setopt(self::$handle, CURLOPT_POST, 1);
		curl_setopt(self::$handle, CURLOPT_POSTFIELDS, json_encode($body));
		$json_string = curl_exec(self::$handle);
		$response_code = curl_getinfo(self::$handle, CURLINFO_HTTP_CODE);

		if ($response_code < 200 || $response_code >= 300) {
			throw new Exception("Error Code: " . $response_code . "\nError Body: " . $json_string);
		} else {
			$personalization = json_decode($json_string, TRUE);
			return $personalization;
		}
	}

}
