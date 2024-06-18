<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class DtDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $appends = ['documentHashId'];

    public function getDocumentHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
