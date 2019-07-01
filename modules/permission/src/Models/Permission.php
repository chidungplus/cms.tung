<?php

namespace Zent\Permission\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /*
     * Tables
     */
    
    protected $tables = "permissions";

    /*
     * Fillables
     */
    
    protected $fillable = ['name', 'display_name', 'description'];
}
