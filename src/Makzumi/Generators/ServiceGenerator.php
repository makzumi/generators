<?php namespace Makzumi\Generators;

use Illuminate\Filesystem\Filesystem;

class ServiceGenerator {
	protected $file;

	public function __construct(Filesystem $file){
		$this->file = $file;
	}

	public function make($base, $ns = false, $create = false){
		$base = ucfirst(strtolower($base));

		if($ns){
			$folder = str_replace('\\','/', $ns);
		}else {
			$folder = 'Services';
		}

		//BASE FOLDER
		$path = app_path().'/'.$folder;
		if(!$this->file->exists($path))$this->file->makeDirectory($path, 511, true);
		$spath = $path.'/'.$base;
		if(!$this->file->exists($spath)){
			$this->file->makeDirectory($spath, 511, true);
			$this->file->makeDirectory($spath.'/Facades', 511, true);
		}

		//FACADE
		$template = $this->getFacadeTemplate($base, $ns);
		$this->file->put($spath.'/Facades/'.$base.'Facade.php', $template);

		//SERVICE
		$template = $this->getServiceTemplate($base, $ns);
		$this->file->put($spath.'/'.$base.'.php', $template);

		//PROVIDER
		$template = $this->getProviderTemplate($base, $ns);
		$this->file->put($spath.'/'.$base.'ServiceProvider.php', $template);

		//USAGE
		$template = $this->getMD($base, $ns);
		if(!$this->file->exists($spath.'/README.MD')){
			$this->file->put($spath.'/README.MD', $template);
		}
		return $template;
	}

	private function getFacadeTemplate($base, $namespace = false){
		$ri = $this->file->get(__DIR__.'/templates/service_facade.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$data = str_replace('{{BASE_LC}}', strtolower($base), $data);
		$data = str_replace('{{NAMESPACE}}', $namespace, $data);
		return $data;
	}

	private function getServiceTemplate($base, $namespace = false){
		$ri = $this->file->get(__DIR__.'/templates/service.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$data = str_replace('{{BASE_LC}}', strtolower($base), $data);
		$data = str_replace('{{NAMESPACE}}', $namespace, $data);
		return $data;
	}

	private function getProviderTemplate($base, $namespace = false){
		$ri = $this->file->get(__DIR__.'/templates/service_provider.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$data = str_replace('{{BASE_LC}}', strtolower($base), $data);
		$data = str_replace('{{NAMESPACE}}', $namespace, $data);
		return $data;
	}


	private function getMD($base, $namespace){
		$ri = $this->file->get(__DIR__.'/templates/service_usage.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$ns = $namespace ? $namespace : 'namespace';
		$data = str_replace('{{NAMESPACE}}', $ns, $data);
		return $data;

	}
}