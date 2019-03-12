Step 1

Permiso::registerPermission(PERMISSION,ENTITY_TYPE);
Permiso::registerPermission('x1',COUNTRY);
Permiso::registerPermission('x2',COUNTRY);
Permiso::registerPermission('y1',STATE);
Permiso::registerPermission('y2',STATE);
Permiso::registerPermission('z1',CITY);
Permiso::registerPermission('z2',CITY);

Step 2

<!-- Permiso::registerEntity(CITY, T1);
Permiso::registerEntity(CITY, T2);
Permiso::registerEntity(COUNTRY, C1);
Permiso::registerEntity(COUNTRY, C2);
Permiso::registerEntity(STATE, S1);
Permiso::registerEntity(STATE, S2); -->

Step 3

Permiso::registerGroup(G1, [x1, y1, z2])
Permiso::registerGroup(G2, [x1, y1, z1])

Permiso::grantGroupPermission(U1,G1,[C1, S1])
Permiso::grantGroupPermission(U1,G1)
Permiso::grantPermissions(U1,[x1, y1],[C1, S1])
Permiso::grantPermissions(U1,[x1, y1])

1. (User, Group, Entity)

2. (Group, Entities)

* Each entity and exhaustive list of permissions

3 Entity Types
Each Entity Type -> 2 Permissions

	Country:
		- x1
		- x2
	State:
		- y1
		- y2
	City:
		- z1
		- z2

G1 - x1, y1, z2, x2

U1 -> (G1, [C1, C3, S1, T1])
U2 -> (G1, [C4, C5])
U3 -> (G1, [])

U4 -> (x2, [C1])
U5 -> ([x1], [C1]) 
U5 -> ([x1, x2], [C2])
U6 -> (x1)
U7 -> (C1, C2 ...)

// $userC can fund, advice, overrule $cityA and $cityB

1. Give user permission to manage all countries

2. Give user permission to manage some countries

3. Give user permission to fund all states via a group

4. Give user permission to fund some states via a group

5. Give user permission to fund a state and all cities 

6. Give user permission to fund a state and all cities via a group

7. Give user permission to fund a state and but not cities 

---------------
// Create permission

new Permission(CREATE_COUNTRY,COUNTRY)
new Permission(CREATE_STATE,COUNTRY)
new Permission(PERMISSION,ENTITY_TYPE)
new Permission(PERMISSION,ENTITY_TYPE)

grantPermission(U1, CREATE_COUNTRY)
grantPermission(U1, CREATE_STATE)
grantPermission(U1, CREATE)

// Create entity

ec1 = new Entity(COUNTRY, C1);
ec2 = new Entity(COUNTRY, C2);
es1 = new Entity(STATE, S1);
es2 = new Entity(STATE, S2);

// Set relationship

es1->setPID(ec1);
es2->setPID(ec2);

// Set Permissions to an Entity

ec1->grantPermission("approve"); // new Permission
ec1->denyPermission("approve"); // new Permission

// Get Permissions to an Entity
getPermissions(ec1->leaf)

// Create Group

g1 = new Group('Invaders');

// Set Group permissions

g1->permissionsList([x2,y1]);

// Set Group permissions on Entity

g1->permissionsList([ec1]);

// Grant Permissions to User
grantPermission(U1, JSONObject)

user->grantPermission('create_country');

user->grantPermission(x1)
user->grantEntityLevelPermission(x1, ec1, true/false)
user->grantEntityPermission(ec1, true/false)
user->grantGroupLevelPermission(g1, true/false)
user->grantGroupWithEntitiesPermission(g1, [ec1, ec2], true/false)
user->denyPermission

// Grant Permissions to User on Entities
grantPermission(U1, JSONObject)


// Grant Permissions to User using Group
grantPermission(U1, JSONObject)


// Grant Permissions to User including Children
grantPermission(U1, JSONObject)


{
	Individual:
		{
		I1: {C1,...Cn}
		}
	Entities:
		{
		 (E1, yes/no),
		 (E2, yes/no),
		 ....
		}
	Group:
		{
		G1: {C1,...Cn}
		}
}

user->hasPermission(x1, ec1); // true/false