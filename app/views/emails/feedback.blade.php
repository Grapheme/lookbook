<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Сообщение от: &lt;{{ $post['name'] }}&gt;
            <br>{{ $post['email'] }}
            <hr/>
			{{ Helper::nl2br($post['message']) }}
            <hr/>
		</p>
	</div>
</body>
</html>