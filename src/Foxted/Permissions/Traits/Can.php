<?php namespace Foxted\Permissions;

/**
 * Trait Can
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
trait Can
{
    /**
     * Role relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
	{
		return $this->belongsTo('\Foxted\Permissions\Role', 'roles_id');
	}

    /**
     * Check if the user role has specified permission
     * @param $permission
     * @return bool
     */
    public function can($permission)
	{
		return $this->role->can($permission);
	}
}