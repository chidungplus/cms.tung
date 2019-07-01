<?php

namespace Zent\SystemLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemLog extends Model
{
    use SoftDeletes;
    /*
     * Tables
     */
    
    protected $tables = "system_logs";

    /*
     * Fillables
     */
    
    protected $fillable = ['name', 'content', 'status'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];
}
