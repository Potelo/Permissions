<?php namespace Foxted\Permissions\Command;

use Illuminate\Config\Repository;
use Illuminate\Console\Application;
use Illuminate\Console\Command;

/**
 * Class MigrationCommand
 * @package Foxted\Permissions\Command
 * @author  Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
class MigrationCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'foxted:migrations';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Generate migrations for package tables';

    /**
     * The laravel config facade
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * The laravel artisan facade
     * @var \Illuminate\Console\Application
     */
    protected $artisan;

    /**
     * Roles table mandatory fields
     * @var array
     */
    protected $roles = ['name:string'];

    /**
     * Permissions table mandatory fields
     *
     * @var array
     */
    protected $permissions = [ 'name:string', 'display_name:string' ];

    /**
     * Users table mandatory fields
     *
     * @var array
     */
    protected $users = [ 'email:string:unique()', 'password:string(60)', 'remember_token:string(60)' ];

    /**
     * Will contain table name for the relationship
     * @var array
     */
    protected $relation = [];

    /**
     * Will contain the roles table information to create the foreign key on users
     * @var string
     */
    protected $foreign;

    /**
     * Constructor
     */
    public function __construct( Repository $config, Application $artisan)
	{
		parent::__construct();
        $this->config = $config;
        $this->artisan = $artisan;
    }

	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function fire()
	{
        $this->createRoleMigration();
        $this->createPermissionMigration();
        $this->createPermissionRoleMigration();
        $this->createUserMigration();
	}

    /**
     * Create the migration file for the roles table
     */
    protected function createRoleMigration()
    {
        $this->createMigration('roles', true, true);
    }

    protected function createPermissionMigration()
    {
        $this->createMigration('permissions', true, false);
    }

    protected function createPermissionRoleMigration()
    {
        $this->generatePivotMigration();
    }

    protected function createUserMigration()
    {
        $this->createMigration( 'users' , false, true);
        $this->generateForeignMigration();
    }

    protected function createMigration( $internalName, $relation = false, $foreign = false )
    {
        // Define variables
        list( $name, $migration, $fields ) = $this->defineNamesAndFields( $internalName );

        // Store the table name to create the relationship
        if($relation) $this->relation[ ] = $name;

        if($foreign) $this->foreign[] = $name;

        // Generate the migration file
        $this->generateCreateMigration( $migration, $fields );
    }

    /**
     * Generate a create table migration file
     * @param $migration
     * @param $fields
     */
    protected function generateCreateMigration( $migration, $fields )
    {
        if( $this->artisan->has( 'generate:migration' ) )
        {
            $this->artisan->call(
                'generate:migration',
                [
                    'migrationName'     => $migration,
                    '--fields' => $fields
                ],
                $this->getOutput()
            );
            $this->info( 'Generated.' );
        }
        else
        {
            $this->error("This package uses way/generators package.\nYou must add \"Way\\Generators\\GeneratorsServiceProvider\" in your app/config/app.php file");
        }
    }

    /**
     * Generate a pivot table migration file
     */
    protected function generatePivotMigration()
    {
        if( $this->artisan->has( 'generate:pivot' ) )
        {
            $this->artisan->call(
                'generate:pivot',
                [
                    'tableOne' => $this->relation[ 0 ],
                    'tableTwo' => $this->relation[ 1 ]
                ],
                $this->getOutput()
            );
            $this->info( 'Generated.' );
        }
        else
        {
            $this->error(
                "This package uses way/generators package.\nYou must add \"Way\\Generators\\GeneratorsServiceProvider\" in your app/config/app.php file"
            );
        }
    }

    /**
     * Generate a pivot table migration file
     */
    protected function generateForeignMigration()
    {
        if( $this->artisan->has( 'generate:migration' ) )
        {
            $fields = $this->foreign[ 0 ]."_id:integer:unsigned(), ".$this->foreign[ 0 ]."_id:foreign:references('id'):on('".$this->foreign[0]."')";

            $this->artisan->call(
                'generate:migration',
                [
                    'migrationName' => 'add_'.$this->foreign[ 0 ].'_id_to_'.$this->foreign[ 1 ].'_table',
                    '--fields' => $fields
                ],
                $this->getOutput()
            );
            $this->info( 'Generated.' );
        }
        else
        {
            $this->error(
                "This package uses way/generators package.\nYou must add \"Way\\Generators\\GeneratorsServiceProvider\" in your app/config/app.php file"
            );
        }
    }

    /**
     * Generate fields for the table
     * @param $name
     * @return string
     */
    protected function generateFields($name)
    {
        $fields = $this->{$name};
        if($this->config->has('permissions::fields.'.$name))
        {
            $fields = array_merge($fields, $this->config->get('permissions::fields.'.$name));
        }
        return implode(', ', $fields);
    }

    /**
     * Define the names for the table, migration file and fields
     *
     * @param $internalName
     * @return array
     */
    protected function defineNamesAndFields( $internalName )
    {
        $name      = $this->config->get( 'permissions::tables.'.$internalName );
        $migration = 'create_'.strtolower( $name ).'_table';
        $fields    = $this->generateFields( $internalName );

        return [ $name, $migration, $fields ];
    }

}
