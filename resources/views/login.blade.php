
@if (Auth::check())
    @if (Auth::user()->level == 'admin')
    <script>window.location = "{{ route('indexadmin') }}";</script>
    @elseif (Auth::user()->level == 'karyawan')
    <script>window.location = "{{ route('indexkaryawan') }}";</script>
    @endif
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div><input type="text" name="username"></div>
        <div><input type="password" name="password"></div>
        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>
