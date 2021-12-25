<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class CastMemberControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

    public function testIndex(): void
    {
        $castMembers = CastMember::factory()->create();
        $response = $this->get(route('castMember.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$castMembers->toArray()]);
    }

    public function testShow(): void
    {
        $castMember = CastMember::factory()->create();
        $response = $this->get(route('castMember.show', [
            'castMember' => $castMember->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($castMember->toArray());
    }

    public function testInvalidationDataPut(): void
    {
        $castMember = CastMember::factory()->create();
        $response = $this->json('PUT', route('castMember.update', [
            'castMember' => $castMember->id,
            'name' => str_repeat('a', 256),
        ]));


        self::assertInvalidationJson(
            $response,
            ['name'],
            [
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            ]
        );
    }

    public function testInvalidationDataPost(): void
    {
        $response = $this->json('POST', route('castMember.store', [
            'name' => str_repeat('a', 256),
        ]));

        self::assertInvalidationJson(
            $response,
            ['name'],
            [
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            ]
        );
    }

    public function testInvalidationJson(): void
    {
        $response = $this->json('POST', route('castMember.store', []));
        self::assertInvalidationJson(
            $response,
            ['name'],
            [],
        );
    }

    public function testCreate(): void
    {
        $name = str_repeat('a1', 6);
        $response = $this->json('POST', route('castMember.store', [
            'name' => $name,
            'type' => 1,
        ]));

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'name' => $name,
            ]);
        self::assertKeysInResponseBody([
            'id',
            'name',
        ], $response);
    }

    public function testUpdate(): void
    {
        $castMember = CastMember::factory()->create();
        $name = 'dwq qd q';
        $response = $this->json('PUT', route('castMember.update', [
            'castMember' => $castMember->id,
        ]), ['name' => $name, 'type' => 1]);

        $response
            ->assertok()
            ->assertJsonFragment([
                'name' => $name,
                'type' => 1,
            ]);
        self::assertKeysInResponseBody([
            'name',
            'type',
        ], $response);
    }

    public function testDelete(): void
    {
        $castMember = CastMember::factory()->create();
        $response = $this->json('DELETE', route('castMember.destroy', [
            'castMember' => $castMember->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }

    public function testRemoveInvalidCastMember(): void
    {
        $response = $this->json('DELETE', route('castMember.destroy', [
            'castMember' => RamseyUuid::uuid4(),
        ]));
        $response->assertStatus(404);
    }
}
