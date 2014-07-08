<?php

use Foxted\Permissions\Permission;
use Foxted\Permissions\Role;

/**
 * Class RoleTest
 *
 * @author Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
class RoleTest extends BaseTest
{

    /**
     * It can create a role
     * @test
     */
    public function it_can_create_a_role()
    {
        $role = $this->createRole();

        $this->assertInstanceOf(
             'Foxted\Permissions\Role',
             $role,
             'The object must be an instance of Foxted\\Permissions\\Role'
        );
    }

    /**
     * It can have a name
     * @test
     */
    public function it_can_have_a_name()
    {
        $role = $this->createRole();

        $this->assertEquals(
             'TestRole',
             $role->name,
             "The name should be \"TestRole\""
        );
    }

    /**
     * It can have a permission
     * @test
     */
    public function it_can_have_a_permission()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();

        $role->allow($permission);

        $this->assertTrue($role->can('test'));
    }

    /**
     * It can deny a permission
     * @test
     */
    public function it_can_deny_a_permission()
    {
        $role       = $this->createRole();
        $permission = $this->createPermission();

        $role->allow( $permission );
        $role->deny( $permission );

        $this->assertFalse( $role->can('test') );
    }

    /**
     * It can create a role via command line
     * @test
     */
    public function it_can_create_a_role_via_command_line()
    {
        $output = new Symfony\Component\Console\Output\BufferedOutput();
        $cmd = Artisan::call('foxted:role', ['name' => 'Admin'], $output);
        $this->assertEquals( "Admin role created!", trim( $output->fetch() ) );
    }

    /**
     * It can create a role via command line
     *
     * @test
     */
    public function it_can_delete_a_role_via_command_line()
    {
        $output = new Symfony\Component\Console\Output\BufferedOutput();
        $cmd    = Artisan::call( 'foxted:role', [ 'name' => 'Admin', '--delete' => NULL ], $output );
        $this->assertEquals( "Admin role deleted!", trim( $output->fetch() ) );
    }

    /**
     * Create a role
     * @return Role
     */
    private function createRole()
    {
        return Role::create(['name' => 'TestRole']);
    }

    /**
     * Create permission
     * @return Permission
     */
    private function createPermission()
    {
        return Permission::create([
            'name' => "test",
            'display_name' => "TestPermission"
        ]);
    }

}