<?php namespace Foxted\Permissions;

/**
 * Class PermissionRole
 * @package Foxted\Permissions
 * @author  Valentin Prugnaud <valentin@sccnorthwest.com>
 */
class PermissionRole extends \Eloquent
{
	protected $table = 'permission_role';
	protected static $stored = array();

    /**
     * Permission relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
	{
		return $this->belongsTo('\Foxted\Permissions\Permission');
	}

    /**
     * Get role permissions
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function role($id)
	{
		if (!isset(static::$stored[$id]))
			static::$stored[$id] = PermissionRole::with('permission')->where('role_id', '=', $id)->get();
		
		return static::$stored[$id];
	}
}