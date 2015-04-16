@foreach($posts as $post)
    <li class="dashboard-item js-post">
        <div class="left-block">
            @include(Helper::layout('assets.avatar'),array('user'=>$post->user))
        </div>
        <div class="right-block">
            <div class="right-block__pad">
                @include(Helper::layout('assets.post'),array('post'=>$post,'categories'=>$categories))
            </div>
        </div>
    </li>
@endforeach