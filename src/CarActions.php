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
    	$data['module_id'] = $module->getKey();
    	$data['module_type'] = get_class($module);
    	$data['created_by_user'] = $owner->getKey();
    	$data['action'] = $action;
    	$data['action_identifier'] = $actionIdentifier;
    	$data['status'] = $status;
    	$data['needs_review'] = $needsReview;
    	$data['rule'] = $rule;

    	$action = Action::firstOrCreate($data);

    	return $action;
    }


    public function updateAction($actionId, $action, $actionIdentifier, $status, $needsReview, $rule)
    {
        $oldAction = Action::find($actionId);

    	$oldAction->action = $action;
    	$oldAction->action_identifier = $actionIdentifier;
    	$oldAction->status = $status;
    	$oldAction->needs_review = $needsReview;
        $oldAction->rule = $rule;
    	$oldAction->save();

    	return $oldAction;
    }

    public function deleteAction($actionId)
    {
        $action = Action::find($actionId);
    	$action->delete();
    }


    public function assignModuleActionToUser($actionId, $userId, $status, $comment=NULL, $mandatory)
    {
        $data['action_id'] = $actionId;
        $data['user_id'] = $userId;
        $data['status'] = $status;
        $data['comment'] = $comment;
        $data['mandatory'] = $mandatory;

        $assigedAction  = ActionAssignedUser::firstOrCreate($data);

        $carComments = new CarComments();

        $user = User::find($userId);
        $module = $assigedAction;
        $actionAssignedCommentId = $assigedAction->id;
        $carComments->addComment($comment, $module, $user, $actionAssignedCommentId);

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
}