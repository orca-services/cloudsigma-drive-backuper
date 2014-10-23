<?php

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