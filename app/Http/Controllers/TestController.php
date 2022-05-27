<?php

namespace App\Http\Controllers;

use Spatie\Dns\Dns;

class TestController extends Controller
{
    public function test()
    {
        // $data = shell_exec('dig +short stackoverflow.com
        // ');

        // $valid = preg_match('\b((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.|$)){4}\b', $data);
        $dns = new Dns();

        $ARecord = $dns->getRecords('stackoverflow.com'); // returns all available dns records

        dd($ARecord);
    }
}
