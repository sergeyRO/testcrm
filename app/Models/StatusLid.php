<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLid extends Model
{
    use HasFactory;
    protected $table = "status_lids";
    public $timestamps = false;
}
