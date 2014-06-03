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
}