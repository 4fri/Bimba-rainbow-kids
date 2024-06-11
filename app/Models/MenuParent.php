<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class MenuParent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['menuParentHashId'];

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function child()
    {
        return $this->hasOne(MenuParent::class, 'child_id', 'id');
    }

    public function getMenuParentHashIdAttribute()
    {
        return Hashids::encode($this->id);
    }
}
