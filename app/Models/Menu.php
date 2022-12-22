<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function Order(){
        return $this->hasMany('App\Models\Order');
    }

    protected $guarded = [];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'char';
}
