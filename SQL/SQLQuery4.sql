EXECUTE get_user_icon 'Admin';EXECUTE get_user_des 'Admin';
select top 16 user_last_log.IsOnline as Online,fId as Id,lctime as Time ,token from 
	            user_flist join 
				user_last_log on user_last_log.id=fId join
				usertoken on usertoken.id=user_last_log.id
	            where user_flist.id='Admin'  
	            order by (select IsOnline from user_last_log where id=fId) desc, user_flist.lctime desc,fId; 