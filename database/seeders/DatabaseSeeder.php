<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Export;
use App\Models\Exporter;
use App\Models\Import;
use App\Models\Importer;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductImage;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'Admin',
        ]);
        $admin->assignRole('Admin');

        $notAdmin = User::factory()->create([
            'name' => 'NotAdmin',
            'email' => 'notadmin@example.com',
            'password' => 'Admin',
        ]);
        $notAdmin->assignRole('notAdmin');


        Group::factory(3)->create();
        Product::factory(5)->create();
        // ProductImage::factory(7)->create(); #TODO

        Exporter::factory(5)->create();
        Importer::factory(5)->create();

        Export::factory(10)->create();
        Import::factory(10)->create();
        
        foreach (Product::all() as $product) {
            $product->calculateCurrentQuantityForFactory();
        }
    }
}
