<?php

use Foxted\Permissions\Permission;
use Foxted\Permissions\Role;

class RoleTest extends BaseTest
{

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

    /** @test */
    public function it_can_deny_a_permission()
    {
        $role       = $this->createRole();
        $permission = $this->createPermission();

        $role->allow( $permission );
        $role->deny( $permission );

        $this->assertFalse( $role->can('test') );
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