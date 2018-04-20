<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class AddSeed extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraflat:add_seed';

    /**
     * The console command description.
     *
     * @var string
     */
	protected $description = 'This command will append the data into seeds';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
		if ($this->getNameInput() == "CommandPage") {
			$file_path = base_path() . "/database/seeds/CommandPage.php";
			if (strpos(file_get_contents($file_path), "'".$this->option('model')."'") != false){
				$this->line('Already exists!');
			} else {
				$stub = $this->files->get($this->getStub());
				$text = str_replace('DummyName', $this->option('model'), $stub);
				$text = str_replace('DummyOptions', $this->option('cols'), $text);			
				$insert_marker = "array);";
				$this->insert_into_file($file_path, $insert_marker, $text, true);			
			}
		} else {
			$this->line("Only CommandPage seeds file is supported!");
		}
	}

	protected function getOptions()
    {
        return [
			['model', null, InputArgument::OPTIONAL, 'Set Model Name'],
			['cols', null, InputArgument::OPTIONAL, 'Set Model options']
        ];
    }

	protected function getStub()
    {
		if ($this->getNameInput() == "CommandPage") {
			return __DIR__ . '/stub/addcommandseed.stub';
		}
    }

	/**
	* Insert arbitrary text into last match inside a text file
	*
	* @param string $file_path - absolute path to the file
	* @param string $insert_marker - a marker inside the file to
	*   look for as a pattern match
	* @param string $text - text to be inserted
	*/
	protected function insert_into_file($file_path, $insert_marker,
			$text) {
		$contents = file_get_contents($file_path);
		$pos = strrpos($contents, $insert_marker);
		if ($pos !== false) {
			$new_contents = substr_replace($contents, $insert_marker.$text, $pos, strlen($insert_marker));
			file_put_contents($file_path, $new_contents);
			$this->line('Added successfully!');
		} else {
			$this->line('Something went wrong!');
		}

	}

	
}
