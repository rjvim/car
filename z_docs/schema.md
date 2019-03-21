#CommentsActionReview
#Tables

##comments:
- user_id
- module_id
- module_type
- comment
- addressed_users

##actions: (tasks)
- id
- module_id -> WI
- module_type -> WI
- created_by -> None
- task -> TEXT
- task_identifier -> approval
- status -> pending
- needs_review -> true
- rule -> must


##action_reviewers
- action_id
- user_id
- status
- comment
- mandatory

##action_assigned_users (pivot table)
- action_id
- user_id

##task_log