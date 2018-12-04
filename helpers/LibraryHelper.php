<?php
	
	class LibraryHelper {
		public static function convertNumber($value) {
			if (!is_numeric($value)) {
				$value = str_replace(",", ".", str_replace(".", "", $value));
			}
			return floatval($value);
		}
		
		public static function cleanText($texto) {
			$texto = preg_replace('/\s+/', ' ', $texto);
			$texto = preg_replace('/\s\./', '.', $texto);
			$texto = preg_replace('/\.+/', '.', $texto);
			$texto = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($texto));
			return $texto;
		}
		
		public static function getColumnNameFromNumber($num) {
			$numeric = ($num - 1) % 26;
			$letter = chr(65 + $numeric);
			$num2 = intval(($num - 1) / 26);
			if ($num2 > 0) {
				return LibraryHelper::getColumnNameFromNumber($num2) . $letter;
			} else {
				return $letter;
			}
		}
		
		public static function validateDate($date, $format = 'Y-m-d') {
			$d = DateTime::createFromFormat($format, $date);
			return $d && $d->format($format) === $date;
		}
		
		public static function toDate($date, $format = 'Y-m-d') {
			if (validateDate($date, $format)) {
				return DateTime::createFromFormat($format, $date);
			}
			return null;
		}
		
		public static function guid() {
			/*if (function_exists('com_create_guid') === true)
			{
				return trim(com_create_guid(), '{}');
			}*/
			return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
		}
		
		public static function array_to_xml($array, &$data, $tag = "item") {
			foreach ($array as $key => $value) {
				if (is_array($value)) {
					$node = $data->addChild("$tag");
					self::array_to_xml($value, $node, $key);
				} else {
					$data->addChild("$key", htmlspecialchars("$value"));
				}
			}
		}
	}