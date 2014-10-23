<?php

namespace OrcaServices\CloudSigmaDriveBackuper;

use OrcaServices\CloudSigmaDriveBackuper\CloudSigma\DriveList;
use OrcaServices\CloudSigmaDriveBackuper\CloudSigma\Request;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;


class CloudSigmaDriveBackuper extends Command
{

	protected function configure()
	{
		$this
			->setName('orca-services:cloudsigma-drive-backuper')
			->setDescription('Create and download drive backups from CloudSigma')
			->addOption(
				'location',
				null,
				InputOption::VALUE_REQUIRED,
				'The CloudSigma location.'//, 'zrh'
			)
			->addOption(
				'username',
				null,
				InputOption::VALUE_REQUIRED,
				'Your CloudSigma Username'
			)
			->addOption(
				'drive',
				null,
				InputOption::VALUE_REQUIRED,
				'The name of the drive to backup'
			)
			->addOption(
				'password',
				null,
				InputOption::VALUE_OPTIONAL,
				'Your CloudSigma Password'
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

		$infoText = sprintf('Going to backup the drive named %s from location %s',
			$driveName,
			$location
		);
		$output->writeln($infoText);

		$url = sprintf('https://%s.cloudsigma.com/api/2.0/drives/detail/?name=%s',
			$location,
			$driveName
		);

		$output->writeln($url);

		$request = new Request($location, $username, $password);
		$driveList = $request->getDriveList($driveName);
		$drive = $driveList->first();
		$isMounted = $drive->isMounted();

		/*
		$statusCode = $response->getStatusCode();
		$output->writeln(sprintf('Result Status code: %s',
			$statusCode
		));
		*/

		$output->writeln('Finished');
	}
}