<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Class Drive
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Drive {
	const MOUNTED = 'mounted';

	protected $_driveData;

	function __construct($driveData) {
		$this->_driveData = $driveData;
	}

	/**
	 * Returns the UUID
	 *
	 * @return string The UUID.
	 */
	public function getUuid() {
		return $this->_driveData['uuid'];
	}

	/**
	 * Is the drive mounted?
	 *
	 * @return bool True if mounted, else false.
	 */
	public function isMounted() {
		return ($this->_getMountState() == self::MOUNTED);
	}

	/**
	 * Returns the drive's mount state
	 *
	 * @return string The mount state.
	 */
	protected function _getMountState() {
		return $this->_driveData['status'];
	}

} 