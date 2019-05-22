<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App\Model
 *
 * @property string $name
 */
class UserLog extends Model
{
    protected $table = 'user_logs';

    public function user() {
        return $this->belongsTo(User::class);
    }
}