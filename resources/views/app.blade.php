<!-- resources/views/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Laravel App</title>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('dashboard/src/main.js') }}"></script>
</body>
</html>

