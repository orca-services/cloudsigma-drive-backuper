<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * A common base for object lists.
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
abstract class BaseObjectList {
	/**
	 * The object list meta data.
	 *
	 * @var array
	 */
	protected $_meta;

	/**
	 * The object list.
	 *
	 * @var array
	 */
	protected $_objects;

	/**
	 * Sets the object list.
	 *
	 * @param array $objectList The object list.
	 */
	public function __construct($objectList) {
		if (isset($objectList['meta'])) {
			$this->_meta = $objectList['meta'];
		}
		if (isset($objectList['objects'])) {
			$this->_objects = $objectList['objects'];
		}
	}

	/**
	 * Return the fist object data array.
	 *
	 * @return array The data array of the first object.
	 */
	protected function _first() {
		return reset($this->_objects);
	}
}
