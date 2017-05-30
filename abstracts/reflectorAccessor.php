<?php 

class reflectorAccessor {
	
	protected function callback($item, $func, $params) {
    	if (is_array($item)) {
			call_user_func_array(array($this, $func), $params);
    	}
    }
}