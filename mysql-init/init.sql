CREATE USER 'admin'@'%' IDENTIFIED WITH 'mysql_native_password' BY '123456';
GRANT ALL PRIVILEGES ON techvn_db.* TO 'admin'@'%';
FLUSH PRIVILEGES;
