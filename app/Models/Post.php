<?php

namespace App\Models;

use App\Models\DnsDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'dns_details_id',
        'title',
        'slug',
        'domain_title',
        'image',
        'domain_description',
        'ip',
        'status',
        'is_index',
        'post_type',
        'content',
    ];

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'technology_post_relations');
    }

    public function DnsDetails_relation()
    {
        return $this->hasOne(DnsDetail::class, 'post_id', 'id');
    }
}
