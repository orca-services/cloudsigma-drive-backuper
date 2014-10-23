<?php

namespace OrcaServices\CloudSigmaDriveBackuper;

use DateTime;
use OrcaServices\CloudSigmaDriveBackuper\CloudSigma\DriveList;
use OrcaServices\CloudSigmaDriveBackuper\CloudSigma\Request;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * CloudSigmaDriveBackuper console command
 *
 * @package OrcaServices\CloudSigmaDriveBackuper
 */
class CloudSigmaDriveBackuper extends Command
{

	/**
	 * Iterations to wait for the drive to be ready to download.
	 */
	const WAIT_ITERATIONS_FOR_DRIVE_READY = 10;

	/**
	 * Seconds per iteration to wait for the drive to be ready to download.
	 */
	const WAIT_SECONDS_FOR_DRIVE_READY = 30;

	/**
	 * Configure the console.
	 *
	 * @return void
	 */
	protected function configure()
	{
		$this
			->setName('orca-services:cloudsigma-drive-backuper')
			->setDescription('Create and download drive backups from CloudSigma')
			->addOption(
				'location',
				null,
				InputOption::VALUE_REQUIRED,
				'The CloudSigma location.'
			)
			->addOption(
				'username',
				null,
				InputOption::VALUE_REQUIRED,
				'Your CloudSigma Username.'
			)
			->addOption(
				'drive',
				null,
				InputOption::VALUE_REQUIRED,
				'The name of the drive to backup.'
			)
			->addOption(
				'password',
				null,
				InputOption::VALUE_REQUIRED,
				'Your CloudSigma Password.'
			)
			->addOption(
				'target',
				null,
				InputOption::VALUE_OPTIONAL,
				'The target path to download the drive.'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$cliQuestion = $this->getHelper('question');

		$location = $input->getOption('location');
		$username = $input->getOption('username');
		$password = $input->getOption('password');
		$driveName = $input->getOption('drive');
		$targetPath = $input->getOption('target');

		if (empty($password)) {
			$question = new Question('Please provide your CloudSignma Password: ', null);
			$password = $cliQuestion->ask($input, $output, $question);
		}
		if (empty($location)) {
			$question = new ChoiceQuestion(
				'Please choose a location to communicate with (defaults to "zrh")',
				array('Zurich' => 'zrh', 'wdc' => 'Washington DC', 'hnl' => 'Honolulu', 'sjc' => 'San Jose'),
				'zrh'
			);
			$question->setErrorMessage('Location %s is not valid.');

			$location = $cliQuestion->ask($input, $output, $question);
			$output->writeln(sprintf('You have selected the %s location.', $location));
		}
		if (is_dir($targetPath)) {
			$dateTimeString = (new DateTime())->format('Y-m-d_H-i-s');
			$targetPath = sprintf('%s%s_%s.img',
				$targetPath,
				$driveName,
				$dateTimeString
			);
		}

		$output->writeln(sprintf('Going to backup the drive named "%s" from location "%s" to %s',
			$driveName,
			$location,
			$targetPath
		));

		$request = new Request($location, $username, $password);

		$output->writeln(sprintf(
			'Searching for a drive named %s...',
			$driveName
		));
		$driveList = $request->getDriveList($driveName);
		$drive = $driveList->first();
		$output->writeln(sprintf(
			'Drive %s found.',
			$driveName
		));

		$output->writeln(sprintf(
			'Creating a snapshot for drive %s...',
			$driveName
		));
		$snapshot = $request->createSnapshot($drive->getUuid());
		$snapshotUuid = $snapshot->getUuid();
		$output->writeln(sprintf('Snapshot for drive %s created.',
			$driveName
		));

		$output->writeln(sprintf(
			'Cloning the newly created snapshot to a drive for downloading...',
			$driveName
		));
		$clonedDrive = $request->cloneSnapshot($snapshotUuid);
		$output->writeln(sprintf('Snapshot cloned to a drive.',
			$driveName
		));

		$clonedDriveUuid = $clonedDrive->getUuid();

		// Wait for drive to be ready for download

		$output->writeln('Waiting for the drive to be ready to download...');
		for ($i=1; $i <= self::WAIT_ITERATIONS_FOR_DRIVE_READY; $i++) {
			$output->writeln(sprintf(
					'%s of %s attempts...',
					$i,
					self::WAIT_ITERATIONS_FOR_DRIVE_READY
				)
			);
			sleep(self::WAIT_SECONDS_FOR_DRIVE_READY);

			$drive = $request->getDrive($clonedDriveUuid);
			if ($drive->isReady()) {
				break;
			}
		}
		if (!$drive->isReady()) {
			$output->writeln('Cloned drive still not ready, aborting...!');
			$output->writeln('Please remember to manually remove the cloned drive.');
			return;
		}
		$output->writeln(sprintf(
			'Starting to download the cloned drive to %s',
			$targetPath
		));
		$isDownloaded = $request->downloadDrive($clonedDrive->getUuid(), $targetPath);

		$output->writeln('Removing cloned drive...');
		$isDeleted = $request->deleteDrive($clonedDriveUuid);
		$output->writeln('Cloned drive deleted.');

		$output->writeln('Removing ccreated snapshot...');
		$isDeleted = $request->deleteSnapshot($snapshotUuid);
		$output->writeln('Snapshot deleted.');

		$output->writeln('Finished');
	}
}
