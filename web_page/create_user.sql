CREATE USER webuser WITH PASSWORD 'kirbyteam'

GRANT CONNECT ON DATABASE cc3201 to webuser;
GRANT USAGE ON SCHEMA f1 to webuser;
...
GRANT SELECT ON f1.tabla TO webuser;
