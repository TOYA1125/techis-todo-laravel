<?php

namespace App\Policies;

use App\Models\User;
use APP\Models\Task; //policyはTaskモデルと紐づけることで使用可能
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // デストロイメソッドを追加
    /**
     * 指定されたユーザーのタスクのとき削除可能
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
