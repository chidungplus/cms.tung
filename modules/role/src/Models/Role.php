<?php

namespace Zent\Role\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table="roles";

    protected $fillable = [
        'name', 'display_name', 'description'
    ];
}
