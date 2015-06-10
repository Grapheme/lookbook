{{ Form::open(array('route'=>'blogger.monetization.update','method'=>'put', 'class'=>'js-dashboard-form js-ajax-form')) }}
<div class="left-title">Монетизация</div>
<div class="form-desc money-block">
    <div class="block__section">
        <div class="section__desc">
            <p>Lookbook предоставляет авторам возможность сделать блог коммерческим проектом. Качественный и интересный
                контент, а также постоянное использование инструментов шаринга повысят его популярность и позволят
                начать сотрудничество с брендами. Чем больше у вашего блога подписчиков в социальных сетях, тем выше
                вероятность его монетизации.</p>

            <p>Отметьте, пожалуйста, какой из вариантов сотрудничества с брендами вам наиболее интересен (возможен
                интерес к одному, двум или сразу всем трем вариантам сотрудничества)</p>
        </div>
        <div class="section__content">
        @foreach(Dic::where('slug','cooperation_brands')->first()->values as $cooperation)
            <div class="check-cont js-set-check">
                <input type="checkbox" name="cooperation_brands[]" {{ in_array($cooperation->id, $monetization['cooperation']) ? 'checked' : '' }} value="{{ $cooperation->id }}" class="js-styled-check">
                <label>{{ $cooperation->name }}</label>
            </div>
        @endforeach
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">Укажите, пожалуйста, некоторые особенности вашего блога</div>
        <div class="section__content">
            <?php
                if(isset($monetization['main']->features)):
                    $features = $monetization['main']->features;
                else:
                    $features = '';
                endif;
            ?>
            {{ Form::textarea('features',$features,array('class'=>'redactor dashboard-textarea js-autosize')) }}
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">Основная направленность:</div>
        <div class="section__content">
        @foreach(Dic::where('slug','main_thrust')->first()->values as $thrust)
            <div class="check-cont js-set-check">
                <input type="checkbox" name="thrust[]" {{ in_array($thrust->id, $monetization['thrust']) ? 'checked' : '' }} value="{{ $thrust->id }}" class="js-styled-check">
                <label>{{ $thrust->name }}</label>
            </div>
        @endforeach
        </div>
    </div>
    <div class="block__section">
        <div class="section__desc">
            Укажите, пожалуйста, по какому адресу и телефону с вами предпочтительнее всего связаться в случае, если
            бренд выберет вас для сотрудничества.
        </div>
    </div>
    <table class="dashboard__form-table">
        <tr>
            <td class="form-table__name">Телефон</td>
            <td class="form-table__value js-form-value">
                <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                <?php
                if(isset($monetization['main']->phone)):
                    $phone = $monetization['main']->phone;
                else:
                    $phone = '';
                endif;
                ?>
                {{ Form::text('phone',$phone,array('class'=>'dashboard-input')) }}
            </td>
        </tr>
        <tr>
            <td class="form-table__name">Адрес</td>
            <td class="form-table__value js-form-value">
                <a href="#" class="input-add-value js-add-value"><span>Добавить</span></a>
                <a href="#" class="input-change-value js-change-value"><span>изменить</span></a>
                <?php
                if(isset($monetization['main']->location)):
                    $location = $monetization['main']->location;
                else:
                    $location = '';
                endif;
                ?>
                {{ Form::text('location',$location,array('class'=>'dashboard-input')) }}
            </td>
        </tr>
    </table>
</div>
<table class="dashboard__form-table">
    <tr class="form-table__btns">
        <td class="form-table__name"></td>
        <td class="form-table__value">
            {{ Form::button('Сохранить',array('class'=>'blue-hover us-btn','type'=>'submit')) }}
            <div class="response-text js-response-text"></div>
        </td>
    </tr>
</table>
{{ Form::close() }}