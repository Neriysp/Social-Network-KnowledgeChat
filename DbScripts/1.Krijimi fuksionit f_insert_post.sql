CREATE DEFINER=`root`@`localhost` FUNCTION `f_insert_post`( body longtext,user_id int ) RETURNS int(11)
BEGIN
Insert into T_posts(body,user_id,post_date) values(body,user_id,now());
 RETURN (SELECT LAST_INSERT_ID() as last_post_id);
END