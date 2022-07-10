<?php 
namespace Betalectic\Car;

use Log;
use Betalectic\Car\Models\Comment;
use Illuminate\Support\Facades\DB;
use Betalectic\Car\Models\ActionAssignedUser;

class CarComments
{
    public function __construct()
    {
    }

    public function getComments($module = NULL, $user = NULL)
    {
        $comments = DB::table('car_comments')
                        ->whereNull('deleted_at')
                        ->get();
        
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

        public function addComment($comment, $module, $user, $isActionComment=FALSE, $actionId=NULL, $extra_filter = NULL)
    {
        if($isActionComment) {
            $assignedRecord = ActionAssignedUser::where('action_id', $actionId)
                                            ->where('user_id', $user->getKey())
                                            ->first();
        }

        $data['module_id'] = $module->getKey();
        $data['module_type'] = get_class($module);
        $data['user_id'] = $user->getKey();
        $data['comment'] = $comment;
        $data['extra_filter'] = $extra_filter ? $extra_filter : null;
        // $data['action_assigned_comment_id'] =  $assignedRecord ? $assignedRecord->id : NULL;
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

    public function resolveComments($module=NULL)
    {
        $module_id = $module->getKey();
        $module_type = get_class($module);
        
        $comments = DB::table('car_comments')
                        ->where('module_type', $module_type)
                        ->where('module_id', $module_id)
                        ->where('is_resolved', FALSE)
                        ->update(['is_resolved' => true]);

    }
}