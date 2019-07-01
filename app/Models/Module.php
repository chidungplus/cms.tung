<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = "modules";

    /**
     * List column name
     * @var array
     */
    protected $fillable = ['name', 'status', 'module_category_id', 'display_name', 'note'];

    /**
     * Deleted at
     * @var string
     */
    protected $dates = ['deleted_at'];

    /**
     * Check module exist in database
     *
     * @param string
     * @return boolean
     */
    public static function checkModuleExistsByNameInDatabase($name) {
        $check = self::where('name', $name)->count();
        return $check > 0 ? true : false;
    }

    /**
     * Format module name to lower case
     *
     * @param string
     * @return string
     */
    public static function formatNameToLowerCase($name) {
        return strtolower($name);
    }

    /**
     * Check module name invalid
     *
     * @param string
     * @return boolean
     */
    public static function checkModuleNameInvalid($name) {
        $check = preg_match('/^[a-z\_]+$/i', $name);
        return $check ? true : false ;
    }

    /**
     * Check modules has exists in folder modules
     *
     * @param string
     * @return boolean
     */
    public static function checkModuleExistsByNameInFolder($name) {
        return Storage::disk('module')->exists($name);
    }

    /**
     * Get path of folder template
     * @return string
     */
    public static function getPathFolderTemplate() {
        return base_path() . '/core';
    }

    /**
     * Get path of folder modules
     * @return string
     */
    public static function getPathFolderModules() {
        return base_path() . '/modules';
    }

    /**
     * Get all activated modules.
     *
     * @return object
     */
    public static function getActivateModules() {
        return Module::where('status', 1)->get();
    }

    /**
     * Notify check module exists in folder.
     *
     * @param string
     * @return string
     */
    public static function notifyCheckModuleExistsByNameInFolder($name) {
        return 'The module ' . $name . ' already exists.';
    }

    /**
     * Notify check module not exists in folder.
     *
     * @param string
     * @return string
     */
    public static function notifyCheckModuleNotExistsByNameInFolder($name) {
        return 'The module ' . $name . ' not already exists.';
    }

    /**
     * Activate module by name.
     *
     * @param string
     * @return object
     */
    public static function activateModuleByName($name) {
        return self::where('name', $name)->update( ['status' => 1]);
    }

    /**
     * Deactivate module by name.
     *
     * @param string
     * @return object
     */
    public static function deactivateModuleByName($name) {
        return self::where('name', $name)->update( ['status' => 0]);
    }

    /**
     * Notify activated module.
     *
     * @param string
     * @return string
     */
    public static function notifyActivateModule($name)
    {
        return '-- The module ' . $name . ' has been activate --';
    }

    /**
     * Notify deactivated module.
     *
     * @param string
     * @return string
     */
    public static function notifyDeactivateModule($name)
    {
        return '-- The module ' . $name . ' has been deactivate --';
    }

    /**
     * Notify check module name invalid.
     *
     * @return string
     */
    public static function notifyCheckModuleNameInvalid()
    {
        return 'The module name may only contain letters and "_" .';
    }

    /**
     * Notify create module
     *
     * @param string
     * @return string
     */
    public static function notifyCreateModule($name)
    {
        return '-- Module ' . $name . ' create success --';
    }

    /**
     * Delete module by name.
     *
     * @param string
     * @return string
     */
    public static function deleteModuleByName($name)
    {
        return self::where('name', $name)->delete();
    }

    /**
     * Notify delete module.
     *
     * @param string
     * @return string
     */
    public static function notifyDeleteModule($name)
    {
        return '-- Module ' . $name . ' delete success --';
    }

    /**
     * Notify activate to use
     * @return string
     */
    public static function notifyActiveToUse()
    {
        return '-- Please activate this module to use --';
    }

    public static function getListMenuFunction()
    {
        return self::where([
                        'module_category_id' => 1,
                        'status'             => 1
                    ])->orderBy('id', 'desc')->get();
    }

    public static function getListMenuManager()
    {
        return self::where([
                        'module_category_id' => 2,
                        'status'             => 1
                    ])->get();
    }

    public static function getListMenuPlugin()
    {
        return self::where([
                        'module_category_id' => 3,
                        'status'             => 1
                    ])->orderBy('id', 'desc')->get();
    }

    /**
     *
     */
    public static function getDisplayName($name)
    {
        return self::where('name', $name)->first()->display_name;
    }
}
