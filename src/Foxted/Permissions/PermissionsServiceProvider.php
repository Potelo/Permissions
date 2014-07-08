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
        foreach(['Role', 'Migrate'] as $command)
        {
            $this->{"register$command"}();
        }
	}

    /**
     * Register the role command
     * @return void
     */
    protected function registerRole()
    {
        $this->app->bind('foxted.role', function($app)
        {
            return $app->make('Foxted\Permissions\Command\RoleCommand');
        });

        $this->commands('foxted.role');
    }

    /**
     * Register the migrate command
     * @return void
     */
    protected function registerMigrate()
    {
        $this->app->bind(
            'foxted.migrations',
            function ( $app )
            {
                return $app->make( 'Foxted\Permissions\Command\MigrationCommand' );
            }
        );

        $this->commands( 'foxted.migrations' );
    }


    /**
	 * Get the services provided by the provider.
	 * @return array
	 */
	public function provides()
	{
		return array('permissions');
	}

}
