<?php
/**
 * CloudSigma Drive Backuper
 *
 * Licensed under the MIT license.
 * For full copyright and license information, please see the LICENSE.
 *
 * @copyright ORCA Services AG
 * @link https://github.com/orca-services/cloudsigma-drive-backuper
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @author ORCA Services AG <development@orca-services.ch>
 */

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
