<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Analysis</title>
</head>
<body>
    <h1>Event Analysis</h1>
    @if (session('message'))
        <div>{{ session('message') }}</div>
    @endif
    <ul>
        @foreach ($events as $event)
            <li>{{ $event }}</li>
        @endforeach
    </ul>
    <form action="{{ route('events.close') }}" method="POST">
        @csrf
        <button type="submit">Close Connection</button>
    </form>
</body>
</html>
