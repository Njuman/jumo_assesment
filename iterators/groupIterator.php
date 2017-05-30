<?php

class groupIterator implements IteratorInterface{

   public function iterate(array &$array, $key) {
		$_key = (is_array($key)) ? $key[0] : $key;

		$grouped = [];

		foreach ($array as $value) {
			$index = null;

			if (isset($value[$_key])) {
				$index = $value[$_key];
			}

			if ($index == null) {
				continue;
			}

			$grouped[$index]['_object_shift']['_data'][] = $value;
		}

		if (is_array($key) && count($key) > 1) {
			array_shift($key);

			foreach ($grouped as $nestedKey => $value) {
				$params = array_merge([&$value['_object_shift']['_data']], array($key));
				$grouped[$nestedKey] = call_user_func_array(array($this,'iterate'), $params);
			}
		}

    	return $grouped;
    }
}