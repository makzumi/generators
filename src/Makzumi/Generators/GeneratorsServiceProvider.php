<?php namespace Makzumi\Generators;

use Illuminate\Support\ServiceProvider;
use Makzumi\Generators\Commands\RepoGeneratorCommand;
use Makzumi\Generators\Commands\ServiceGeneratorCommand;

class GeneratorsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	public function boot () {
		$this->package('makzumi/generators');
	}

	public function register () {
		foreach ([
					 'Repo',
					 'Service'
				 ] as $command) {
			$this->{"register$command"}();
		}
	}

	protected function registerRepo () {
		$this->app['generate.repo'] = $this->app->share(function ($app) {
			$generator = $this->app->make('Makzumi\Generators\RepoGenerator');
			return new RepoGeneratorCommand($generator);
		});

		$this->commands('generate.repo');
	}

	protected function registerService () {
		$this->app['generate.service'] = $this->app->share(function ($app) {
			$generator = $this->app->make('Makzumi\Generators\ServiceGenerator');
			return new ServiceGeneratorCommand($generator);
		});

		$this->commands('generate.service');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides () {
		return [ ];
	}

}
