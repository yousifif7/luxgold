<?php
// app/Models/FollowedProvider.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowedCleaner extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'cleaner_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}