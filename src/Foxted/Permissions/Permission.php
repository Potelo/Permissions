<?php namespace Foxted\Permissions;

/**
 * Class Permission
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class Permission extends \Eloquent
{
	protected $table = 'permissions';
    protected $guarded = ['id'];

    /**
     * Role relationship
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('\Foxted\Permissions\Role');
    }
}