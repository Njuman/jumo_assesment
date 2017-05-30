<?php 

/**
 * Iterator Interface
 */
interface IteratorInterface {

	/**
     * Invoke the resolved callable.
     * @param array $items
     * @param array $key
     * @return callable
     */
	public function iterate(array &$items, $key);
}