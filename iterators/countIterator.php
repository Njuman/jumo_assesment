<?php

/**
 * This class contains iterate functions that create the count for aggregated fields
 */
class countIterator extends reflectorAccessor implements IteratorInterface
{

    /**
     * iterator function used when counting aggregated fields, passes $item by reference
     * @param array $items
     * @param string $key
     */
    public function iterate(array &$items, $key = '')
    {
        foreach ($items as $key => &$item) {
            if ($key === '_object_shift') {
                $item['_count'] = count($item['_data']);
            }

            $params = array_merge([&$item]);
            $this->callback($item, 'iterate', $params);
        }
    }
}