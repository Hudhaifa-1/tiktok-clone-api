<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'comment' => 'required',
        ]);

        try {

            $comment = new Comment();
            $user = new UsersCollection(User::where('id', auth()->user()->id)->get());

            $comment->post_id = $request->input('post_id');
            $comment->user_id = auth()->user()->id;
            $comment->text    = $request->input('comment');
            $comment->save();

            $modifedComment = [
                'id' => $comment->id,
                'text' => $comment->text,
            ];

            return response()->json(['success' => 'OK', 'comment' => $modifedComment, 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            $comment->delete();

            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
