<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Snapshot
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Snapshot {

	protected $_snapshotData;

	function __construct($snapshotData) {
		$this->_snapshotData = $snapshotData;
	}

	/**
	 * Returns the UUID
	 *
	 * @return string The UUID.
	 */
	public function getUuid() {
		return $this->_snapshotData['uuid'];
	}
}