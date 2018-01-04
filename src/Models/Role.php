<?php

namespace TCG\Voyager\Models;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\RelationshipCache;

class Role extends Model
{
    use RelationshipCache;

    protected $guarded = [];
    protected static $relationships = [];

    public function users()
    {
        return $this->belongsToMany(Voyager::modelClass('User'), 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Voyager::modelClass('Permission'));
    }

    public static function getRelationship($id)
    {
        if (!isset(self::$relationships[$id])) {
            self::$relationships[$id] = self::find($id);
        }

        return self::$relationships[$id];
    }
}
