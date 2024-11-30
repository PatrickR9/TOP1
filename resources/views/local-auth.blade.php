<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-IO local</title>
</head>
<body>
    <h1>lokale Anmeldung</h1>
    <form action="{{ route('local.auth') }}" method="POST">
        @csrf
        <select name="user_id" required>
            <option value="">Benutzer auswählen</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        <button type="submit">Login</button>
    </form>
</body>
</html>