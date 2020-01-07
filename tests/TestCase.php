<?php

namespace Wolfpack\Roles\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Wolfpack\Roles\RolesServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        $this->artisan('migrate')->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            RolesServiceProvider::class,
        ];
    }
}
