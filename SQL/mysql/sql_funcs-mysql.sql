DELIMITER ';'
use user_ip;

drop procedure if exists   ver_login;
drop procedure if exists   user_sign;
drop procedure if exists   record_visit;
drop procedure if exists   get_user_icon;
drop procedure if exists   get_user_des ;
drop procedure if exists   enlong_token ;
drop procedure if exists   getIdByToken ;
drop procedure if exists   getFriendList;
drop procedure if exists   get_user_nots;
drop procedure if exists   get_uni_code_time;
drop procedure if exists   upl_chat_record;
drop procedure if exists   get_chat_record;
drop procedure if exists   user_logoff;
drop procedure if exists   register_user_addition;
drop procedure if exists   get_user_addition;

drop procedure if exists   up_share_record;
drop procedure if exists   get_share_record;

drop procedure if exists   user_befriend;

DELIMITER '/$'
create procedure ver_login( id varchar(64), pwd varchar(512))
begin

set  pwd=Replace(  pwd,'%3D','=');
set  pwd=FROM_BASE64(pwd);
select  count(*) from  idpw where idpw.id =   id AND idpw.pwd = md5(pwd) into @cu;
IF   @cu = 0 then
	select '0' as res;
else 
	set   @tk := md5 (  TO_BASE64(id+now() + rand()));
	update user_last_log set llog = now(),IsOnline=1 where user_last_log.id =   id;
	
	select count(*) from usertoken where usertoken.id=id and usertoken.exptime >= now() into @ex;
	if @ex = 0 then
		update usertoken set token =   @tk ,exptime = addtime(now(),"00:05:00")  where usertoken.id=  id;
		select  @cu as res,@tk as token;
	
	else 
		select @cu as res,usertoken.token as token from usertoken where usertoken.id = id;
		update usertoken set exptime = addtime(now(),"00:05:00") 
		where usertoken.id=id and 
		usertoken.token=token;
	end if;
	 
end if;
end; /$

create procedure user_sign( id varchar(64), pwd varchar(512), des varchar(4096))
begin
	set   id=Replace(  id,'%3D','=');
	set   pwd=Replace(  pwd,'%3D','=');
	set   des=Replace(  des,'%3D','=');
	insert into idpw values(FROM_BASE64(id),md5(FROM_BASE64(pwd)),0);
	insert into user_last_log values(FROM_BASE64(id),now(),0);
	insert into user_description values(FROM_BASE64(id),FROM_BASE64(des));
	insert into usertoken values(FROM_BASE64(id),null,now());
	insert into  user_icon values(FROM_BASE64(id),default);
	select 1 as res;
end; /$

create procedure record_visit( ip varchar(128))
begin
	declare   t int;
	/*--set   ip=Replace( ip,'%3D','=');*/
	/*--set   ip=CONVERT(varchar(4096),FROM_BASE64(  ip));*/
	select   count(*) from visit_log where visit_log.ip=  ip into @t;
	if(  @t=0)then
		
		insert into visit_log values(  ip,now(),1);
	else 
		select   visit_log.vcount from visit_log where visit_log.ip = ip into @t;
		update visit_log set visit_log.ltlog=now(),visit_log.vcount=  t+1 where visit_log.ip=  ip;
	end if;
end; /$

create procedure get_user_icon( id varchar(64))
begin

	select   count(*) from user_icon where user_icon.id=  id into @cu;
	if  (@cu=0 or @cu >1) then

		select 'defser.png' as res;
	else
		select   user_icon.icpath from user_icon where user_icon.id=  id into @pa;
		if( @pa=null)then
			select 'defser.png' as res;
		else
			select  @pa as res;
		end if;
	end if;
end; /$

create procedure get_user_des( id varchar(64))
begin
	select   count(*) from user_description where user_description.id=  id into @cu;
	if  (@cu=0 or @cu >1) then
		select 'No Descriptions' as res;
	
	else
		select   user_description.des from user_description where user_description.id=  id into @pa;
		if( @pa=null)then
			select 'No Descriptions' as res;
		
		else 
			select   @pa as res;
		end if;
	end if;
end; /$

create procedure enlong_token(id varchar(64),token varchar(256))
begin
	select count(*) from usertoken where 
		usertoken.token = token and 
		usertoken.id = id and 
		usertoken.exptime >= now() into @cu;
	if @cu =0 then
		select '0' as res;
	else
		update usertoken set exptime = addtime(now(),"00:05:00") 
		where usertoken.id=id and 
		usertoken.token=token;
		select '1' as res;
	end if;
end; /$
create procedure getIdByToken(token varchar(256))
begin
	select count(*) from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @cu;
	if @cu = 0 or @cu > 1  then
		select "0" as res;
	else
	select "1" as res ,id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now();
	end if;
end; /$

