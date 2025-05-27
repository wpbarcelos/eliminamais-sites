<?php

namespace Database\Seeders;

use App\Models\Subdomain;
use App\Models\Page;
use App\Models\Component;
use App\Models\Video;
use App\Models\Textolivre;
use App\Models\Imagem;
use App\Models\User; // Assuming you still want to seed a User
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Optional: if you want multiple random users

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Subdomain::factory(2)->create()->each(function ($subdomain) {
            Page::factory(5)->create(['subdomain_id' => $subdomain->id])->each(function ($page) {
                // Create 1 Imagem
                $imagem = Imagem::factory()->create();
                Component::factory()->create([
                    'page_id' => $page->id,
                    'type' => 'imagem',
                    'componentable_id' => $imagem->id,
                    'componentable_type' => Imagem::class,
                    'order' => 1,
                ]);

                // Create 1 TextoLivre
                $textolivre = Textolivre::factory()->create();
                Component::factory()->create([
                    'page_id' => $page->id,
                    'type' => 'textolivre',
                    'componentable_id' => $textolivre->id,
                    'componentable_type' => Textolivre::class,
                    'order' => 2,
                ]);

                // Create 4 Videos
                for ($i = 0; $i < 4; $i++) {
                    $video = Video::factory()->create();
                    Component::factory()->create([
                        'page_id' => $page->id,
                        'type' => 'video',
                        'componentable_id' => $video->id,
                        'componentable_type' => Video::class,
                        'order' => 3 + $i,
                    ]);
                }
            });
        });
    }
}
