<?php

namespace Wolfpack\Roles\Test;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Wolfpack\Roles\Exceptions\PermissionAlreadyExists;
use Wolfpack\Roles\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $validParams = [
        'name' => 'Example Permission',
    ];

    /** @test */
    public function it_has_a_name()
    {
        $permission = app(Permission::class)->create([
            'name' => 'Example Permission',
        ]);

        $this->assertEquals('Example Permission', $permission->name);
    }

    /** @test */
    public function it_sets_a_slug()
    {
        $permission = app(Permission::class)->create([
            'name' => 'Example Permission',
        ]);

        $this->assertEquals('example-permission', $permission->slug);
    }

    /** @test */
    public function permissions_need_to_have_a_unique_name()
    {
        $this->expectException(PermissionAlreadyExists::class);

        $name = 'Example Permission';
        app(Permission::class)->create(['name' => $name]);
        app(Permission::class)->create(['name' => $name]);

        $this->assertEquals(1, app(Permission::class)->count());
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $permission = app(Permission::class)->create($this->validParams);
        $found_permission = app(Permission::class)->findById($permission->id);

        $this->assertTrue($found_permission instanceof Permission);
        $this->assertEquals($permission->id, $found_permission->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $permission = app(Permission::class)->create(['name' => 'Example Permission']);
        $found_permission = app(Permission::class)->findByName('Example Permission');

        $this->assertTrue($found_permission instanceof Permission);
        $this->assertEquals($permission->id, $found_permission->id);
    }

    /** @test */
    public function it_is_retrievable_by_slug()
    {
        $permission = app(Permission::class)->create(['name' => 'Example Permission']);
        $found_permission = app(Permission::class)->findBySlug('example-permission');

        $this->assertTrue($found_permission instanceof Permission);
        $this->assertEquals($permission->id, $found_permission->id);
    }
}
