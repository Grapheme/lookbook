<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
			Добро пожаловать в {{ link_to('','LookBook.pro') }}.<br>
			Активируйте свой аккаунт, перейдя по <a href="{{ URL::route('signup-activation',$account->temporary_code) }}">ссылке</a>.<br>
			Не откладывайте, ссылка действует 72 часа.
		</p>
        <p>
            Для авторизации воспользуйтесь логином и паролем:<br>
            Логин: {{ $account->email }}<br>
            Пароль: {{ Input::get('password') }}
        </p>
	</div>
</body>
</html>