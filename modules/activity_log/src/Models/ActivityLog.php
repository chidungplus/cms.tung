<?php

namespace Zent\ActivityLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;
    /*
     * Tables
     */
    
    protected $table = "laravel_logger_activity";

    /*
     * Fillables
     */
    
    protected $fillable = ['description', 'userType', 'userId', 'route', 'ipAddress', 'userAgent', 'locale', 'referer', 'methodType'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];
}
