<?php namespace Betalectic\Permiso\Models;

use App\User as OriginalUser;

class User extends OriginalUser {

	public function build()
	{
		// Get all permissions
		$permissions = Permission::all();
		$permissions = [
			"create_country" => true, // If
		];

		$userPermissions = UserPermissions::all();

		$permissions = [
			"create_country" => true, // If entity is null, use true,false
		];

		/**
		 If $userPermission of_type is permission -> Give that permission on that entity or all
		 If $userPermission of_type is group -> Get all permissions of that group, apply
		 that permission on the entity. If entity is null, then true. If group has entities,
		 give on those entities.
		 If only entity is present in entity_id -> Then get all permissions for that entity_type
		 and give all those permissions for that entity_id


		**/



	}
}
