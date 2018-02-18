create database cms;
use cms;
select database();

create table project (
  project_id int,
  client_name varchar(30),
  project_name varchar(30),
  project_description varchar(100),
  start_date date,
  end_date date,
  constraint project_pk primary key (project_id)
  );
  
 create table document (
   document_id int primary key,
   project_id int references project(project_id),
   document_name varchar(30),
   document_description varchar(100),
   document_location varchar(100),
   open_with varchar(30)
 );
 
 alter table project change project_id project_id int auto_increment;
 alter table document change document_id document_id int auto_increment;
 alter table project modify client_name varchar(50);
 alter table document modify document_name varchar(80);
 alter table document modify document_description varchar(200);
 
 insert into project (client_name, project_name, start_date)
 values ('Housing New Zealand Corporation','RAC Compliance Review','2015-05-07'),
   ('Fire & Rescue NSW','Install and Configure OEM','2015-03-16');
   
 commit;
 
 select * from project;
 
 insert into document (project_id, document_name, document_description, document_location)
 values (1, 'HNZC App Oracle RAC Compliance Review',
     'Review of HNZC RAC environment and connectivity for high availability best practice compliance',
     'H:\HNZC\HNZC App Oracle RAC Compliance Review_1.3.docx'),
   (1, 'HNZC App Oracle RAC Compliance Review - Appendix A',
     'Review of HNZC RAC environment and connectivity for high availability best practice compliance - Appendix A',
     'H:\HNZC\HNZC App Oracle RAC Compliance Review_Appendix A.docx'),
   (2, 'Oracle Enterprise Manager Cloud Control 12.1.0.4 Build',
     'As-built documentation for install of OEM Cloud Control for Fire and Rescue NSW',
     'C:\Users\millerl\Documents\NSWFB\NSWFB - OEM 12.1.0.4 Build.docx');  

commit;

select document_name from document where project_id = 2;     
select replace(document_location,'\\','/') from document;
select document_location from document;
select * from document;
update document set document_location = 'H:\\HNZC\\HNZC App Oracle RAC Compliance Review-Appendix A.docx' where document_id = 8;