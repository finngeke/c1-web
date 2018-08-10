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
	}