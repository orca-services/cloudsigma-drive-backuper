<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

use GuzzleHttp\Client as GuzzleClient;

/**
 * The CloudSigma API Request
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Request {

	/**
	 * Snapshots URL
	 */
	const SNAPSHOTS = 'snapshots/';

	/**
	 * Drives URL
	 */
	const DRIVES = 'drives/';

	/**
	 * The guzzle client.
	 *
	 * @var \GuzzleHttp\Client
	 */
	protected $_guzzleClient;

	/**
	 * The base URL to use.
	 *
	 * @var string
	 */
	protected $_baseUrl;

	/**
	 * The "direct" base URl for special purposes.
	 *
	 * @var string
	 */
	protected $_directBaseUrl;

	/**
	 * The default settings.
	 *
	 * @var array
	 */
	protected $_defaults = [];

	/**
	 * Set the guzzle client and the default settings.
	 *
	 * @param string $location The CloudSigma location to communicate with.
	 * @param string $username The CloudSigma username.
	 * @param string $password The CloudSigma password.
	 */
	function __construct($location, $username, $password) {
		$this->_baseUrl = sprintf('https://%s.cloudsigma.com/api/2.0/',
			$location
		);
		$this->_directBaseUrl = sprintf('https://direct.%s.cloudsigma.com/api/2.0/',
			$location
		);
		$this->_defaults = [
			'auth' =>  [$username, $password],
			'verify' => false, // Unfortunately Guzzle couldn't verify the cert CA
		];

		$this->_guzzleClient = new GuzzleClient([
			'base_url' => $this->_baseUrl,
			'defaults' => $this->_defaults,
		]);
	}

	/**
	 * Get drive list
	 *
	 * @param $filter
	 * @return DriveList The list of drives found.
	 */
	public function getDriveList($filter) {
		$response = $this->_guzzleClient->get(self::DRIVES . '?name=' . $filter);
		$driveList = $response->json();
		return new DriveList($driveList);
	}

	/**
	 * Get single drive.
	 *
	 * @param $driveUuid
	 * @return Drive The list of drives found.
	 */
	public function getDrive($driveUuid) {
		$response = $this->_guzzleClient->get(self::DRIVES . $driveUuid);
		$drive = $response->json();
		return new Drive($drive);
	}

	/**
	 * Delete a drive.
	 *
	 * @param string $driveUuid The UUID of the drive to delete.
	 * @return bool True the drive was deleted, else false.
	 */
	public function deleteDrive($driveUuid) {
		$response = $this->_guzzleClient->delete(self::DRIVES . $driveUuid);
		return ($response->getStatusCode() === '204');
	}

	/**
	 * Create a snapshot of a drive.
	 *
	 * @param string $driveUuid The drive's UUID to create a snapshot from.
	 * @return Snapshot The created snapshot object.
	 */
	public function createSnapshot($driveUuid) {
		$data = [
			'drive' => $driveUuid,
			'name' => 'Automatic snapshot',
		];
		$snapshots = $this->_guzzleClient->post(self::SNAPSHOTS, ['json' => $data]);
		$snapshots = $snapshots->json();
		$snapshots = new SnapshotList($snapshots);
		return $snapshots->first();
	}

	/**
	 * Clone a snapshot to a drive
	 *
	 * @param $snapshotUuid
	 * @return Drive The cloned drive.
	 */
	public function cloneSnapshot($snapshotUuid) {
		$drive = $this->_guzzleClient->post(self::SNAPSHOTS . $snapshotUuid . '/action/?do=clone');
		$drive = $drive->json();
		return new Drive($drive);
	}

	/**
	 * Delete a snapshot.
	 *
	 * @param string $snapshotUuid The UUID of the snapshot to delete.
	 * @return bool True the drive was deleted, else false.
	 */
	public function deleteSnapshot($snapshotUuid) {
		$response = $this->_guzzleClient->delete(self::SNAPSHOTS . $snapshotUuid);
		return ($response->getStatusCode() === '204');
	}

	/**
	 * Download a drive to a file.
	 *
	 * @param string $driveUuid The UUID of the drive to download.
	 * @param resource|string $saveTo Either save to a resource or file path.
	 * @return bool Always true.
	 * @todo Improve return value.
	 */
	public function downloadDrive($driveUuid, $saveTo) {
		$response = $this->_guzzleClient->get(
			$this->_directBaseUrl . self::DRIVES . $driveUuid . '/download/',
			$this->_defaults + ['save_to' => $saveTo]
		);
		return true;
	}

}
