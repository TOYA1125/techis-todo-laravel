<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

use App\Repositories\TaskRepository;

class TaskController extends Controller
{

    /**
     * クラスリポジトリ
     *
     * @var TaskRepository
     */
    protected $tasks;

    // クラスの最初にコンストラクタを書く(初期化処理用のメソッド)
    /**
     * コンストラクタ
     *
     * @return void
     */
    //コンストラクタで受け取れるように、引数を渡す
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        // リポジトリの引数を代入するコード
        $this->tasks = $tasks;
    }


    /**
     * タスク一覧
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$tasks = Task::orderBy('created_at', 'asc')->get(); 書き換える
        // userで認証済みのユーザーを取得、そのユーザーが保持するタスク情報を取得
        //$tasks = $request->user()->tasks()->get();
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * タスク登録
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        // タスク作成
        // Task::create([
        //     'user_id' => 0,
        //     'name' => $request->name
        // ]);
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * タスク削除
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task); //ユーザー自身のタスクのみ削除可能

        $task->delete();
        return redirect('/tasks');
    }
}
