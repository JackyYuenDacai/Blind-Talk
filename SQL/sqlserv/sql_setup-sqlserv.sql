create database user_ip;
use user_ip;


create table usertoken(id varchar(64) primary key,token varchar(128) default '0',exptime datetime);
create table share_recs(id varchar(64),sh_type int not null,priv int not null,val varchar(4096) not null,sh_time datetime default getdate(),enum int);
create table user_flist(id varchar(64),ftime datetime default getdate(),lctime datetime default getdate(),fId varchar(64));
create table idpw(id varchar(64) primary key,pwd varchar(128) not null);
create table user_description(id varchar(64) primary key,des varchar(4096));
create table user_last_log(id varchar(64) primary key,llog datetime default getdate(),IsOnline int default 0);
create table visit_log(ip varchar(64) primary key,ltlog datetime default getdate(),vcount int);
create table user_icon(id varchar(64) primary key,icpath varchar(1024) default 'defser.png');
--share_recs.sh_type
--0:img
--1:vid
--2:text
--3:sou
--...
--insert into idpw.id,user_description.des,user_last_log.llog("Admin"
go
--share_recs.priv
--0:To All
--1:To Friend
--2:To Own
declare @sw as int;
set @sw = 1;
if @sw = 1
begin
	insert into  usertoken values('Admin',default,GETDATE());
	insert into  idpw values('Admin',HASHBYTES('MD5','Admin'));
	insert into  user_description values('Admin','Administrator Top');
	insert into  user_last_log values('Admin',getdate(),0);
	insert into  user_icon values('Admin',default);

	insert into  usertoken values('JackyYuen',default,GETDATE());
	insert into  idpw values('JackyYuen',HASHBYTES('MD5','JackyYuen'));
	insert into  user_description values('JackyYuen','Administrator Sec');
	insert into  user_last_log values('JackyYuen',getdate(),0);
	insert into  user_icon values('JackyYuen',default);

	insert into  usertoken values('Dacai',default,GETDATE());
	insert into  idpw values('Dacai',HASHBYTES('MD5','Dacai'));
	insert into  user_description values('Dacai','Admin  Sec');
	insert into  user_last_log values('Dacai',getdate(),0);
	insert into  user_icon values('Dacai',default);


	insert into  share_recs values('Admin',2,0,'Welcome To The Matrix',getdate(),0);
	insert into  user_flist values('Admin',getdate(),getdate(),'JackyYuen');
	insert into  user_flist values('JackyYuen',getdate(),getdate(),'Admin');
	insert into  user_flist values('Admin',getdate(),getdate(),'Dacai');
	insert into  user_flist values('JackyYuen',getdate(),getdate(),'Dacai');
end

go
