<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

use GuzzleHttp\Client as GuzzleClient;

/**
 * The CloudSigma Request
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Request {
	const SNAPSHOTS = 'snapshots/';
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
	 * The authentication settings.
	 *
	 * @var array
	 */
	protected $_auth = array();

	/**
	 * Set the guzzle client.
	 */
	function __construct($location, $username, $password) {
		$this->_baseUrl = sprintf('https://%s.cloudsigma.com/api/2.0/',
			$location
		);
		$this->_directBaseUrl = sprintf('https://direct.%s.cloudsigma.com/api/2.0/',
			$location
		);
		$this->_auth = [$username, $password];

		$this->_guzzleClient = new GuzzleClient([
			'base_url' => $this->_baseUrl,
			'defaults' => [
				'auth' =>  $this->_auth,
				'verify' => false,
			]
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
	 * Create a snapshot of a drive.
	 *
	 * @param string $driveUuid The drive's UUID to create a snapshot from.
	 * @return array The snapshot data array
	 * @todo Change return value to Snapshot object
	 */
	public function createSnapshot($driveUuid) {
		$data = [
			'drive' => $driveUuid,
			//'meta' => [],
			'name' => 'Automatic snapshot',
		];
		$snapshot = $this->_guzzleClient->post(self::SNAPSHOTS, ['json' => $data]);
		$snapshot = $snapshot->json();
		return $snapshot;
	}

} 