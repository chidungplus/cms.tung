<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeleteModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:delete {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete module';

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
        DB::beginTransaction();
        $name = $this->argument('module-name');

        try {
            if ($this->confirm( 'Do you want to delete module ' . $name . ' now ?') )
            {
                if (Module::checkModuleExistsByNameInFolder($name))
                {
                    Storage::disk('module')->deleteDirectory($name);
                }

                Module::deleteModuleByName($name);
                Schema::dropIfExists($name . 's');
                $this->info( Module::notifyDeleteModule($name));

                DB::commit();
                return true;

            }
        } catch (\Exception $e) {

            $this->error($e->getMessage());
            return false;
        }
    }
}
