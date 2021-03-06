<div class="left-title">
    Список зарагистрированных пользователей
</div>
<table class="moder-table">
    <thead>
        <th class="table__number">№</th>
        <th>Имя</th>
        <th>Местонахождение</th>
        <th>Монетизация</th>
        <th>Дата регистрации</th>
        <th></th>
    </thead>
    <tbody>
    @foreach($accounts as $index => $account)
        <?php
        $nickname = $account->id.'-'.BaseController::stringTranslite($account->name);
        if(!empty($account->nickname)):
            $nickname = $account->nickname;
        endif;
        ?>
        <tr>
            <td class="table__number">{{ $index+1 }}</td>
            <td class="table__user-info">
                <a target="_blank" href="{{ URL::route('user.profile.show', $nickname) }}">{{ $account->name }}</a><br>{{ $account->email }}
            </td>
            <td>{{ $account->location }}</td>
            <td>
                @if(!empty($account->monetization))
                    <a target="_blank" href="{{ URL::route('user.monetization.show', $nickname) }}">Смотреть</a>
                @endif
            </td>
            <td>{{ $account->updated_at->format('d.m.Y H:i') }}</td>
            <td class="table__actions js-slide-parent">
                <div class="js-slide-item hidden">
                    {{ Form::model($account,array('route'=>array('moderator.accounts.save',$account->id),'method'=>'post','class'=>'inline-block js-ajax-form')) }}
                        {{ Form::checkbox('active') }} Активный <br>
                        {{ Form::checkbox('brand') }} Бренд <br>
                        {{ Form::checkbox('recommended') }} Рекомендованный <br>
                        {{ Form::button('Сохранить',array('class'=>'white-btn actions__btn','type'=>'submit')) }}
                    {{ Form::close() }}
                </div>
                <div>
                    <a href="#" class="white-btn js-slide-link">Редактировать</a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>