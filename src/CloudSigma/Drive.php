<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Class Drive
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Drive extends BaseObject {

	/**
	 * Mounted
	 */
	const MOUNTED = 'mounted';

	/**
	 * Unmounted
	 */
	const UNMOUNTED = 'unmounted';

	/**
	 * Is the drive mounted?
	 *
	 * @return bool True if mounted, else false.
	 */
	public function isMounted() {
		return ($this->_getMountState() == self::MOUNTED);
	}

	/**
	 * Is the drive ready?
	 *
	 * @return bool True if mounted, else false.
	 */
	public function isReady() {
		return ($this->_getMountState() == self::UNMOUNTED);
	}

	/**
	 * Returns the drive's mount state
	 *
	 * @return string The mount state.
	 */
	protected function _getMountState() {
		return $this->_objectData['status'];
	}

} 