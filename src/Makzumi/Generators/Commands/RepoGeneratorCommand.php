<?php namespace Makzumi\Generators\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Makzumi\Generators\RepoGenerator;

class RepoGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'makzumi:repo';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate Repositories';
	protected $repog;

	public function __construct (RepoGenerator $repog) {
		$this->repog = $repog;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire () {
		//
		$base   = $this->ask('What is the repository\'s name? i.e: User: ');
		if(!$base){
			$this->error('No repository name provided.');
			return;
		}

		$create = false;
		if (!$has_ns = $this->confirm('Do you have a namespace? Y/N: ')) {
			$create = $this->confirm('Create namespace folders? Y/N: ');
		}

		$ns = false;
		if($create || $has_ns) {
			$ns = $this->ask('What is the namespace? i.e: Acme\Repositories :');
		}

		if(!$this->confirm('Proceed with creation? Y/N: ')){
			$this->info('Process stopped');
			return;
		}

		$this->repog->make($base, $ns, $create);
		$ending = "\n".
			"Repository created.\n".
			"- - - - - - - - - \n".
			"Please view README.MD to finish installation and see sample usage.";

		$this->info($ending);
	}

}
