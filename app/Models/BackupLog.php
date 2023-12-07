<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\BackupServer\Models\Source;

class BackupLog extends Model
{
    use HasFactory;

    protected $table = 'backup_server_backup_log';

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function backup()
    {
        return $this->belongsTo(Backup::class);
    }
}
