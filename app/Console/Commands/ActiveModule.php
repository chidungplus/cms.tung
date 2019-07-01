<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActiveModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:module:active {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate module';

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
            if (Module::checkModuleExistsByNameInFolder($name))
            {
                Module::activateModuleByName($name);
                $this->info(Module::notifyActivateModule($name));

                DB::commit();
                return true;

            } else {

                $this->error( Module::notifyCheckModuleNotExistsByNameInFolder($name) );
                return false;
            }
        } catch (\Exception $e) {

            $this->error($e->getMessage());
            return false;
        }
    }
}
