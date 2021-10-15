<?php

namespace Database\Seeders;

use App\Models\CastMember;
use Illuminate\Database\Seeder;

class CastMemberSeeder extends Seeder
{
    public function run(): void
    {
        CastMember::factory()->count(30)->create();
    }
}
