<?php
$top_posts = $top_posts_ids_all = $top_posts_ids = array();
foreach (Post::where('category_id', $category_id)->where('publication', 1)->with('views')->get() as $post):
    $top_posts_ids_all[$post->id] = count($post->views);
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
    foreach(Post::whereIn('id', array_keys($top_posts_ids))->where('category_id', $category_id)->where('publication', 1)->with('user', 'views', 'photo')->get() as $post):
        $top_posts[$post->id] = $post;
    endforeach;
    array_multisort($top_posts,array_keys($top_posts_ids));
endif;
?>
@if(count($top_posts))
    <div class="right-title">TOP POSTS OF {{ $category_name }}</div>
    <div class="right-content">
        <ul class="right-content__list list-big">
            @foreach($top_posts as $top_post)
                <li class="list__item">
                    @include(Helper::layout('assets.top_post'),array('top_post'=>$top_post,'categories'=>$categories))
                </li>
            @endforeach
        </ul>
    </div>
@endif