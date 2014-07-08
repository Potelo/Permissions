<?php namespace Foxted\Permissions\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Foxted\Permissions\Role;

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
	protected $description = 'Add a role in database';

    /**
     * Constructor
     */
    public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function fire()
	{
        $this->createRole();
	}

    public function createRole()
    {
        $name = $this->argument( 'name' );
        $role = Role::create([
            'name' => $name
        ]);
        $this->info( $name.' role created!' );
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

}
