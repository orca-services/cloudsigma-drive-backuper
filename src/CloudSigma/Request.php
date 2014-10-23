<?php

namespace OrcaServices\CloudSigmaDriveBackuper\CloudSigma;

use GuzzleHttp\Client as GuzzleClient;

/**
 * The CloudSigma Request
 *
 * @package OrcaServices\CloudSigmaDriveBackuper\CloudSigma
 */
class Request {

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
		$response = $this->_guzzleClient->get('drives' . '?name=' . $filter);
		$driveList = $response->json();
		return new DriveList($driveList);
	}

} 