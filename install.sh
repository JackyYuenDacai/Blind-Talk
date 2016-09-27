mysql -e "source ./cu.sql" -uroot -p 
mysql -e "source ./db.sql" -udball -p123456
mysql -e "source ./SQL/mysql/sql_refresh-mysql.sql" -udball -p123456
mysql -e "source ./SQL/mysql/sql_funcs-mysql.sql" -udball -p123456
