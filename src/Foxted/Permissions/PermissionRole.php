<?php namespace Foxted\Permissions;

/**
 * Class PermissionRole
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class PermissionRole extends \Eloquent
{
	protected $table = 'permission_role';
    protected $guarded = ['id'];
}