<?php namespace Foxted\Permissions\Command;

use Foxted\Permissions\Role;
use Foxted\Permissions\Permission;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RolePermissionCommand
 * @package Foxted\Permissions\Command
 * @author  Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
class RolePermissionCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'foxted:permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show role permissions or add permissions to a role';

    /**
     * Role to add the permissions onto
     * @var Role $role
     */
    protected $role;

    /**
     * Array of permissions to add
     * @var array
     */
    protected $permissions;

    /**
     * Constructor
     */
    public function __construct()
	{
        parent::__construct();
	}

    /**
     * Setup variables
     */
    protected function setUp()
    {
        $this->role = $this->getRole($this->argument('name'));
        $this->permissions = $this->extractPermissions();
        $this->force = $this->option('force');
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $this->setUp();
        foreach ($this->permissions as $permission) $this->role->allow($permission);
        $this->info($this->argument('permissions').' permissions set for '.$this->argument('name').' role.');
	}

    /**
     * Get role in database
     * @param $roleName
     * @return Role
     */
    protected function getRole($roleName)
    {
        $role = Role::whereName($roleName)->first();
        if($role == NULL)
        {
            if($this->option('force')) return $this->createRole($roleName);
            else $this->error('The '.$roleName.' role does not exists. Use --force if to force creation.');
        }
        return $role;
    }

    /**
     * Create a role in database
     * @param $roleName
     * @return Role
     */
    protected function createRole($roleName)
    {
        return Role::create([
            'name' => $roleName
        ]);
    }

    /**
     * Get permission from database
     * @param $permissionName
     * @return mixed
     */
    protected function getPermission($permissionName)
    {
        $permission = Permission::whereName($permissionName)->first();

        if($permission == NULL)
        {

            if($this->option('force')) return $this->createPermission($permissionName);
            else
            {
                $this->error('The '.$permissionName.' permission does not exists. Use --force to force creation.');
            }
        }
        return $permission;
    }

    /**
     * Create a permission in database
     * @param $permissionName
     * @return mixed
     */
    protected function createPermission($permissionName)
    {
        if(Permission::whereName($permissionName)->first() != NULL) $this->error('The '.$permissionName.' permission already exists!');
        return Permission::create([
            'name'         => $permissionName,
            'display_name' => $this->formatPermission($permissionName)
        ]);
    }

    /**
     * Format permission name into a display name
     * @param string $permission
     * @return string
     */
    protected function formatPermission($permission)
    {
        $permission = strtr($permission, ['_' => ' ', '-' => ' ']);
        return ucwords($permission);
    }

    /**
     * Extract permissions into array
     * @return array
     */
    protected function extractPermissions()
    {
        $permissions = explode(',', $this->argument('permissions'));
        return array_map([$this,'getPermission'], $permissions);
    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the role'],
            ['permissions', InputArgument::REQUIRED, 'Permissions to apply (ex.: read_posts,write_posts,delete_posts']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force creation of permission when they do not exist']
        ];
    }

    /**
     * Abort after errors
     * @param string $message
     */
    public function error($message)
    {
        parent::error($message);
        die;
    }

}
