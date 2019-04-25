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
        $actions = Action::where(
            ['module_id' => $module->getKey(), 'module_type' => get_class($module), 'action_identifier' => $actionIdentifier, 'status' => 'pending']
        )
        ->update(['status' => 'rejected']);

        $action = Action::create(
            ['module_id' => $module->getKey(), 'module_type' => get_class($module), 'action_identifier' => $actionIdentifier,
            'created_by_user' => $owner->getKey(), 'action' => $action, 'status' => $status, 'needs_review' => $needsReview, 'rule' => $rule]
        );

        return $action;
    }


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

    public function changeAssignedActionStatusforUser($action, $user, $status)
    {
        $assignedRecord = ActionAssignedUser::where('action_id', $action->id)
                                            ->where('user_id', $user->getKey())
                                            ->first();
        
        $assignedRecord->status = $status;
        $assignedRecord->save();
    }

    public function changeActionStatus($action, $module)
    {
        $totalReviewers = ActionAssignedUser::where('action_id', $action->id)->get();
        $reviewersWhoApproved = $totalReviewers->where('status', 'approved');
        $reviewersWhoRejected = $totalReviewers->where('status', 'rejected');
        $reviewersWhoRequestChanges = $totalReviewers->where('status', 'request-changes');

        $actionRecord = Action::find($action->uuid);

        if($actionRecord->rule === 'must') {
            if($reviewersWhoApproved->count() === $totalReviewers->count()) {
                $actionRecord->status = 'approved';
                $actionRecord->save();
            } else if($reviewersWhoRequestChanges->count() === $totalReviewers->count()) {
                //change changes requested to rejected
                $actionRecord->status = 'changes-requested';
                $actionRecord->save();
            } else if($reviewersWhoRejected->count() > 0) {
                $actionRecord->status = 'rejected';
                $actionRecord->save();
            } else {
                $actionRecord->status = 'pending';
                $actionRecord->save();
            }
        } else if($actionRecord->rule === 'should') {
            if($reviewersWhoRejected->count() === $totalReviewers->count()) {
                $actionRecord->status = 'rejected';
                $actionRecord->save();
            } else if($reviewersWhoRequestChanges->count() === $totalReviewers->count()) {
                $actionRecord->status = 'changes-requested';
                $actionRecord->save();
            } else if($reviewersWhoApproved->count() > 0) {
                $actionRecord->status = 'approved';
                $actionRecord->save();
            } else {
                $actionRecord->status = 'pending';
                $actionRecord->save();
            }
        }

        $module->status = $actionRecord->status;
        $module->save();
    }

    public function getActionAssignedUsers($actionId)
    {
        $actionAssignedUsers = ActionAssignedUser::where('action_id', $actionId)
                                                ->get();

        return $actionAssignedUsers;
    }
}