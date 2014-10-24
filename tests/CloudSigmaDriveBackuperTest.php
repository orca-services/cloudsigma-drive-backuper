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

use OrcaServices\CloudSigmaDriveBackuper;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * CloudSigmaDriveBackup Test
 *
 * @covers CloudSigmaDriveBackuper
 */
class CloudSigmaDriveBackuperTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the command execution
	 *
	 * @return void
	 * @covers ::execute
	 */
	public function testExecute() {
		/*$application = new Application();
		$application->add(new CloudSigmaDriveBackuper());

		$command = $application->find('demo:greet');
		$commandTester = new CommandTester($command);
		$commandTester->execute(array('command' => $command->getName()));

		$this->assertRegExp('/.../', $commandTester->getDisplay());*/

		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

}