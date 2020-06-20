<?php

namespace App\Http\Middleware;

use App\Models\{Todo, User};
use Closure;

class CheckTodo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var Todo $todo
         */
        $todo = Todo::query()->find($request->id);
        /**
         * @var User $user
         */
        $user = \auth()->user();

        if ($user->id === $todo->user_id) {
            $request->attributes->add(['todo' => $todo]);

            return $next($request);
        } else {
            return response()->json([
                'error'   => true,
                'message' => 'You have not access to this todo'
            ]);
        }
    }
}
