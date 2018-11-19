<?php

/**
 * This class contains iterate functions thats used to go through Grouped array object
 */
class renderIterator extends reflectorAccessor
{

    /**
     * The response
     * Single dimensional array that has been processed as result set
     * @var array
     */
    private $response;

    /**
     * The response
     * Array of elements that contains fields that which will be used for filtering the Array
     * @var array
     */
    private $conditions;

    /**
     * Set conditions value
     * @param string $conditions
     * @return renderIterator
     */
    public function setCondition($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * Set ActionDate value
     * @param array $items
     * @param int $count
     * @return Array
     */
    public function iterate(array &$items, &$count = 1)
    {

        if (!isset($this->conditions)) {
            trigger_error('renderIterator->iterate(): please make sure filter conditions are set by calling setCondition', E_USER_ERROR);
            return null;
        }

        // setting headers
        $this->response[0] = $this->conditions;

        // hack this should be done in the inner loop, but would have to be passed by reference for that to be achieved
        $this->response[0][] = 'Count';
        $this->response[0][] = 'Sum';

        foreach ($items as $key => $item) {
            if ($key === '_object_shift') {
                foreach ($this->conditions as $value) {
                    $this->response[$count][$value] = $item['_data'][0][$value];
                }

                if (isset($item['_sum'])) {
                    $this->response[$count]['sum'] = $item['_sum'];
                }

                if (isset($item['_count'])) {
                    $this->response[$count]['count'] = $item['_count'];
                }

                $count++;
            }

            $params = array_merge([&$item], [&$count]);

            $this->callback($item, 'iterate', $params);
        }

        return $this->response;
    }
}