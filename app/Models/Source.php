<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $table = 'backup_server_sources';

    public function backups()
    {
        return $this->hasMany(Backup::class);
    }

    protected function lastBackupCompletedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->backups()->latest()->first()->completed_at)->diffForHumans()
        );
    }

    protected function numberOfBackups(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->backups()->count()
        );
    }
}
