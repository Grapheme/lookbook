<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
<div class="overlay js-overlay">
    <div class="overlay__background"></div>
    <div class="overlay__body">
        <div data-popup="auth" class="overlay__tab overlay-auth"><a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Войти</h1>
                <div class="auth__desc">Пожалуйста авторизуйтесь, используя аккаунт в одной из социальных сетей:</div>
                <div class="auth__socials"><a href="#" class="socials-facebook">Facebook</a><a href="#" class="socials-vk">Вконтакте</a><a href="#" class="socials-ok">Одноклассники</a></div>
                <div class="auth_form">
                    <div class="auth__desc">или с помощью адреса электронной почты</div>
                    <form id="form-auth" action="json/test.json">
                        <div class="input-cont">
                            <input name="email" placeholder="E-mail" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password" placeholder="Пароль" type="password" class="auth-input">
                        </div>
                        <div class="input-bottom"><a href="#restore_before">Забыли пароль?</a></div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Войти</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                    </form>
                    <div class="auth__toreg">До сих пор нет аккаунта? <a href="#reg">Зарегистрироваться</a></div>
                </div>
            </div>
        </div>
        <div data-popup="reg" class="overlay__tab overlay-auth"><a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Регистрация</h1>
                <div class="auth__desc">Пожалуйста авторизуйтесь, используя аккаунт в одной из социальных сетей:</div>
                <div class="auth__socials"><a href="#" class="socials-facebook">Facebook</a><a href="#" class="socials-vk">Вконтакте</a><a href="#" class="socials-ok">Одноклассники</a></div>
                <div class="auth_form">
                    <div class="auth__desc">или с помощью адреса электронной почты</div>
                    <form id="form-reg" action="json/test.json">
                        <div class="input-cont">
                            <input name="email" placeholder="E-mail" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password" placeholder="Пароль" type="password" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password_verify" placeholder="Подтверждение пароля" type="password" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="name" placeholder="Ваше имя" class="auth-input">
                        </div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Войти</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                    </form>
                    <div class="auth__toreg">Уже зарегистрировались? <a href="#auth">Войти на сайт</a></div>
                </div>
            </div>
        </div>
        <div data-popup="restore_before" class="overlay__tab overlay-auth"><a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Восстановление пароля</h1>
                <div class="auth_form">
                    <form id="form-restore_before" action="json/test.json">
                        <div class="input-cont">
                            <input name="email" placeholder="E-mail" class="auth-input">
                        </div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Восстановить</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div data-popup="restore" class="overlay__tab overlay-auth"><a href="#" class="tab__close js-close-popup"><span></span></a>
            <div class="auth__body anim-parent">
                <h1>Восстановление пароля</h1>
                <div class="auth_form">
                    <form id="form-restore" action="json/test.json">
                        <div class="input-cont">
                            <input name="password" placeholder="Пароль" type="password" class="auth-input">
                        </div>
                        <div class="input-cont">
                            <input name="password_verify" placeholder="Подтверждение пароля" type="password" class="auth-input">
                        </div>
                        <div class="input-btn">
                            <button type="submit" class="us-btn">Восстановить</button>
                            <div class="ajax-message js-response-text"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>