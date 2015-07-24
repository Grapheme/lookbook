@if(count($bloggers_find))
    <div class="right-title">BLOGGERS ({{ count($bloggers_find) }})</div>
    <div class="right-content">
        <ul class="right-content__list top-bloggers">
            @foreach($bloggers_find as $blogger)
                <li class="list__item">
                    @include(Helper::layout('assets.avatar'),array('user'=>$blogger))
                    <!--<span>{{ count($blogger->blogname) }}</span>-->
                    <span class="text__followers">{{ count($blogger->posts) }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif