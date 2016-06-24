create user if not exists cap identified by '@Gestione1';
grant select,insert,update,delete on cap.* to 'cap'@'localhost' identified by '@Gestione1' ;