create procedure getFriendList(id varchar(64),no int)
begin

	select (usertoken.exptime>=now()) as Online,fId as Id,lctime as Time ,token from 
            (user_flist inner join user_last_log on user_last_log.id=fId) inner join
			usertoken on usertoken.id=user_last_log.id
            where user_flist.id=id
            order by (usertoken.exptime>=now()) desc, user_flist.lctime desc,fId
		 limit 0,no;
end; /$

create procedure get_user_nots(token varchar(256))
begin
	select count(*) from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @cu;
	if @cu = 0 or @cu > 1  then
		select "0" as res;
	else
	select "1" as res,
		user_notify.ch_not+user_notify.sh_not+user_notify.oth_not+user_notify.sys_not as sumup,
		user_notify.ch_not as chat , user_notify.sh_not as `share` , user_notify.oth_not+user_notify.sys_not as other
	from user_notify where user_notify.id = (select id from usertoken where usertoken.token=token);
	end if;
end; /$

create procedure get_uni_code_time(inp varchar(256))
begin
	select md5 (  TO_BASE64(inp +now() + rand())) as unicode,now() as time;
end; /$

create procedure upl_chat_record(token varchar(256),recv varchar(64),type int,val varchar(4096),whi int,time datetime,uni varchar(128))
begin

	select id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @id;
	insert into chatt_recs values(@id,recv,type,val,time,whi,uni);
	
end; /$

create procedure up_share_record(token varchar(256),entarg int,type int,val varchar(4096),whi int,time datetime,uni varchar(128))
begin
	select id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @id;
	insert into share_recs values(@id,type,entarg,val,time,whi,uni);
end; /$

create procedure get_share_record(token varchar(256),towho int ,uni varchar(128),btime datetime)
begin

	select id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @id;

	select max(sh_time) from share_recs where sh_time <= btime and share_recs.unino != uni into @ltm;
	
	select 
	case 
	when towho = 0 then (select distinct unino from share_recs where sh_time = 
					(select max(sh_time) from share_recs where sh_time <= btime and share_recs.unino != uni and share_recs.id = @id) )
					
	when towho = 1 then	(select distinct unino from share_recs where sh_time = 
					(select max(sh_time) from share_recs where sh_time <= btime and share_recs.unino != uni and id in (select fId from user_flist where id = @id)) )
					
	when towho = 2 then	(select distinct unino from share_recs where sh_time = 
					(select max(sh_time) from share_recs where sh_time <= btime and share_recs.unino != uni))
	else 0
	end  into @uno;

	
	 
	
	
	select '1' as res,
		sh_time as time,
		sh_type as type,
		val as content,
		id ,
		@uno as unikey
		from share_recs where 
		share_recs.unino = @uno
		and share_recs.unino != uni
		order by share_recs.enum;

	
end; /$

create procedure get_chat_record(token varchar(256),fId varchar(64),btime datetime)
begin
	select id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @id;
	select count(*) from user_flist where id=@id and user_flist.fId=fId into @cu;
	if @cu >= 1 then
		select max(chatt_recs.ch_time) from chatt_recs where 
			((chatt_recs.send=@id and chatt_recs.recv=fId) or 
			(chatt_recs.send=fId and chatt_recs.recv=@id)) and
			chatt_recs.ch_time < btime
			order by chatt_recs.ch_time desc,chatt_recs.unino,enum into @ltm;
		
		select '1' as res,
			ch_time as time,
			msg_type as type,
			val as content,
			(chatt_recs.send=@id) as issend ,
			unino as uno
			from chatt_recs where 
			chatt_recs.ch_time = @ltm and
			((chatt_recs.send=@id and chatt_recs.recv=fId) or 
			(chatt_recs.send=fId and chatt_recs.recv=@id)) and
			chatt_recs.ch_time<btime
			order by chatt_recs.ch_time desc,chatt_recs.unino,enum;
	else
		select '0' as res;
	end if;
	
end; /$



create procedure register_user_addition(token varchar(256),id varchar(64),fpath varchar(512),ftype int)
begin
	select md5 (  TO_BASE64(now() + rand())) into @fkey;
	insert into file_record values(@fkey,id,ftype,fpath);
	select @fkey;
end; /$

create procedure get_user_addition(fId varchar(128))
begin
	select fpath from file_record where id = fId;
end; /$

create procedure user_logoff(token varchar(256))
begin
	update usertoken set usertoken.exptime = subtime(now(),5) where usertoken.token=token;
end; /$

create procedure user_befriend(token varchar(256),fId varchar(64))
begin
	select id from usertoken where 
		usertoken.token=token and 
		usertoken.exptime >= now() into @id;
	
	select count(*) from user_flist where id=@id and user_flist.fId=fId into @cu;
	if @cu = 0 then
		insert into  user_flist values(@id,now(),now(),fId);
		insert into  user_flist values(fId,now(),now(),@id);
		select '1' as res;
	else
		select '0' as res;
	end if;
end; /$
DELIMITER ;
