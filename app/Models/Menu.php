<?php

namespace App\Models;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['menuHashId'];

    public function getMenuHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
