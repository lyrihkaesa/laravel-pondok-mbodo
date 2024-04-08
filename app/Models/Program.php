<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
    ];

    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }
}
