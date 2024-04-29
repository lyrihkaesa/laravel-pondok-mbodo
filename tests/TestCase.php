<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\PackageSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete("delete from users");
        DB::delete("delete from package_product");
        DB::delete("delete from category_package");
        DB::delete("delete from packages");
        DB::delete("delete from products");
        DB::delete("delete from categories");
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class, PackageSeeder::class]);
    }
}
