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
        $role = $this->createRole(['id' => 1, 'name' => 'TestRole']);

        $this->assertInstanceOf(
             'Foxted\Permissions\Role',
             $role,
             'The object must be an instance of Foxted\\Permissions\\Role'
        );
    }

    /** @test */
    public function it_can_have_a_permission()
    {
        $role = $this->createRole(['name' => 'TestRole']);
        $permission = $this->createPermission(['name' => "test", 'display_name' => "Test"]);

        $role->allow($permission);

        $this->assertTrue($role->can('test'));
    }

    /**
     * Create a role
     * @param array $attributes
     * @return Role
     */
    private function createRole(array $attributes)
    {
        $role = new Role($attributes);
        $role->save();
        return $role;
    }

    /**
     * Create permission
     * @param array $attributes
     * @return Permission
     */
    private function createPermission(array $attributes)
    {
        $permission = new Permission($attributes);
        $permission->save();
        return $permission;
    }

}