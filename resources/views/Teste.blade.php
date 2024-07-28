<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste ACL</title>
</head>

<body>
    @can('create_user')
        <a href="">Create User</a>
    @endcan
    @can('create_post')
        <a href="">Create post</a>
    @endcan
    @can('edit_user')
        <a href="">Edit User</a>
    @endcan
    @can('delete_user')
        <a href="">Delete user</a>
    @endcan
    @can('Bernat_teste')
        <a href="">Bernat teste</a>
    @endcan


    <hr>
    </hr>


    <uL>
        @foreach ($usuarios as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </uL>
</body>

</html>
