<?php

namespace App\Providers;

use App\Models\Module;
use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        $loader = new ClassLoader();

        if ( Schema::hasTable('modules')) {

            $modules = Module::all();

            $namespaces = array();
            $providers = array();

            if (cache()->has('module_namespaces')) {
                $namespaces = cache('module_namespaces');

                if (empty($namespaces)) {
                    $namespaces = array();
                }
            }

            if (cache()->has('module_providers')) {
                $providers = cache('module_providers');

                if (empty($providers)) {
                    $providers = array();
                }
            }

            if (!empty($modules)) {
                foreach ($modules as $module) {
                    $module_name = $module->name;

                    if (Module::checkModuleExistsByNameInFolder($module_name)) {

                        $content = file_get_contents( Module::getPathFolderModules() . '/' . $module_name . '/module.json');
                        $data = json_decode($content, TRUE);

                        if (isset($data['namespace'])) {
                            $namespaces[$module_name] = $data['namespace'];
                            $loader->setPsr4($data['namespace'], Module::getPathFolderModules() . '/' . $module_name . '/src');
                        }

                        if (isset($data['provider'])) {
                            $providers[$module_name] = $data['provider'];
                            $this->app->register($data['provider']);
                        }
                    }
                }

                cache()->forever('module_namespaces', $namespaces);
                cache()->forever('module_providers', $providers);
            }

            $loader->register();
        }
    }
}
