<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';
    protected  $fillable = [
        'is_complete',
        'is_started',
        'origin',
        'destination',
        'distinction_name',
        'driver_location',
    ];

    public  function  user(){
        return $this->belongsTo(User::class);
    }
    public  function  driver(){
        return $this->belongsTo(Driver::class);
    }
}
