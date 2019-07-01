<?php

namespace Zent\Layout\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    /*
     * Tables
     */
    
    protected $tables = "layouts";

    /*
     * Fillables
     */
    
    protected $fillable = ['name', 'note'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];
}
