<?php
 
namespace Zent\User\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class UserServiceProvider extends ServiceProvider
{
    /**
     * Function boot.
     *
     * @return here
     * @author ThanhTung
     */
    public function  boot() {

    }

	/*
	 * Funtion register
	 */
	
	public function register()
	{	
		/*
		 * Call routes in this modules
		 */
	    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

	    /*
	     * When call return view use: return view('user: view-name');
	     */
	    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'user');

	    /*
	     * Call migrations in this modules
	     */
	    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

	    /*
	     * Call translation
	     */
	}
}
