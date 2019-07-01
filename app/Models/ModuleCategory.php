<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleCategory extends Model
{
    protected $table = 'module_categories';

    protected $fillable = ['name', 'note'];
}
