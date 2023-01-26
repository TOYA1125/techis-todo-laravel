<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //下のタスク保持のコードでuser_idの紐づけができたため、引数のほうは削除
    protected $fillable = ['name'];

    /**
     * タスクを保持するユーザーの取得
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
