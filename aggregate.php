<?php

/**
 * This class contains aggregation functions used for aggregating arrays
 */
class Aggregate
{

    /**
     * The array
     * Array that will be aggregated
     * - minOccurs: 1
     * @var array
     */
    protected $array;
    /**
     * The groupedByObjects
     * Array of elements that has been processed by groupBy function
     * @var array
     */
    protected $groupedByObjects;
    /**
     * The groupByConditions
     * Array of elements that contains fields that which will be used for filtering the Array
     * @var array
     */
    protected $groupByConditions;
    /**
     * The sumIterator
     * Instance of the sumIterator class
     * @var array
     */
    protected $sumIterator;
    /**
     * The groupIterator
     * Instance of the groupIterator class
     * @var array
     */
    protected $groupIterator;
    /**
     * The countIterator
     * Instance of the countIterator class
     * @var array
     */
    protected $countIterator;

    /**
     * Constructor method for Aggregate
     * @uses Aggregate::setGroupIterator()
     * @uses Aggregate::setSumIterator()
     * @uses Aggregate::setCountIterator()
     * @uses Aggregate::setRenderIterator()
     * @param array $array
     * @param IteratorInterface $groupIterator
     * @param IteratorInterface $sumIterator
     * @param IteratorInterface $countIterator
     * @param IteratorInterface $renderIterator
     */
    public function __construct(array $array, IteratorInterface $groupIterator, IteratorInterface $sumIterator, IteratorInterface $countIterator,
                                renderIterator $renderIterator)
    {
        $this->array = $array;

        $this->setGroupIterator($groupIterator)
            ->setSumIterator($sumIterator)
            ->setCountIterator($countIterator)
            ->setRenderIterator($renderIterator);
    }

    /**
     * Groups Array By $key condition
     * @param Array $key
     * @return Aggregate
     */
    public function groupBy($key)
    {
        if (!is_string($key) && !is_array($key)) {
            trigger_error('groupBy(): The key should be a array or string', E_USER_ERROR);
            return null;
        }

        $this->groupByConditions = $key;

        $this->groupedByObjects = $this->groupIterator->iterate($this->array, $key);

        return $this;
    }

    /**
     * Sum aggregate Array By variable "$condition" condition
     * @param Array $condition
     * @return Aggregate
     */
    public function sum($condition)
    {
        $this->sumIterator->iterate($this->groupedByObjects, $condition);
        return $this;
    }

    /**
     * Counts aggregate data from $groupedByObjects
     * @return Aggregate
     */
    public function count()
    {
        $this->countIterator->iterate($this->groupedByObjects);
        return $this;
    }

    /**
     * Renders aggregate data from $groupedByObjects into a single dimensional array
     * @return Array
     */
    public function render()
    {
        $response = $this->renderIterator->setCondition($this->groupByConditions)->iterate($this->groupedByObjects);
        return $response;
    }

    /**
     * Sets the local variable $groupIterator using instance of IteratorInterface
     * @param IteratorInterface $groupIterator
     * @return Array
     */
    public function setGroupIterator(IteratorInterface $groupIterator)
    {
        $this->groupIterator = $groupIterator;
        return $this;
    }

    /**
     * Sets the local variable $sumIterator using instance of IteratorInterface
     * @param IteratorInterface $sumIterator
     * @return Array
     */
    public function setSumIterator(IteratorInterface $sumIterator)
    {
        $this->sumIterator = $sumIterator;
        return $this;
    }

    /**
     * Sets the local variable $countIterator using instance of IteratorInterface
     * @param IteratorInterface $countIterator
     * @return Array
     */
    public function setCountIterator(IteratorInterface $countIterator)
    {
        $this->countIterator = $countIterator;
        return $this;
    }

    /**
     * Sets the local variable $renderIterator using instance of IteratorInterface
     * @param IteratorInterface $renderIterator
     * @return Array
     */
    public function setRenderIterator(renderIterator $renderIterator)
    {
        $this->renderIterator = $renderIterator;
        return $this;
    }
}