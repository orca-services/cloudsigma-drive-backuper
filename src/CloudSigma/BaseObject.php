<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * A common base for all objects in CloudSigma
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class BaseObject {

	/**
	 * The object data array.
	 *
	 * @var array
	 */
	protected $_objectData;

	/**
	 * Set the object data.
	 *
	 * @param array $objectData The object data.
	 */
	function __construct($objectData) {
		$this->_objectData = $objectData;
	}

	/**
	 * Returns the UUID.
	 *
	 * @return string The UUID.
	 */
	public function getUuid() {
		return $this->_objectData['uuid'];
	}
}