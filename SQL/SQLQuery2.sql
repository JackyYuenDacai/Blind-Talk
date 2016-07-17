--select idpw.id, llog from idpw left join user_last_log on idpw.id=user_last_log.id
--go
--exec record_visit '192.168.1.1'
declare @id as varchar(max);
set @id='Admin';
--exec ver_login 'Admin','QWRtaW4='
select * from usertoken
select * from visit_log
select * from idpw
print sys.fn_VarBinToHexStr( HASHBYTES('MD5',   [dbo].f_base64_encode( CONVERT(varbinary(max),@id+ CONVERT(varchar(max),getdate()) + CONVERT(varchar(max),rand())) )));
 execute get_user_icon 'Admin'
select * from user_flist

