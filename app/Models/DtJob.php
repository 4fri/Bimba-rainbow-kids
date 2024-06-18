<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class DtJob extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $appends = ['jobHashId'];

    public function getJobHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
