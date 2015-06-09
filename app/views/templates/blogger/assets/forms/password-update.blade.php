{{ Form::open(array('route'=>'profile.password.update','method'=>'put','id'=>'dashboard-pass','class'=>'js-dashboard-form')) }}
<div class="left-title">Пароль и защита данных</div>
<table class="dashboard__form-table">
    <tr>
        <td class="form-table__name"><span>Пароль</span></td>
        <td class="form-table__value">
            <input name="password" value="" placeholder="********" type="password"
                   class="dashboard-input">
        </td>
    </tr>
    <tr>
        <td class="form-table__name"><span>Подтверждение пароля</span></td>
        <td class="form-table__value">
            <input name="password_confirmation" value="" placeholder="********"
                   type="password" class="dashboard-input">
        </td>
    </tr>
    <tr class="form-table__btns">
        <td class="form-table__name"></td>
        <td class="form-table__value">
            <button type="submit" class="blue-hover us-btn">Сохранить</button>
            <div class="response-text js-response-text"></div>
            <!--button(type="submit").blue-hover.us-btn Отменить-->
        </td>
    </tr>
</table>
{{ Form::close() }}