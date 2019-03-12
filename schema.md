entities
=====
id
type - Country, State, City
value - code/id
pid // Null

entity_parents
======
parent_id
child_id

India, USA, China -> Country
Jammu, California -> State
Srinagar, SanFrans -> City

permissions
=====
id
value // unique
entity_type

approve_country -> Country
approve_state -> State
approve_city -> City

groups
=====
name
display_name

groups_permissions
=====
group_id
permission_id

user_permissions
========
user_id
of_id
of_type // permission, group
entity_id // Nullable, "India"
children // true

1 approve_country -> Approve any country
1 approve_country, India -> Only approve India
1 approve_state, India -> Approve all states in India
1 approve_city, India -> Approve all cities of all states in India

approve_city is given to user 1
approve_city is applicable on cities
But it is given on a country, not a city
Find the relationship between country and city


groups_entities
=====
group_id
entity_id

user_permissions_object
=====
user_id
object



