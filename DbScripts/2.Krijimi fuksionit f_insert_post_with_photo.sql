CREATE DEFINER=`root`@`localhost` FUNCTION `f_insert_post_with_photo`( body longtext,user_id int,image longblob ) RETURNS int(11)
BEGIN
Insert into T_posts(image,body,user_id,post_date) values(image,body,user_id,now());

 RETURN (SELECT LAST_INSERT_ID() as last_post_id);
END
