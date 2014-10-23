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
 * A common base for all objects in CloudSigma
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
abstract class BaseObject {

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
