<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class CreateModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:create {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new module';

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
     * @author ThanhTung
     */
    public function handle()
    {
        $name = $this->argument('module-name');

        try {
            $name = $this->formatNameToLowerCase($name);

            // Check valid module name.
            if (!$this->checkModuleNameInvalid($name))
            {
                $this->error($this->checkModuleNameInvalid($name));
                return false;
            }

            // Check module exist in folder 'modules'
            if ($this->checkModuleExistsByNameInFolder($name))
            {
                $this->error($this->notifyCheckModuleExistsByNameInFolder($name));
                return false;
            }

            // Create module, then replace module name and content files.
            $this->createModule($name);
            $this->replaceModuleName($name);
            $this->replaceContentFiles($name);
            $this->saveDatabase($name);

            // Print notify in screen
            $this->info(Module::notifyCreateModule($name));
            //$this->info(Module::notifyActiveToUse());

            // Clear cache and autoload
            Artisan::call('cache:clear');
            Artisan::call('clear-compiled');

            exec('composer dump-autoload');

            return true;

        } catch (\Exception $e) {

            $this->error($e->getMessage());
            return false;
        }
    }

    /**
     * Format module name to lowercase .
     *
     * @param string
     * @return string
     */
    protected function formatNameToLowerCase($name)
    {
        return Module::formatNameToLowerCase($name);
    }

    /**
     * Check module name is invalid.
     * Not have number, space, special characters.
     *
     * @param string
     * @return boolean
     */
    protected function checkModuleNameInvalid($name)
    {
        return Module::checkModuleNameInvalid($name);
    }

    /**
     * Check module exists in folder modules.
     *
     * @param string
     * @return boolean
     */
    protected function checkModuleExistsByNameInFolder($name)
    {
        return Module::checkModuleExistsByNameInFolder($name);
    }

    /**
     * Copy folder template core to folder modules.
     *
     * @param string
     * @return boolean
     */
    protected function createModule($name)
    {
        // Create folder
        Storage::makeDirectory($name);
        File::copyDirectory( Module::getPathFolderTemplate(), Module::getPathFolderModules() . "/" . $name);

        return true;
    }

    /**
     * Alert notification if name invalid.
     *
     * @param string
     * @return string
     */
    protected function notifyCheckModuleNameInvalid()
    {
        return Module::notifyCheckModuleNameInvalid();
    }

    /**
     * Alert notification if module is exists.
     *
     * @param string
     * @return string
     */
    protected function notifyCheckModuleExistsByNameInFolder($name)
    {
        return Module::notifyCheckModuleExistsByNameInFolder($name);
    }

    /**
     * Replace module folder and file name.
     *
     * @param string
     * @return boolean
     */
    protected function replaceModuleName($name)
    {
        $files = Storage::disk('module')->allFiles($name);

        $str = $this->convertModuleName($name);

        for ($index = 0; $index < sizeof($files); $index++)
        {
            $fileNameDefault = $files[$index];

            if ( strpos($fileNameDefault, "{") !== FALSE )
            {
                $fileName = $fileNameDefault;

                $fileName = str_replace("{core}", $str['str_lower'], $fileName);
                $fileName = str_replace("{Core}", $str['str_upper'], $fileName);

                $migrate_date = date('Y_m_d_His', strtotime( now() ));
                $fileName = str_replace("{migrate_date}", $migrate_date, $fileName);
                $fileName = str_replace("{core_snake_case}", $name, $fileName);

                $exists = Storage::disk('module')->exists($fileName);

                if ($exists != true)
                {
                    Storage::disk('module')->move($fileNameDefault, $fileName);
                    Storage::disk('module')->delete($fileNameDefault);
                }
            }

        }

        return true;
    }

    /**
     * Handle module name
     *
     * @param string
     * @return array
     */
    protected function convertModuleName($name)
    {
        $arr = explode("_", $name);

        $str = array('str_upper' => null,  'str_lower' => null);

        for ($i = 0; $i < sizeof($arr); $i++) {
            $str['str_upper'] .= ucfirst($arr[$i]);
        }

        $str['str_lower'] = lcfirst($str['str_upper']);

        return $str;
    }

    protected function replaceContentFiles($name)
    {
        $files = Storage::disk('module')->allFiles($name);
        $str = $this->convertModuleName($name);

        for ($index = 0; $index < sizeof($files); $index++)
        {
            $fileName = $files[$index];
            $exists = Storage::disk('module')->exists($fileName);

            if ($exists == true)
            {
                $contents = Storage::disk('module')->get($fileName);
                $contents = str_replace("{core}", $str['str_lower'], $contents);
                $contents = str_replace("{Core}", $str['str_upper'], $contents);
                $contents = str_replace("{core_snake_case}", $name, $contents);

                Storage::disk('module')->put($fileName, $contents);
            }
        }

        return true;
    }

    /**
     * Save to database.
     *
     * @param string
     * @return boolean
     */
    protected function saveDatabase($name)
    {
        DB::beginTransaction();

        try {

            Module::create([
                'name'          =>  $name,
                'display_name'  =>  $name,
                'status'        =>  1
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {

            $this->error($e->getMessage());
            return false;
        }
    }
}
