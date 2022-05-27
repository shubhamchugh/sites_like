<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'A',
        'AAAA',
        'CNAME',
        'NS',
        'SOA',
        'MX',
        'SRV',
        'TXT',
        'DNSKEY',
        'CAA',
        'NAPTR',

    ];
}
