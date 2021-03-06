<?php namespace Makzumi\Generators;

use Illuminate\Filesystem\Filesystem;

class RepoGenerator {
	protected $file;

	public function __construct(Filesystem $file){
		$this->file = $file;
	}

	public function make($base, $ns = false, $create = false){
		$base = ucfirst(strtolower($base));

		if($ns){
			$folder = str_replace('\\','/', $ns);
		}else {
			$folder = 'Repositories';
		}

		$path = app_path().'/'.$folder;
		if(!$this->file->exists($path))$this->file->makeDirectory($path, 511, true);

		//INTERFACE
		$template = $this->getRepoInterfaceTemplate($base, $ns);
		$this->file->put($path.'/'.$base.'RepositoryInterface.php', $template);

		//IMPLEMENTATION
		$db = $path.'/Db';
		if(!$this->file->exists($db))$this->file->makeDirectory($db, 511, true);
		$template = $this->getRepoImplementationTemplate($base, $ns);
		$this->file->put($db.'/Db'.$base.'Repository.php', $template);

		//USAGE
		$template = $this->getMD($base, $ns);
		if(!$this->file->exists($path.'/README.MD')){
			$this->file->put($path.'/README.MD', $template);
		}
		return $template;
	}

	private function getRepoInterfaceTemplate($base, $namespace = false){
		$ri = $this->file->get(__DIR__.'/templates/repo_interface.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$ns = $namespace ? 'namespace ' . $namespace : '';
		$data = str_replace('{{NAMESPACE}}', $ns, $data);
		return $data;
	}

	private function getRepoImplementationTemplate($base, $namespace = false){
		$base = str_replace('\\', '', $base);
		$file = $namespace ? 'repo_implementation.txt' : 'repo_implementation_no.txt';
		$ri = $this->file->get(__DIR__.'/templates/'.$file);
		$data = str_replace('{{BASE}}', $base, $ri);

		$ns = $namespace ? $namespace : '';
		$data = str_replace('{{NAMESPACE}}', $ns, $data);

		return $data;
	}

	private function getMD($base, $namespace){
		$ri = $this->file->get(__DIR__.'/templates/repo_usage.txt');
		$data = str_replace('{{BASE}}', $base, $ri);
		$ns = $namespace ? $namespace : 'namespace';
		$data = str_replace('{{NAMESPACE}}', $ns, $data);
		return $data;

	}
}