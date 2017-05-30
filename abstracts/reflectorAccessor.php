<?php 

/**
 * This class abstract functions that are used by multiple classes
 */
class reflectorAccessor {
	
	/**
     * Used to invoke inheritant function while $item is still an array
     * @param array $item
     * @param string $func
     * @param array $params
     */
	protected function callback($item, $func, $params) {
    	if (is_array($item)) {
			call_user_func_array(array($this, $func), $params);
    	}
    }
}