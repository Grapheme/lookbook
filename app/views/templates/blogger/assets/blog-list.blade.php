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