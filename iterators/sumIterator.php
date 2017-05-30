<?php

/**
 * This class contains iterate functions thats used to go through Grouped array object and implements IteratorInterface
 */
class sumIterator extends reflectorAccessor implements IteratorInterface{

    /**
     * iterator function used when calculating the sum of aggregated items based on $condition
     * @param array $items
     * @param array $condition
     */
    public function iterate(array &$items, $condition) {
    	foreach ($items as $key => &$item) {

    		if ($key === '_object_shift') {
    			$total = 0;

    			foreach ($item['_data'] as $key => $value) {
    				$total += $value[$condition];
    			}
					
				$item['_sum'] = $total;
    		}

    		$params = array_merge([&$item], [$condition]);
    		$this->callback($item, 'iterate' , $params);
    	}
    }
}