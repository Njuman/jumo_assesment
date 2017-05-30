<?php 

class Aggregate {

    protected $array;

    protected $groupedByObjects;

    protected $groupByConditions;

    protected $sumIterator;

    protected $groupIterator;

    protected $countIterator;

    public function __construct(array $array, IteratorInterface $groupIterator, IteratorInterface $sumIterator, IteratorInterface $countIterator,
        renderIterator $renderIterator)
    {
        $this->array = $array;
        $this->groupIterator = $groupIterator;
        $this->sumIterator = $sumIterator;
        $this->countIterator = $countIterator;
        $this->renderIterator = $renderIterator;
    }

    public function groupBy($key) {
    	if (!is_string($key) && !is_array($key)) {
			trigger_error('groupBy(): The key should be a array or string', E_USER_ERROR);
			return null;
		}

		$this->groupByConditions = $key;
		
		$this->groupedByObjects = $this->groupIterator->iterate($this->array, $key);

		return $this;
    }

    public function sum($condition) {
    	$this->sumIterator->iterate($this->groupedByObjects, $condition);
    	return $this;
    }

    public function count() {
    	$this->countIterator->iterate($this->groupedByObjects);
    	return $this;
    }	

    public function render() {
        $response = $this->renderIterator->setCondition($this->groupByConditions)->iterate($this->groupedByObjects);
        return $response;
    }
}