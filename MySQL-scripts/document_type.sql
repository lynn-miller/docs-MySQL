create table document_type (
  document_type_id  int auto_increment,
  document_type     varchar(20),
  open_with         varchar(30),
  constraint document_type_pk primary key (document_type_id)
  );

insert into document_type (document_type, open_with)
  values ('Word', 'winword.exe');
commit;