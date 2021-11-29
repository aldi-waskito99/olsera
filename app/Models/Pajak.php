<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    
    use HasFactory;

    protected $table = 'pajaks';
    protected $fillable = [
        'item_id','name','rate',
    ];

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
