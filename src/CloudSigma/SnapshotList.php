<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Class SnapshotList
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class SnapshotList {

	/**
	 * The snapshot list meta data.
	 *
	 * @var array
	 */
	protected $_meta;

	/**
	 * The snapshot list objects.
	 *
	 * @var array
	 */
	protected $_objects;

	/**
	 * Sets the snapshot list.
	 *
	 * @param array $snapshotList The drive list.
	 */
	public function __construct($snapshotList) {
		if (isset($snapshotList['meta'])) {
			$this->_meta = $snapshotList['meta'];
		}
		if (isset($snapshotList['objects'])) {
			$this->_objects = $snapshotList['objects'];
		}
	}

	/**
	 * Return the fist drive object.
	 *
	 * @return Drive The first drive object.
	 */
	public function first() {
		return new Snapshot($this->_first());
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