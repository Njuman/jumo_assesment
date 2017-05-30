<?php

class countIterator extends reflectorAccessor implements IteratorInterface{
    
    public function iterate(array &$items, $key = '') {
		foreach ($items as $key => &$item) {
			if ($key === '_object_shift') {
				$item['_count'] = count($item['_data']);
            }

            $params = array_merge([&$item]);
			$this->callback($item, 'iterate' , $params);
		}
    }
}