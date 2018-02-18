create table project (
  project_id int auto_increment,
  client_id int references client(client_id),
  project_name varchar(30),
  project_description varchar(100),
  start_date date,
  end_date date,
  constraint project_pk primary key (project_id)
  );

insert into project (client_id, project_name, start_date)
values (1,'RAC Compliance Review','2015-05-07'),
       (2,'Install and Configure OEM','2015-03-16');
commit;
