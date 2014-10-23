<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

/**
 * Class SnapshotList
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class SnapshotList extends BaseObjectList {

	/**
	 * Return the fist drive object.
	 *
	 * @return Drive The first drive object.
	 */
	public function first() {
		return new Snapshot($this->_first());
	}


}
