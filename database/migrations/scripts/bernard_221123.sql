insert into model_has_roles(role_id,model_id,model_type)
select role_id,user_id,'App\\Models\\User'
from user_has_roles_old
where role_id in (select `id` from roles);


