 create table document (
   document_id int auto_increment,
   project_id int references project(project_id),
   document_type_id int references document_type(document_type_id),
   document_name varchar(80),
   document_description varchar(200),
   document_location varchar(200),
   constraint document_pk primary key (document_id)
 );

 insert into document (project_id, document_type_id, document_name, document_description, document_location)
 values (1, 1, 'HNZC App Oracle RAC Compliance Review',
     'Review of HNZC RAC environment and connectivity for high availability best practice compliance',
     'H:\\HNZC\\HNZC App Oracle RAC Compliance Review_1.3.docx'),
   (1, 1, 'HNZC App Oracle RAC Compliance Review - Appendix A',
     'Review of HNZC RAC environment and connectivity for high availability best practice compliance - Appendix A',
     'H:\\HNZC\\HNZC App Oracle RAC Compliance Review_Appendix A.docx'),
   (2, 1, 'Oracle Enterprise Manager Cloud Control 12.1.0.4 Build',
     'As-built documentation for install of OEM Cloud Control for Fire and Rescue NSW',
     'C:\\Users\\millerl\\Documents\\NSWFB\\NSWFB - OEM 12.1.0.4 Build.docx');  
commit;



