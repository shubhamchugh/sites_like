<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SourceDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'is_scrape',
    ];
}