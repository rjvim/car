<?php 
namespace Betalectic\Car;

use Log;
use App\User;
use Betalectic\Car\CarComments;
use Betalectic\Car\Models\Action;
use Illuminate\Support\Facades\DB;
use Betalectic\Car\Models\ActionAssignedUser;

class CarActions
{
    public function __construct()
    {
    }

    public function getActions($module = NULL, $user = NULL)
    {
        if($module) {
            $actions = DB::table('car_actions');

            $module_id = $module->getKey();
            $module_type = get_class($module);

            $fetchedActions = $actions->where('module_type', $module_type)
                                ->where('module_id', $module_id)
                                ->get();
        }
        if($user) {
            $assignedActions = DB::table('car_actions')
                ->rightJoin('car_action_assigned_users', 'car_actions.id', '=', 'car_action_assigned_users.action_id')
                ->select('car_actions.*', 'car_action_assigned_users.user_id');

            $fetchedActions = $assignedActions->where('user_id', $user->id)
                                ->get();
        }

        return $fetchedActions;
    }

    public function addActionToModule($module, $owner, $action, $actionIdentifier, $status, $needsReview=FALSE, $rule)
    {
        $action = Action::updateOrCreate(
            ['module_id' => $module->getKey(), 'module_type' => get_class($module), 'action_identifier' => $actionIdentifier],
            ['created_by_user' => $owner->getKey(), 'action' => $action, 'status' => $status, 'needs_review' => $needsReview, 'rule' => $rule]
        );

        return $action;
    }


    // public function updateAction($actionId, $action, $actionIdentifier, $status, $needsReview, $rule)
    // {
    //     $oldAction = Action::find($actionId);

    //  $oldAction->action = $action;
    //  $oldAction->action_identifier = $actionIdentifier;
    //  $oldAction->status = $status;
    //  $oldAction->needs_review = $needsReview;
    //     $oldAction->rule = $rule;
    //  $oldAction->save();

    //  return $oldAction;
    // }

    public function deleteAction($actionId)
    {
        $action = Action::find($actionId);
        $action->delete();
    }


    public function assignModuleActionToUser($actionId, $user, $status, $comment=NULL, $mandatory)
    {
        $assigedAction  = ActionAssignedUser::updateOrCreate(
            ['action_id' => $actionId, 'user_id' =>$user->getKey()],
            ['status' => $status, 'mandatory' => $mandatory]
        );

        // we will not add comment while assigning
        // $carComments = new CarComments();
        // $module = $assigedAction;
        // $actionAssignedCommentId = $assigedAction->id;
        // $carComments->addComment($comment, $module, $user, $actionAssignedCommentId);

        return $assigedAction;
    }

    public function unAssign($actionId, $userId)
    {
        $assignedRecord = ActionAssignedUser::where('action_id', $actionId)
                                            ->where('user_id', $userId)
                                            ->first();

        $assignedRecord->delete();

        return 'success';
    }


    public function changeActionStatus($action, $status)
    {
        # code...
    }

    public function changeAssignedActionStatus($actionId, $userId, $status)
    {
        $assignedRecord = ActionAssignedUser::where('action_id', $actionId)
                                            ->where('user_id', $user->getKey())
                                            ->first();
        
        $assignedRecord->status = $status;
        $assignedRecord->save();
    }
}