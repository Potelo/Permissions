# Permissions

[![Build Status](https://travis-ci.org/foxted/Permissions.svg?branch=master)](https://travis-ci.org/foxted/Permissions)

Laravel 4 package for handling user roles and permissions based on [mrterryh/permissions](https://github.com/mrterryh/Permissions) package.

## Installation

Add the following to the require key of your composer.json file:

    "foxted/permissions": "dev-master"
    
        
Run `$ composer update`.

Navigate to your `config/app.php` file and add `'Foxted\Permissions\PermissionsServiceProvider'` to the `$providers` array.

Create the tables by running `$ php artisan migrate --package="foxted/permissions"`. If you don't have any user table, it will create one basic table for you.

Navigate to your `models/User.php` file and add the `Foxted\Permissions\Can` trait below the class decloration line:

    class User extends Eloquent implements UserInterface, RemindableInterface 
    {
        use Foxted\Permissions\Can;
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

Quickly create a role using :  `$ php artisan roles:add <role_name>`

### Attach permissions to a role

Quickly attach permissions to a role using `roles:permissions`

Ex. : `$ php artisan roles:permissions Admin read_posts,create_posts,edit_posts,delete_posts`

## License

Permissions is licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Thank you!

Thank you Mrterryh for initiating this package. Thank you if you're using this package.
