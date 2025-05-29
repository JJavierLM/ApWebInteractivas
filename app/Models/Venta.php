<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Venta extends Model
{

    protected $fillable = ['nombre_comprador', 'fecha', 'hora', 'auto_id', 'user_id'];
    
    public function auto()
{
    return $this->belongsTo(Auto::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}


