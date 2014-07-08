<?php namespace Foxted\Permissions\Command;

use Foxted\Permissions\Role;
use Foxted\Permissions\Permission;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Class RoleCommand
 * @package Foxted\Permissions\Command
 * @author  Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
class RoleCommand extends Command
{

	/**
	 * The console command name.
	 * @var string
	 */
	protected $name = 'foxted:role';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Add/modify a role in database with permissions';

    /**
     * Constructor
     */
    public function __construct(Str $str)
	{
		parent::__construct();
        $this->str = $str;
	}

	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function fire()
	{
        if($this->option( 'delete' )) $this->deleteRole();
        else $this->createRole();
	}

    /**
     * Create role in database
     * @return void
     */
    protected function createRole()
    {
        $name = $this->argument( 'name' );
        $role = Role::firstOrCreate([
            'name' => $name
        ]);
        $this->attachPermissions($role);
        $this->info( $name.' role created!' );
    }

    /**
     * Delete role from database
     * @return void
     */
    protected function deleteRole()
    {
        $name = $this->argument( 'name' );
        Role::whereName( $name )->delete();
        $this->info( $name.' role deleted!' );
    }

    protected function attachPermissions($role)
    {
        $permissions = $this->permissionsToArray($this->option('permissions'));

        foreach($permissions as $permission)
        {
            $role->allow(Permission::firstOrCreate([
                'display_name' => $permission,
                'name' => $this->str->slug($permission, '_')
            ]));
        }
    }

    protected function permissionsToArray($permissions)
    {
        $permissions = explode(',',$permissions);
        return array_map('trim', $permissions);
    }

	/**
	 * Get the console command arguments.
	 * @return array
	 */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the desired role']
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            [ 'delete', 'd', InputOption::VALUE_NONE, 'Add this to delete the specified role' ],
            [ 'permissions', 'p', InputOption::VALUE_OPTIONAL, 'Add permissions to role (ex.: Create user, Edit user, Delete user).' ]
        ];
    }

}
