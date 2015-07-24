<div class="right-title">МОЙ БЛОГ ЛИСТ</div>
<div class="right-content">
    @if(count($blog_list))
        <ul class="right-content__list">
            @foreach($blog_list as $blog)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$blog))
                </li>
            @endforeach
        </ul>
        <a href="{{ URL::route('blogger-blog-list') }}" class="right-content__all-link">All blogs</a>
    @else
        Вы еще не добавили ни один блог в свой блог лист.
    @endif
</div>

<div class="right-title">ПРАВИЛА ВЕДЕНИЯ БЛОГА</div>
<div class="right-content">
    <p>LOOKBOOK&nbsp;&mdash; первая в&nbsp;России площадка для ведения <nobr>фешн-блогов</nobr>. Настоятельно рекомендуем ознакомиться с&nbsp;правилами ведения блога на&nbsp;Lookbook во&nbsp;избежание блокировки вашего аккаунта модератором.</p>
    <a href="{{ URL::route('page', 'rules') }}" class="right-content__all-link">ПОДРОБНЕЕ</a>
</div>