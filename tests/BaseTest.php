<?php

/**
 * Class BaseTest
 * @author Valentin PRUGNAUD <valentin@whatdafox.com>
 * @url http://www.foxted.com
 */
abstract class BaseTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        $database = $this->app->make('config')->get('database.connections.sqlite.database');
        $file = $this->app->make('files')->exists($database);
        if($file) $this->app->make('files')->delete($database);
        $this->app->make('files')->put($database, '');
        $this->app->make('artisan')->call('migrate', [
                                       '--env' => 'testing',
                                       '--package' => 'foxted/permissions'
                                   ]);

    }
    
} 