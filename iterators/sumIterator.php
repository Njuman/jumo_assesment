<?php

class sumIterator extends reflectorAccessor implements IteratorInterface{


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