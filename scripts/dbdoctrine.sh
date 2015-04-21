# User creation
app/console fos:user:create root root@local.host admin
app/console fos:user:promote root ROLE_SUPER_ADMIN
app/console fos:user:change-password root C6fderstp

app/console fos:user:create admin admin@local.host admin
app/console fos:user:promote admin ROLE_ADMIN

app/console fos:user:create user user@local.host user

app/console fos:user:create cdte candidate@local.host cdte

app/console fos:user:create client client@local.host client
app/console fos:user:promote client ROLE_CLIENT

app/console fos:user:create tew_exec tew_exec@local.host tew_exec
app/console fos:user:promote tew_exec ROLE_TEW_MASTER_EXECUTOR

# Entity creation
app/console doctrine:generate:entity --format=yml --with-repository --entity=TEWTPBundle:Candidate \
    --fields="gender:string(3) firstName:string(255) middleName:string(255) lastName:string(255) email:string(255) phone1:string(31) phone2:string(31) position:string(255) level:smallint"

app/console doctrine:generate:entity --format=yml --with-repository --entity=TEWTPBundle:Comment --fields="comment:text score:smallint date:datetime"

app/console doctrine:generate:entity --format=yml --with-repository --entity=TEWTPBundle:Language --fields="language:string(2) description:string(255)"

# Crud creation
