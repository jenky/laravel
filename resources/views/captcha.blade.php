<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Captcha</title>
    @captchaScript
</head>
<body>
    @dump($errors->all())
    <form action="{{ route('captcha') }}" method="POST">
        @csrf
        <div class="h-captcha" data-sitekey="e8908af4-7f90-4b6f-a76e-14a3fefae5d2"></div>
        <button class="btn" type="submit">Submit</button>
    </form>
</body>
</html>
