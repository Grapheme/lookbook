<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<script src="//ulogin.ru/js/ulogin.js"></script>
<div class="overlay js-overlay">
    <div class="overlay__background"></div>
    <div class="overlay__body">
        <div data-popup="reg" class="overlay__tab overlay-auth">
            <a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Регистрация</h1>
                <div class="ajax-message js-final-text"></div>
                <div class="js-full-reg">
                    <div class="auth__desc">Пожалуйста, авторизуйтесь, используя аккаунт в одной из социальных сетей:</div>
                    <div id="uLogin80d54119" data-ulogin="mobilebuttons=0;display=buttons;fields=first_name,last_name,email,photo,photo_big;redirect_uri={{ URL::route('signin.ulogin') }}">
                        <div class="auth__socials"><a href="javascript:void(0);" data-uloginbutton="facebook" class="socials-facebook">Facebook</a><a href="javascript:void(0);" data-uloginbutton="vkontakte" class="socials-vk">Вконтакте</a><a href="javascript:void(0);" data-uloginbutton="odnoklassniki" class="socials-ok">Одноклассники</a></div>
                    </div>
                    <div class="auth_form">
                        <div class="auth__desc">или с помощью адреса электронной почты</div>
                        {{ Form::open(array('url'=>URL::route('signup-blogger'),'id'=>'form-reg','class'=>'js-reg-form','method'=>'post')) }}
                        {{ Form::hidden('group_id',Group::where('name','blogger')->pluck('id')) }}
                        <div class="input-cont">
                            <input name="email" placeholder="E-mail" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password" placeholder="Пароль" type="password" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password_verify" placeholder="Подтверждение пароля" type="password"
                                   class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="name" placeholder="Ваше имя" class="auth-input">
                        </div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Зарегистрироваться</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                        {{ Form::close() }}
                        <div class="auth__toreg">Уже зарегистрировались? <a href="#auth">Войти на сайт</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div data-popup="auth" class="overlay__tab overlay-auth">
            <a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Войти</h1>
                <div class="auth__desc">Пожалуйста, авторизуйтесь, используя аккаунт в одной из социальных сетей:</div>
                <div id="uLogin80d54120" data-ulogin="mobilebuttons=0;display=buttons;fields=first_name,last_name,email,photo,photo_big;redirect_uri={{ URL::route('signin.ulogin') }}">
                    <div class="auth__socials"><a href="javascript:void(0);" data-uloginbutton="facebook" class="socials-facebook">Facebook</a><a href="javascript:void(0);" data-uloginbutton="vkontakte" class="socials-vk">Вконтакте</a><a href="javascript:void(0);" data-uloginbutton="odnoklassniki" class="socials-ok">Одноклассники</a></div>
                </div>
                <div class="auth_form">
                    <div class="auth__desc">или с помощью адреса электронной почты</div>
                    {{ Form::open(array('url'=>URL::route('signin'),'id'=>'form-auth', 'method'=>'post')) }}
                        <div class="input-cont">
                            <input name="login" placeholder="E-mail" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password" placeholder="Пароль" type="password" class="auth-input">
                        </div>
                        <div class="input-bottom"><a href="#restore_before">Забыли пароль?</a></div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Войти</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                    {{ Form::close() }}
                    <div class="auth__toreg">До сих пор нет аккаунта? <a href="#reg">Зарегистрироваться</a></div>
                </div>
            </div>
        </div>
        <div data-popup="restore_before" class="overlay__tab overlay-auth">
            <a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Восстановление пароля</h1>
                <div class="auth_form">
                {{ Form::open(array('url'=>URL::route('password-reset.store'),'id'=>'form-restore_before', 'method'=>'post')) }}
                    <div class="input-cont">
                        <input name="email" placeholder="E-mail" class="auth-input">
                    </div>
                    <div class="input-btn">
                        <button type="submit" class="us-btn">Восстановить</button>
                        <div class="ajax-message js-response-text"></div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
        @if(Session::has('reminder.token'))
        <div data-popup="restore" class="overlay__tab overlay-auth">
            <a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Восстановление пароля</h1>
                <div class="auth_form">
                {{ Form::open(array('route'=>array('password-reset.update',Session::get('reminder.token')),'id'=>'form-restore', 'method'=>'PUT')) }}
                    {{ Form::hidden('token',Session::get('reminder.token')) }}
                    {{ Form::hidden('email',Session::get('reminder.email')) }}
                    <div class="input-cont">
                        <input name="password" placeholder="Пароль" type="password" class="auth-input">
                    </div>
                    <div class="input-cont">
                        <input name="password_confirmation" placeholder="Подтверждение пароля" type="password" class="auth-input">
                    </div>
                    <div class="input-btn">
                        <button type="submit" class="us-btn">Восстановить</button>
                        <div class="ajax-message js-response-text"></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>