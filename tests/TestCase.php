<?php

namespace Machete\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->migrate();
    }

    /**
     * Sets up the in-memory database for testing purposes.
     */
    protected function setUpDatabase(): void
    {
        $db = new DB;
        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $db->setAsGlobal();
        $db->bootEloquent();
    }

    /**
     * Migrate the database for testing purposes.
     */
    protected function migrate(): void
    {
        DB::schema()->dropAllTables();

        DB::schema()->create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::schema()->create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->timestamps();
        });
    }
}
