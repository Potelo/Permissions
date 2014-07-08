# Permissions

[![Build Status](https://travis-ci.org/foxted/Permissions.svg?branch=master)](https://travis-ci.org/foxted/Permissions)
[![Latest Stable Version](https://poser.pugx.org/foxted/permissions/v/stable.svg)](https://packagist.org/packages/foxted/permissions) 
[![Total Downloads](https://poser.pugx.org/foxted/permissions/downloads.svg)](https://packagist.org/packages/foxted/permissions) 
[![Latest Unstable Version](https://poser.pugx.org/foxted/permissions/v/unstable.svg)](https://packagist.org/packages/foxted/permissions) 
[![License](https://poser.pugx.org/foxted/permissions/license.svg)](https://packagist.org/packages/foxted/permissions)

Laravel 4 package for handling user roles and permissions.

## Installation

Add the following to the require key of your composer.json file:

    "foxted/permissions": "dev-master"
    
        
Run `$ composer update`.

Navigate to your `config/app.php` file and add `'Foxted\Permissions\PermissionsServiceProvider'` and `'Way\Generators\GeneratorsServiceProvider'` to the `$providers` array.

Run `$ php artisan config:publish foxted/permissions`

Edit the `app/config/packages/foxted/config.php` to customize your tables names and fields. Ex. :


    <?php

    return [
        'tables' => [
            'users'           => 'test_users',
            'permissions'     => 'test_permissions',
            'roles'           => 'test_roles',
            'permission_role' => 'test_role_permission'
        ],
        'fields' => [
            'users' => [
                'extra:string'
            ],
            'permissions' => [
                'extra:string'
            ],
            'roles' => [
                'extra:string'
            ]
        ]
    ];

Run `$ php artisan foxted:migrations` to generate the migration files

**Be careful if you change the tables names, you should extend each model of the package and change the `$table` property to match yours!**

Delete the original `models/User.php` file and create a new one that extends `Foxted\Permissions\User` like this :

    class User extends Foxted\Permissions\User
    {

    }

If you want to modify the migrations, you can publish them by running : `$ php artisan migrate:publish foxted/permission`
        
## Usage

Create a new role:

    $role = new \Foxted\Permissions\Role();
    $role->name = 'Administrator';
    $role->save();
    
Create a new permission:

    $permission = new \Foxted\Permissions\Permission();
    $permission->name = 'read_articles';
    $permission->display_name ='Can read articles';
    $permission->save();
    
Attach the permission to the role:
  
    $role->allow($permission);
    
Create a user:

    $user = new User;
    $user->role_id = 1;
    $user->save();
    
And you're set! To check if a user has a permission:

    $user = User::find(1);

    if ($user->can('read_articles'))
        echo 'The user with the ID of "1" can read articles';
        
To check if the current authenticated user has a permission:

    if (Auth::user()->can('read_articles'))
        echo 'The current authenticated user can read articles';

## Console tools

For your conveniance, a few console tools exists :

### Add role

Quickly create a role using :  `$ php artisan foxted:role <role_name>`

### Delete a role

Quickly delete a role using : `$ php artisan foxted:role <role_name> --delete`

### Attach permissions to a role

Quickly attach permissions to a role using `foxted:role <role_name> --permissions="First permission,
Second permission"`

Ex. : `$ php artisan foxted:role Admin --permissions="Read post, Create posts, Edit posts, Delete posts"`

## License

Permissions is licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Thank you!

Thank you Mrterryh for initiating this package. Thank you if you're using this package.
