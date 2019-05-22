<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Model
 *
 * @property string $name
 */
class User extends Model
{
    protected $table = 'users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userLogs() {
        return $this->hasMany(UserLog::class);
    }
}