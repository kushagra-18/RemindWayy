<html>

<head>

    <h2> Hello {{ $reminder->name }},</h2>
    <p>
        This is a reminder for you to:
    </p>
    <p>
        <strong>{{ $reminder->title }}</strong>
    </p>
    <p>
        {{ $reminder->description }}
    </p>
    <p>
        {{ $reminder->date }} {{ $reminder->time }}
    </p>
    <p>
        <a href="{{ url('/reminder') }}">View all reminders</a>
    </p>
</head>

</html>