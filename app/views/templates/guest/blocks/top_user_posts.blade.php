<?php
$top_posts = $top_posts_ids_all = $top_posts_ids = array();
foreach (Post::where('user_id', $user_id)->where('publication', 1)->with('views')->get() as $post):
    $top_posts_ids_all[$post->id] = count($post->views) + $post->guest_views;
endforeach;
if (count($top_posts_ids_all)):
    arsort($top_posts_ids_all);
    $countPostsIDs = 0;
    foreach ($top_posts_ids_all as $post_id => $post_views):
        if ($countPostsIDs < Config::get('lookbook.count_top_posts')):
            $top_posts_ids[$post_id] = $post_views;
            $countPostsIDs++;
        endif;
    endforeach;
    foreach(Post::whereIn('id', array_keys($top_posts_ids))->where('user_id', $user_id)->where('publication', 1)->with('user', 'views', 'photo')->get() as $post):
        $top_posts[$post->id] = $post;
    endforeach;
    $tmp_posts = $top_posts;
    $top_posts = array();
    foreach($top_posts_ids as $index => $top_post):
        if(isset($tmp_posts[$index])):
            $top_posts[$index] = $tmp_posts[$index];
        endif;
    endforeach;
endif;
$categories = array();
foreach(Dic::where('slug','categories')->first()->values as $category):
    $categories[$category->id] = array('slug'=>$category->slug,'title'=>$category->name);
endforeach;
?>
@if(count($top_posts))
    <div class="right-title">TOP POSTS OF {{ $user_name }}</div>
    <div class="right-content">
        <ul class="right-content__list list-big">
            @foreach($top_posts as $top_post)
                @if(count($top_post->views))
                <li class="list__item">
                    @include(Helper::layout('assets.top_post'),array('top_post'=>$top_post,'categories'=>$categories))
                </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif