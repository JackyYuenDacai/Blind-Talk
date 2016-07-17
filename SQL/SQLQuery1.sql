 
declare @tm as datetime;
declare @id as varchar(max);
set @id = 'Admin';
set @tm=getdate();
set @tm='2016-5-10 11:6:3.0'
select * from share_recs 
	where sh_time<=@tm and sh_time=(select MAX(sh_time) from share_recs where sh_time<=@tm) and
		(priv=0 or 
		(priv=1 and (id in (select fId from user_flist where id=@id))) or 
		(priv=2 and id=@id)) 
	order by enum;
go
select getdate()
go
