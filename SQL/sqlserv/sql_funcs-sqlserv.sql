use user_ip;
drop procedure ver_login
drop procedure user_sign
drop procedure record_visit
drop procedure get_user_icon
drop procedure get_user_des 
go
create procedure ver_login(@id varchar(64),@pwd varchar(512))
as
begin
declare @cu as integer;
declare @tk as varchar(max);
set @pwd=Replace(@pwd,'%3D','=');
set @pwd=CONVERT(varchar(max),[dbo].f_base64_decode(@pwd));
select @cu=COUNT(*) from idpw where idpw.id = @id AND idpw.pwd = HASHBYTES('MD5',@pwd);
IF @cu = 0
begin
	select '0'
end
else
begin
	set @tk = sys.fn_VarBinToHexStr( HASHBYTES('MD5',   [dbo].f_base64_encode( CONVERT(varbinary(max),@id+ CONVERT(varchar(max),getdate()) + CONVERT(varchar(max),rand())) )));
	update user_last_log set llog = getdate(),IsOnline=1 where user_last_log.id = @id;
	select '1'+@tk ;
	update usertoken set token = @tk ,exptime = getdate()  where usertoken.id=@id;
	 
end
end
go
create procedure user_sign(@id varchar(64),@pwd varchar(512),@des varchar(max))
as
begin
	set @id=Replace(@id,'%3D','=');
	set @pwd=Replace(@pwd,'%3D','=');
	set @des=Replace(@des,'%3D','=');
	insert into idpw values(CONVERT(varchar(max),[dbo].f_base64_decode(@id)),HASHBYTES('MD5',CONVERT(varchar(max),[dbo].f_base64_decode(@pwd))));
	insert into user_last_log values(CONVERT(varchar(max),[dbo].f_base64_decode(@id)),getdate(),0);
	insert into user_description values(CONVERT(varchar(max),[dbo].f_base64_decode(@id)),CONVERT(varchar(max),[dbo].f_base64_decode(@des)));
	insert into usertoken values(CONVERT(varchar(max),[dbo].f_base64_decode(@id)),null,getdate());
	insert into  user_icon values(CONVERT(varchar(max),[dbo].f_base64_decode(@id)),default);
	select 1
end
go
create procedure record_visit(@ip varchar(128))
as
begin
	declare @t int;
	--set @ip=Replace(@ip,'%3D','=');
	--set @ip=CONVERT(varchar(max),[dbo].f_base64_decode(@ip));
	select @t=count(*) from visit_log where visit_log.ip=@ip;
	if(@t=0)
	begin
		
		insert into visit_log values(@ip,getdate(),1);
	end
	else
	begin
		select @t=visit_log.vcount from visit_log where visit_log.ip=@ip;
		update visit_log set visit_log.ltlog=getdate(),visit_log.vcount=@t+1 where visit_log.ip=@ip;
	end
end
go
create procedure get_user_icon(@id varchar(64))
as
begin
	declare @cu as int;
	declare @pa as varchar(max);
	select @cu=count(*) from user_icon where user_icon.id=@id;
	if @cu=0 or @cu >1
	begin
		select 'defser.png';
	end
	else
	begin
		select @pa=user_icon.icpath from user_icon where user_icon.id=@id;
		if(@pa=null)
		begin
			select 'defser.png';
		end
		else
		begin
			select @pa;
		end
	end
end
go
create procedure get_user_des(@id varchar(64))
as
begin
	declare @cu as int;
	declare @pa as varchar(max);
	select @cu=count(*) from user_description where user_description.id=@id;
	if @cu=0 or @cu >1
	begin
		select 'No Descriptions';
	end
	else
	begin
		select @pa=user_description.des from user_description where user_description.id=@id;
		if(@pa=null)
		begin
			select 'No Descriptions';
		end
		else
		begin
			select @pa;
		end
	end
end
go
