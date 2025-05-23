<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    protected $fillable = [
        'title',
        'description',
        'is_completed',
    ];

    protected $cast = [
        'title' => 'string',
        'description' => 'string',
        'is_completed' => 'boolean',
    ];

    public $timestamps = true;
}
