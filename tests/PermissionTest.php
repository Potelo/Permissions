<?php

use Foxted\Permissions\Permission;

/**
 * Class PermissionTest
 *
 * @author Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
class PermissionTest extends BaseTest
{

    /** @test */
    public function it_can_create_a_permission()
    {
        $permission = $this->createPermission();

        $this->assertInstanceOf(
             'Foxted\Permissions\Permission',
                 $permission,
                 'The object must be an instance of Foxted\\Permissions\\Permission'
        );
    }

    /** @test */
    public function it_can_have_a_name()
    {
        $permission = $this->createPermission();

        $this->assertEquals(
             'test',
                 $permission->name,
                 "The name should be \"test\""
        );
    }

    /** @test */
    public function it_can_have_a_display_name()
    {
        $permission = $this->createPermission();

        $this->assertEquals(
             'TestPermission',
                 $permission->display_name,
                 "The name should be \"TestPermission\""
        );
    }

    /**
     * Create permission
     * @return Permission
     */
    private function createPermission()
    {
        $permission = new Permission([
            'name' => 'test',
            'display_name' => 'TestPermission'
        ]);
        $permission->save();
        return $permission;
    }

}