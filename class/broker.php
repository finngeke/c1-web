<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 13-07-2018
	 * Time: 14:19
	 */
	
	class broker {
		public static function post($data, $curlopt_url, $curlopt_port = 80) {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_PORT => $curlopt_port,
				CURLOPT_URL => $curlopt_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => array(
					"Content-Type: application/json"
				),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			if ($err) {
				throw new Exception($err);
			}
			curl_close($curl);
			return json_decode($response);
		}
	}