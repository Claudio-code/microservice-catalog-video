<?php

namespace Tests\Feature\Models;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CastMemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testList(): void
    {
        CastMember::factory()->create();
        $castMemberList = CastMember::all();

        self::assertCount(1, $castMemberList);
    }

    public function testSoftDelete(): void
    {
        $castMember = CastMember::factory()->create();
        $castMember->refresh();
        CastMember::destroy([$castMember->id]);
        $castMemberList = CastMember::onlyTrashed()->get()->toArray();

        self::assertCount(1, $castMemberList);
        self::assertCount(0, CastMember::all());
    }

    public function testUpdate(): void
    {
        $name = 'random name';
        $castMember = CastMember::factory()->create();
        $castMember->refresh();
        $castMember->update(['name' => $name]);

        self::assertEquals($name, $castMember->name);
    }

    public function testCreate(): void
    {
        $data = [
            'name' => 'test',
            'type' => 1,
        ];
        $castMember = CastMember::factory($data)->create();
        $castMember->refresh();

        self::assertEquals($data['name'], $castMember->name);
        self::assertEquals($data['type'], $castMember->type);
        self::assertMatchesRegularExpression(
            pattern: self::REGEX_TO_TEST_UUID4,
            string: $castMember->id
        );
    }

    public function testDelete(): void
    {
        $castMember = CastMember::factory()->create();
        $castMember->refresh();
        $castMember->delete();
        $castMemberList = CastMember::all()->toArray();

        self::assertEquals(0, count($castMemberList));
    }
}
