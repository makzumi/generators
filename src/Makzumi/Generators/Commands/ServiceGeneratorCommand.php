<?php namespace Makzumi\Generators\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Makzumi\Generators\ServiceGenerator;

class ServiceGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'makzumi:service';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates Service Providers';
	protected $servo;

	public function __construct (ServiceGenerator $servo) {
		$this->servo = $servo;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire () {
		//
		$base   = $this->ask('What is the service provider\'s name? i.e: User: ');
		if(!$base){
			$this->error('No service provider name provided.');
			return;
		}

		$ns = $this->ask('Please provide a namespace. i.e: Acme\Services :');
		if(!$ns){
			$this->error('No namespace provided.');
			return;
		}

		if(!$this->confirm('Proceed with creation? Y/N: ')){
			$this->info('Process stopped');
			return;
		}

		$this->servo->make($base, $ns);
		$ending = "\n".
			"Service Prover created.\n".
			"- - - - - - - - - \n".
			"Please view README.MD to finish installation and see sample usage.";

		$this->info($ending);
	}

}
