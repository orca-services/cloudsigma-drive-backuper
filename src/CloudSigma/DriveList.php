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
 * Class DriveList
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class DriveList extends BaseObjectList {

	/**
	 * Return the fist drive object.
	 *
	 * @return Drive The first drive object.
	 */
	public function first() {
		return new Drive($this->_first());
	}

}
