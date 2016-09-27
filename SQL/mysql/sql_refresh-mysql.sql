drop database if exists user_ip;
create database user_ip;
use user_ip;
drop table if exists  usertoken;
drop table if exists  share_recs;
drop table if exists  user_flist;
drop table if exists  user_notify;
drop table if exists  idpw;
drop table if exists  user_description;
drop table if exists  user_last_log;
drop table if exists  visit_log;
drop table if exists  user_icon;
                                                                                                                                                                                                                            
create table usertoken
(id varchar(64) primary key,token varchar(128) default '0',exptime datetime);

create table share_recs
(id varchar(64),sh_type int not null,priv int not null,val varchar(4096) not null,sh_time datetime default now(),enum int,unino varchar(128));


create table chatt_recs
(send varchar(64),recv varchar(64),msg_type int not null,val varchar(4096) not null,ch_time datetime default now(),enum int,unino varchar(128));

drop trigger if exists  unic_for_share;
drop trigger if exists  unic_for_chatt;

/*delimiter //
create trigger unic_for_share before insert on share_recs
begin
set @unic = md5 (  TO_BASE64(now() + rand()));
for each row set NEW.unino = @unic; 
//

create trigger unic_for_chatt before insert on chatt_recs
set @unic = md5 (  TO_BASE64(now() + rand()));
for each row set NEW.unino = @unic; //
delimiter ;*/


create table user_flist
(id varchar(64),ftime datetime default now(),lctime datetime default now(),fId varchar(64));

create table idpw
(id varchar(64) primary key,pwd varchar(128) not null,type int default 0);

create table user_description
(id varchar(64) primary key,des varchar(4096));

create table user_last_log
(id varchar(64) primary key,llog datetime default now(),IsOnline int default 0);

create table user_notify
(id varchar(64) primary key,sh_not int default 0,ch_not int default 0,oth_not int default 0,sys_not int default 0);

create table visit_log
(ip varchar(64) primary key,ltlog datetime default now(),vcount int);

create table user_icon
(id varchar(64) primary key,icpath varchar(1024) default 'defser.png');

create table file_record
(id varchar(128) primary key,belongs varchar(64),ftype int default 2,fpath varchar(512) not null);
/*
!!idpw.type
--0:user
--1:admin
--2:???
--3:???
--4:???
--5:group

!!share_recs.sh_type
--0:img
--1:vid
--2:text
--3:sou
--...
!same as chatt_recs.ch_type
--insert into idpw.id,user_description.des,user_last_log.llog("Admin"
go

!!share_recs.priv
--0:To All
--1:To Friend
--2:To Own*/
insert into  usertoken values('Admin',default,now());
insert into  idpw values('Admin',md5('Admin'),1);
insert into  user_notify values('Admin',default,default,default,default);
insert into  user_description values('Admin','Administrator Top');
insert into  user_last_log values('Admin',now(),default);
insert into  user_icon values('Admin',default);

insert into  usertoken values('JackyYuen',default,now());
insert into  idpw values('JackyYuen',md5('JackyYuen'),default);
insert into  user_notify values('JackyYuen',default,default,default,default);
insert into  user_description values('JackyYuen','Administrator Sec');
insert into  user_last_log values('JackyYuen',now(),default);
insert into  user_icon values('JackyYuen',default);

insert into  usertoken values('Dacai',default,now());
insert into  idpw values('Dacai',md5('Dacai'),1);
insert into  user_notify values('Dacai',default,default,default,default);
insert into  user_description values('Dacai','Admin  Sec');
insert into  user_last_log values('Dacai',now(),default);
insert into  user_icon values('Dacai',default);


select md5 (TO_BASE64(now() + rand())) into @kkk;
insert into  share_recs values('Admin',2,0,'Welcome To The Matrix',now(),0,@kkk);
insert into  share_recs values('Admin',2,0,'Matrix',now(),0,@kkk);

insert into  user_flist values('Admin',now(),now(),'JackyYuen');
insert into  user_flist values('JackyYuen',now(),now(),'Admin');
insert into  user_flist values('Admin',now(),now(),'Dacai');
insert into  user_flist values('JackyYuen',now(),now(),'Dacai');
insert into  user_flist values('Dacai',now(),now(),'JackyYuen');
insert into  user_flist values('Dacai',now(),now(),'Admin');


