<?php

use Foxted\Permissions\Permission;
use Foxted\Permissions\Role;

class RoleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app->make('artisan')->call('migrate', [
            '--env' => 'testing',
            '--package' => 'foxted/permissions'
        ]);
    }

    /** @test */
    public function it_can_create_a_role()
    {
        $role = $this->createRole();

        $this->assertInstanceOf(
             'Foxted\Permissions\Role',
             $role,
             'The object must be an instance of Foxted\\Permissions\\Role'
        );
    }

    /** @test */
    public function it_can_have_a_name()
    {
        $role = $this->createRole();

        $this->assertEquals(
             'TestRole',
             $role->name,
             "The name should be \"TestRole\""
        );
    }

    /** @test */
    public function it_can_have_a_permission()
    {
        $role = $this->createRole();
        $permission = $this->createPermission();

        $role->allow($permission);

        $this->assertTrue($role->can('test'));
    }

    /**
     * Create a role
     * @return Role
     */
    private function createRole()
    {
        $role = new Role(['name' => 'TestRole']);
        $role->save();
        return $role;
    }

    /**
     * Create permission
     * @return Permission
     */
    private function createPermission()
    {
        $permission = new Permission([
            'name' => "test",
            'display_name' => "TestPermission"
        ]);
        $permission->save();
        return $permission;
    }

}