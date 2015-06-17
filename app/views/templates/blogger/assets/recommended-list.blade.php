<div class="right-title">Рекомендованные блоги</div>
<div class="right-content">
    @if(count($recommended_blogs))
        <ul class="right-content__list">
            @foreach($recommended_blogs as $recommended_blog)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$recommended_blog))
                </li>
            @endforeach
        </ul>
        <a href="{{ pageurl('total-blogger-list') }}" class="right-content__all-link">All blogs</a>
    @else
        У вас еще нет рекомендованных блогов.
    @endif
</div>