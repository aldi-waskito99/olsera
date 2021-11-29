<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    use HasFactory;

    protected $table = 'items';
    protected $fillable = [
        'nama',
    ];

    public function pajak(){
        return $this->hasMany('App\Models\Pajak');
    }
}
