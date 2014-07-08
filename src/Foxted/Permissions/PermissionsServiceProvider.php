<?php namespace Foxted\Permissions;


use Illuminate\Support\ServiceProvider;

/**
 * Class PermissionsServiceProvider
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class PermissionsServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 * @return void
	 */
	public function boot()
	{
		$this->package('foxted/permissions');
	}

	/**
	 * Register the service provider.
	 * @return void
	 */
	public function register()
	{
        foreach(['Role'] as $command)
        {
            $this->{"register$command"}();
        }
	}

    /**
     * Register the role add command
     */
    protected function registerRole()
    {
        $this->app->bind('roles.add', function($app)
        {
            return $app->make('Foxted\Permissions\Command\RoleCommand');
        });

        $this->commands('roles.add');
    }


    /**
	 * Get the services provided by the provider.
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
