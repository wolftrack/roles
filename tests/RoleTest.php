<?php

namespace Wolfpack\Roles\Test;

use Wolfpack\Roles\Models\Role;
use Wolfpack\Roles\Exceptions\RoleAlreadyExists;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
//    use RefreshDatabase;

    protected $validParams = [
        'name' => 'Example Role',
    ];

    /** @test */
    public function it_has_a_name()
    {
        $role = app(Role::class)->create([
            'name' => 'Example Role',
        ]);

        $this->assertEquals('Example Role', $role->name);
    }

    /** @test */
    public function it_sets_a_slug()
    {
        $role = app(Role::class)->create([
            'name' => 'Example Role',
        ]);

        $this->assertEquals('example-role', $role->slug);
    }

    /** @test */
    public function roles_need_to_have_a_unique_name()
    {
        $this->expectException(RoleAlreadyExists::class);

        $name = 'Example Role';
        app(Role::class)->create(['name' => $name]);
        app(Role::class)->create(['name' => $name]);

        $this->assertEquals(1, app(Role::class)->count());
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $role = app(Role::class)->create($this->validParams);
        $found_role = app(Role::class)->findById($role->id);

        $this->assertTrue($found_role instanceof Role);
        $this->assertEquals($role->id, $found_role->id);
    }

    /** @test */
    public function it_is_retrievable_by_name()
    {
        $role = app(Role::class)->create(['name' => 'Example Role']);
        $found_role = app(Role::class)->findByName('Example Role');

        $this->assertTrue($found_role instanceof Role);
        $this->assertEquals($role->id, $found_role->id);
    }

    /** @test */
    public function it_is_retrievable_by_slug()
    {
        $role = app(Role::class)->create(['name' => 'Example Role']);
        $found_role = app(Role::class)->findBySlug('example-role');

        $this->assertTrue($found_role instanceof Role);
        $this->assertEquals($role->id, $found_role->id);
    }
}
