<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjekRetribusi extends Model
{
    protected $guarded = [];

    public function registers()
    {
        return $this->hasMany(Register::class, 'objek_retribusi_id');
    }
}
