<?php

use App\Models\Api\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create ([
            'name' => 'Tag Name 1',
        ]);

        Tag::create ([
            'name' => 'Tag Name 2',
        ]);
    }
}
