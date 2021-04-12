<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendLid extends Model
{
    use HasFactory;
    protected $table = "sent_lid";
    public $timestamps = false;

}
