<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class DtReligion extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $appends = ['religionHashId'];

    public function getReligionHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
