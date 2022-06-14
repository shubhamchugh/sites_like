<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = Settings::where('key', 'permalink_prefix')->first();

        if (!empty($records)) {
            echo "Already have settings";
            die;
        }

        Settings::firstOrCreate([
            'key'   => 'permalink_prefix',
            'value' => 'similar',
        ]);
    }
}
