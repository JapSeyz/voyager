<?php

namespace TCG\Voyager\Policies;

use TCG\Voyager\Contracts\User;
use TCG\Voyager\Models\DataType;

class MenuItemPolicy extends BasePolicy
{
    protected static $datatypes = [];

    /**
     * Check if user has an associated permission.
     *
     * @param User   $user
     * @param object $model
     * @param string $action
     *
     * @return bool
     */
    protected function checkPermission(User $user, $model, $action)
    {
        $regex = str_replace('/', '\/', preg_quote(route('voyager.dashboard')));
        $slug = preg_replace('/'.$regex.'/', '', $model->link(true));
        $slug = str_replace('/', '', $slug);

        if (! isset(self::$datatypes[$slug])) {
            self::$datatypes[$slug] = DataType::where('slug', $slug)->first();
        }
        if ($str = self::$datatypes[$slug]) {
            $slug = $str->name;
        }

        if ($slug == '') {
            $slug = 'admin';
        }

        return $user->hasPermission('browse_'.$slug);
    }
}
