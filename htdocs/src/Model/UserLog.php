<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App\Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class UserLog extends Model
{
    protected $table = 'user_logs';

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}