<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Class DriveList
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class DriveList {

	/**
	 * The drive list meta data.
	 *
	 * @var array
	 */
	protected $_meta;

	/**
	 * The drive list objects.
	 *
	 * @var array
	 */
	protected $_objects;

	/**
	 * Sets the drive list.
	 *
	 * @param array $driveList The drive list.
	 */
	public function __construct($driveList) {
		$this->_meta = $driveList['meta'];
		$this->_objects = $driveList['objects'];
	}

	/**
	 * Return the fist drive object.
	 *
	 * @return Drive The first drive object.
	 */
	public function first() {
		return new Drive($this->_first());
	}

	/**
	 * Return the fist drive array
	 *
	 * @return array The first drive array.
	 */
	protected function _first() {
		return $this->_objects[0];
	}

} 