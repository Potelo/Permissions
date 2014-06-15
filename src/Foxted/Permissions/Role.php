<?php namespace Foxted\Permissions;

/**
 * Class Role
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class Role extends \Eloquent
{
	protected $table = 'roles';
    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMany('\Foxted\Permissions\Permission');
    }

    /**
     * Check if the role has specified permission
     * @param $permission
     * @return bool
     */
    public function can($permission)
	{
		if($permission != NULL)
        {
            if($this->permissions != NULL)
            {
                foreach ($this->permissions as $permissionRole)
                {
                    if($permissionRole->name == $permission)
                    {
                        return true;
                    }
                }
            }
        }
		return false;
	}

    /**
     * Add a permission to the current role
     * @param Permission $permission
     */
    public function allow(Permission $permission)
	{
        $permissionRole = new PermissionRole();
        $permissionRole->role_id = $this->id;
        $permissionRole->permission_id = $permission->id;
        $permissionRole->save();
	}

    /**
     * Deny permission to the current role
     * @param Permission $permission
     */
    public function deny(Permission $permission)
	{
		$permissionRole = PermissionRole::whereRoleId($this->id)->wherePermissionId($permission->id)->first();
        $permissionRole->delete();
	}
}
