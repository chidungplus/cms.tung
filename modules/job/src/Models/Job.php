<?php

namespace Zent\Job\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    /*
     * Tables
     */
    
    protected $table = "jobs";

    /*
     * Fillables
     */
    
    protected $fillable = ['name', 'content', 'status'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];
}
