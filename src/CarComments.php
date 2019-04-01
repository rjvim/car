<?php 
namespace Betalectic\Car;

use Betalectic\Car\Models\Comment;
use Illuminate\Support\Facades\DB;
use Log;

class CarComments
{
    public function __construct()
    {
    }

    public function getComments($module = NULL, $user = NULL)
    {
        $comments = DB::table('car_comments')->get();
        
        if($module) {
            $module_id = $module->getKey();
            $module_type = get_class($module);

            $comments = $comments->where('module_type', $module_type)
                                ->where('module_id', $module_id);
        }
        if($user) {
            $comments = $comments->where('user_id', $user->id);
        }

        return $comments;
    }

    public function addComment($comment, $module, $user)
    {
    	$data['module_id'] = $module->getKey();
    	$data['module_type'] = get_class($module);
    	$data['user_id'] = $user->getKey();
    	$data['comment'] = $comment;

    	$comment = Comment::create($data);

    	return $comment;
    }


    public function updateComment($data, $commentId)
    {
        $oldComment =  Comment::find($commentId);
    	$oldComment->comment = $data;
    	$oldComment->save();

    	return $oldComment;
    }

    public function deleteComment($commentId)
    {
        $comment =  Comment::find($commentId);
    	$comment->delete();
    }
}