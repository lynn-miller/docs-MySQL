create table client (
  client_id         int auto_increment,
  client_name       varchar(50),
  client_short_name varchar(10),
  constraint client_pk primary key (client_id)
  );

insert into client (client_name, client_short_name)
  values ('Housing New Zealand Corporation', 'HNZC'),
         ('Fire and Rescue New South Wales', 'FRNSW');
commit;
