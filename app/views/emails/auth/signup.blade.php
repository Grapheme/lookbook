<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Вы только что зарегистрировались на {{ link_to('','look-book.ru') }}.<br>
            Вам осталось лишь активировать свою учетную запись, пройдя по <a href="{{ URL::route('signup-activation',$account->temporary_code) }}">ссылке</a>.<br>
            Не откладывайте, ссылка действует 72 часа.
		</p>
	</div>
</body>
</html>