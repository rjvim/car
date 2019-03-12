1. There is a list of permissions
2. Some permissions are applicable globally
3. Some permissions are applicable only to specific entity (living object)
4. Users are given individual permissions
    a. Global permission
    b. If given a specific entity permission, then mention entity also.
5. Permissions can be grouped into Groups 
    a. User can be given a role or roles


$permiso = new Permiso();

$permiso->addGlobalPermission('manage_business_units');
$permiso->addEntityPermission('approve','product'); //Becomes product_approve

$permiso->manageGroup($groupName,$listOfPermissions);
$permiso->deleteGroup($groupName);
$permiso->mapEntityToGroup($groupName, $entity, $entityId);

$permiso->manageGroup($groupName,$listOfPermissions); // Unique groups, If there is any new permission, it would be added as default
$permiso->deleteGroup($groupName);

$user->soDoPermit('manage_business_units');
$user->soDoPermit('approve','product',$productId);
$user->soDontPermit('manage_business_units');
$user->soDontPermit('approve','product',$productId); // approve_product

$user->soCan('manage_business_units'); // true/false
$user->soCan('approve','product',$productId); // true/false

$user->soAddGroup($group);
$user->soAddGroup($group,'product',$productId);
$user->soRemoveGroup($group);
$user->soRemoveGroup($group,'product',$productId);

$permiso->groupMembers($group);
$permis0->addRelationship($productId, 'product', $itemId, 'item'); // item belongs to product

$user->soBuild();

```php
public function soBuild()
{
    $fullPermissionsArray = [
        'global_permission_1' => true,
        'global_permission_2' => true,
        'entity_permission_1' => [],
        'entity_permission_2' => [],
    ];
}
```


Tables

permiso_permissions
====
id
value -> unique
entity_type
applicable_child - entity_name of child

permiso_groups
=====
id
name - unique

permiso_group_permissions
======
group_id
permission_id

permiso_group_entities
======
id
group_id
entity_type
entities = [], null // If this is null, user gets access to all entities. Builder returns true, instead of array

permiso_user_permissions
======
id
user_id
permission_id
entity_type
entities = [], null // If this is null, user gets access to all entities. Builder returns true, instead of array

relationships
======
parent_id
parent_type
child_id
child_type

// Find an entity -> Check if it has children


