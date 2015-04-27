<table border="1" width="90%">
    <caption>Список зарагистрированных пользователей</caption>
    <thead>
    <th>№ п.п</th>
    <th>Имя</th>
    <th>Местонахождение</th>
    <th>Дата регистрации</th>
    <th></th>
    </thead>
    <tbody>
    @foreach($accounts as $index => $account)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>
                <a target="_blank" href="javascript:void(0)">{{ $account->name }}</a><br>{{ $account->email }}
            </td>
            <td>{{ $account->location }}</td>
            <td>{{ $account->updated_at->format('d.m.Y H:i') }}</td>
            <td>
                {{ Form::model($account,array('route'=>array('moderator.accounts.save',$account->id),'method'=>'post','class'=>'inline-block')) }}
                    {{ Form::checkbox('active') }} Активный <br>
                    {{ Form::checkbox('brand') }} Бренд <br>
                    {{ Form::submit('Сохранить',array('class'=>'white-btn')) }}
                {{ Form::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>