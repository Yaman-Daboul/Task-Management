<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
// use Exception;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $tasks = Task::all();
        $tasks = $user->tasks;

        return response()->json([$tasks, $user], 200);
    }

    // function store(Request $request)
    // نعدل البرامتر لكي يذهب للتحقق اولا
    public function store(StoreTaskRequest $request)
    {
        // $task = Task::create(
        //     [
        //         'title' => $request->title,
        //         'description'=>$request->description,
        //         'priority'=>$request->priority
        //     ]
        // );
        // $validated = $request->validate([
        //     'title'=>'required |string |max:40 ',
        //     'description'=>'nullable |string |max:100 |',
        //     'priority'=>'required |Integer|min:1 |max:5'
        // ]);قمنا بنقل التحقق لملف خاص
        $user = Auth::user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $task = Task::create($validatedData);
        // اي عبئ فقط الحقول التي تم التحقق منها

        // $task = Task::create($request->all());
        // خطيرة يمكن ان يقوم المهاجم بحقن تعليمات مثل جعل نفسه ادمن
        // لكن بجميع الاحوال هناك طبقة حماية اخرى وهي تحديد الحقول القابلة للتعبئة في المودل $fillable

        // $task = Task::create($request->only('...'));
        // أكثر أمانا تحصر التعديل ضمن الحقول المسموح بها فقط وهي تعادل امان السنتاكس الذي اعتمدناه فوق
        return response()->json(['task' => $task, 'user_id' => $user->id], 200);
        // عند استخدام طريقة التحقق اليدوي
        // if($task)
        //     return response()->json($task, 200);
        // else
        //     return response()->json(['message'=>'the validation is failed'], 422);
    }

    public function update(UpdateTaskRequest $request, int $id)
    {
        $user = Auth::user();
        $task = Task::query()->find($id);
        if ($task->user_id == $user->id) {
            // إذا أرسل المستخدم حقل password ولكنه تركه فارغاً: سيفشل الفاليديشن لأن الحقل موجود ولكنه لا يطابق شرط string أو min:8.لذا استخدما sometimes
            $task->update($request->validated());

            // $task->update([$request]);
            return response()->json($task);
        } else {
            return response()->json(['message' => 'Unauthorized'], 400);
        }
        // اذا اردت يوجد دالة Task::updateOrCreate()
    }

    public function show(int $id)
    {

        if ($task = Task::query()->find($id)) {
            return response()->json($task, 200);
        } else {
            return response()->json(['message' => 'Please enter a valid id'], 400);
        }
    }

    public function destroy(int $id)
    {
        if ($task = Task::query()->find($id)) {
            $task->delete();

            return response()->json(['message' => 'Done'], 200);
        } else {
            return response()->json(['message' => 'The id is not found!'], 400);
        }
        // Task::destroy($id);
        // //بطبق عالمودل مباشرة دون فحص وجود العنصر ودون عمل instance منه
    }

    public function getTaskUser(int $id)
    {
        $taskUser = Task::find($id)->user;

        return response()->json($taskUser);
    }

    public function addCategoriesToTask(Request $request, int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);

        return response()->json($task, 200);

    }

    public function getCategoryTasks(int $categoryId)
    {
        $tasks = Category::findOrFail($categoryId)->tasks;

        return response()->json($tasks, 200);
    }

    public function getTaskCategories(int $taskId)
    {
        $categories = Task::findOrFail($taskId)->categories;

        return response()->json($categories, 200);
    }

    public function getTasksAll()
    {
        $tasks = Task::all();
        // $tasks = $user->tasks;

        return response()->json($tasks, 200);
    }

    public function getTasksOrdered(Request $request)
    {

        // 1. جلب اتجاه الترتيب من الرابط مع وضع قيمة افتراضية
        // $direction = strtolower($request->query('direction', 'desc'));
        $direction = strtolower(trim($request->input('direction', 'desc')));

        // 2. التحقق من أن القيمة المدخلة آمنة (لحماية قاعدة البيانات من SQL Injection)
        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // 3. تحديد ترتيب القيم بناءً على الاتجاه المطلوب
        $order = ($direction === 'asc')
            ? "'low', 'medium', 'high'"
            : "'high', 'medium', 'low'";

        $tasks = Auth::user()
            ->tasks()
            // ->orderByRaw("FIELD(priority,'high','medium','low')")
            ->orderByRaw("FIELD(priority, $order)")
            ->get();

        return response()->json($tasks, 200);
    }

    public function addToFavorites(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        if ($task) {
            Auth::user()->favorites()->syncWithoutDetaching($taskId);
        }

        return response()->json(['messsage' => 'The task added to favorites successfully'], 200);
    }

    public function removeFromFavorites(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        if ($task) {
            Auth::user()->favorites()->detach($taskId);
        }

        return response()->json(['messsage' => 'The task removed from favorites successfully'], 200);
    }

    public function getFavoriteTasks()
    {
        $tasks = Auth::user()->favorites()->get();
        if ($tasks->isEmpty()) {
            return response()->json("there isn't any task in the favorites", 200);
        }

        return response()->json($tasks, 200);
    }

    // public function delete(int $id)
    // {
    //     try {
    //         $task = Task::findorFail($id);
    //         $task->delete();

    //         return response()->json('Task Deleted succuessfully ', 200);
    //     } catch (ModelNotFoundException $m) {

    //         return response()->json([
    //             'error' => 'Task Not found',
    //             'details' => $m->getMessage(),
    //         ], 404);
    //     } catch (Exception $m) {
    //         return response()->json([
    //             'error' => 'something went wrong while deleteing the task',
    //             'details' => $m->getMessage(),
    //         ], 404);
    //     }
    // }
}
