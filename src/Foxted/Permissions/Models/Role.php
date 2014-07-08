<?php namespace Foxted\Permissions;

/**
 * Class Role
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class Role extends \Eloquent
{
    protected $table = "roles";
    protected $guarded = [ 'id' ];

    /**
     * Permissions relationship
     * @return mixed
     */
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
		$permission = Permission::whereName($permission)->first();

        if($permission != NULL)
        {
            return $this->permissions->contains($permission->id);
        }
	}

    /**
     * Add a permission to the current role
     * @param Permission $permission
     */
    public function allow(Permission $permission)
    {
        if( !$this->permissions()->get()->contains( $permission->id ) )
            $this->permissions()->attach( $permission );
	}

    /**
     * Deny permission to the current role
     * @param Permission $permission
     */
    public function deny(Permission $permission)
	{
        if( $this->permissions()->get()->contains( $permission->id ) )
            $this->permissions()->detach( $permission );
	}
}
