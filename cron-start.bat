SET php= "c:\xampp\php\php.exe"
SET cron_file= "c:\xampp\htdocs\phpcron\index.php"
set script="%php% %cron_file% test"
schtasks /create /tn "cron-for-windows" /tr %script% /sc minute /mo 1

