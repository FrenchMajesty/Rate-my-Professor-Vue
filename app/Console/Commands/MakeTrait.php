<?php

/**
 * THIS CLASS IS ONLY TESTED FOR WINDOWS SYSTEMS.
 * THIS CLASS CREATE TRAITS VIA ARTISAN CONSOLE.
 * 
 * @author Paulo Santos
 * @company WebMax
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;

class MakeTrait extends Command
{
    /**
     * Parent directory
     *
     * @var string
     */
    private $rootDir = 'app/Traits';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->save());
    }

    /**
     * Make root directory "Trait" if not exists
     *
     * @return void
     */
    private function makeRootDir()
    {
        if (!file_exists($this->rootDir)) {
            mkdir($this->rootDir, 0755);
        }
    }

    /**
     * Return trait code
     *
     * @return string
     */
    private function makeTrait()
    {
        return $code = sprintf(
'<?php 

namespace %s\Traits;

trait %s 
{
    // code here...
}
', 
        $this->getAppNamespace(),
        $this->checkName());
    }

    /**
     * Create new trait
     *
     * @return mixed
     */
    private function save()
    {
        // generate root directory if not exists
        $this->makeRootDir();

        // generate trait path
        $trait = $this->generateName();

        // check if the new trait already exists
        if (file_exists($trait)) {
            throw new Exception('The trait "' . $trait . '" already exists.');
        }

        // create trait 
        file_put_contents($trait, $this->makeTrait());

        // check if trait was created
        if (!file_exists($trait)) {
            throw new Exception('The trait "' . $trait . '" already exists.');
        } else {
            return 'Trait "' . $this->argument('name') . '" was created sucefully!';
        }
    }

    /**
     * Generate trait path
     *
     * @return string
     */
    private function generateName()
    {
        $name = strripos($this->argument('name'), DIRECTORY_SEPARATOR) != false ?: false;

        if ($name) {

            $path = '';
            $tree = explode('\\', $this->argument('name'));

            foreach ($tree as $index => $dir) {
                if ($index == count($tree) -1) {
                    continue;
                } else {
                    if (is_dir($this->rootDir . '/' . $path . ucfirst($dir))) {
                        throw new Exception('The directory "' . $dir . '" already exists.');
                    }
                    $path .= ucfirst($dir) . '/';
                }
            }

            $path = '';

            foreach ($tree as $index => $dir) {
                if ($index == count($tree) -1) {
                    $newName = ucfirst($dir);
                    continue;
                } else {
                    mkdir($this->rootDir . '/' . $path . ucfirst($dir), 0755);
                    $path .= ucfirst($dir) . '/';
                }
            }
            return $this->rootDir . '/' . $path . $newName . '.php';
        }
        return $this->rootDir . '/' . $this->argument('name') . '.php';
    }

    /**
     * Extract the correct name
     *
     * @return string
     */
    private function checkName()
    {
        $name = strripos($this->argument('name'), DIRECTORY_SEPARATOR) != false ?: false;

        if ($name) {
            $name = explode('\\', $this->argument('name'));
            $name = $name[count($name) - 1];
        } else {
            $name = $this->argument('name');
        }
        return ucfirst($name);
    }

    /**
     * Get the application namespace
     *
     * @return namespace or thrown RuntimeException
     */
    public function getAppNamespace()
    {
        $composer = json_decode(file_get_contents(base_path() . '/composer.json'), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path() . '/' . $pathChoice)) {
                    return rtrim($namespace, '\\');
                }
            }
        }
        throw new RuntimeException("Unable to detect application namespace.");
    }
}