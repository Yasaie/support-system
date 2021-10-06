<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <form method="POST" action="{{ route('post.create') }}">
            <input name="subject" type="text" placeholder="عنوان" required>
            <textarea name="content" placeholder="محتوا" required></textarea>
            <input type="submit" value="ثبت پست">
        </form>
    </body>
</html>