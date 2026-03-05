<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterStatus extends Model
{
    protected $table = 'master_status';
    protected $primaryKey = 'id_status';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_status',
        'nama_status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'id_status', 'id_status');
    }
}
