Declare result int;
select 1 into result
select * from t_users
select   * from t_group_posts
join t_group_users on t_group_users.group_name=t_group_posts.group_name
where t_group_posts.id_post=3 and t_group_users.id_user=62;

insert into t_group_users(id_user,group_name,join_date) values(63,'a',now())
insert into t_group_comments(body,user_id,group_post_id,comment_data) values ('Sample comment',63,3,now());

call insert_comment_group('koment kot',62,3,@total);
select @total as t;

select * from t_group_comments

select * from t_group_posts

select * from t_users
                          left join t_group_users on t_users.id=t_group_users.id_user
                          where t_users.id=62 and t_group_users.group_name='o'


select * from t_group_users
select * from t_groups
delete from t_group_users where id_user=62 and group_name='n'

delete  from t_group_posts where id_post=3
select * from t_group_comments
delete  from t_group_comments
select * from t_group_posts

select * from t_req_join_closed where user_id=62 and group_name='o'

if(select * from t_req_join_closed where user_id=62 and group_name='o');
INSERT IGNORE into t_req_join_closed(user_id,group_name) values(63,'o');
delete from t_req_join_closed
SELECT ROW_COUNT()
insert into t_req_join_closed(user_id,group_name) values(62,'n')
delete  from t_req_join_closed
                              join t_users on t_req_join_closed.user_id=t_users.id 
                              where t_req_join_closed.group_name='n'
                              
                              
select * from t_events

insert into t_events(task,event_date,group_name,state,difficulty,suggested_by) values('Finish this!',now(),'n','progress','hard',63)
insert into t_events(task,event_date,group_name,state,difficulty,suggested_by) values('histori',now(),'n','done','hard',63)

select * from t_group_users
delete from t_group_users where id_user=63 and group_name='n'

select * from t_next_event_suggestions

insert into t_next_event_suggestions(group_name,user_id,task,difficulty) values('n',63,'Make a website from scratch!','medium')

select * from t_next_event

insert into t_next_event(task,difficulty,user_id,group_name)
select task,difficulty,user_id,group_name from t_next_event_suggestions where id_event_suggestion=1

SELECT group_admin from t_groups where group_name='n'

select * from t_users

UPDATE t_users set prof_image ='asdasdf' where id=67
select * from t_events
select * from t_next_event
select * from t_next_event_suggestions
delete from t_new_event_vote
select * from t_new_event_vote
/*Code to insert to main Event*/
insert into t_events(task,event_date,group_name,state,difficulty,suggested_by)
select t_next_event.task,now(),t_next_event.group_name,'inProgress'
,t_next_event.difficulty,t_next_event.user_id
from t_new_event_vote
join t_next_event on t_next_event.id_next_event=t_new_event_vote.event_suggestion_id
where t_new_event_vote.event_suggestion_id=20
/*/*/
select * from t_new_event_vote where event_suggestion_id=20
delete from t_new_event_vote
insert into t_new_event_vote(user_id,event_suggestion_id,vote)
		values(67,20,'up')
        
select * from t_new_event_vote where user_id=67 and event_suggestion_id=20


		insert into t_new_event_vote(user_id,event_suggestion_id,vote)
		values(67,21,'down')

select * from t_posts f_insert_post

/*Clear all Tables*/
delete from t_comments 
delete from t_posts
delete from t_group_comments
delete from t_group_posts
delete from t_group_users
delete from t_events
delete from t_next_event
delete from t_next_event_suggestions
delete from t_req_join_closed
delete from t_groups
delete from t_login_tokens
delete from t_users
