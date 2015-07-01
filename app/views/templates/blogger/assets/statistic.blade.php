<div class="right-title">Статистика</div>
<div class="right-content">
    <table class="stat-table">
        <tr>
            <td>Рейтинг</td>
            <?php
                $place = AccountsPublicController::getPlaceRating(Auth::user()->id);
                $total_place = Accounts::where('group_id', 4)->count();
            ?>
            <td>{{ $place ? $place : '&mdash;' }} место из {{ $total_place }}</td>
        </tr>
        <tr>
            <td>Записей в блоге</td>
            <?php
                $posts_ids = Post::where('user_id', Auth::user()->id)->lists('id');
            ?>
            <td>{{ count($posts_ids) }}</td>
        </tr>
        <tr>
            <td>Комментариев опубликовано</td>
            <td>{{ PostComments::where('user_id', Auth::user()->id)->count() }}</td>
        </tr>
        <tr>
            <td>Количество подписчиков</td>
            <td>{{ BloggerSubscribe::where('blogger_id', Auth::user()->id)->count() }}</td>
        </tr>
    </table>
</div>
<div class="right-title">Статистика посещений</div>
<div class="right-content">
    <table class="stat-table">
        <tr>
            <td>За сегодня</td>
            <?php $period_begin = Carbon::now()->format('Y-m-d 00:00:00'); ?>
            <?php $period_end = Carbon::now()->format('Y-m-d 23:59:59'); ?>
            <td>{{ PostViews::whereIn('post_id', $posts_ids)->where('created_at', '>=', $period_begin)->where('created_at', '<=', $period_end)->count() }}</td>
        </tr>
        <tr>
            <td>С начала месяца</td>
            <?php $period_begin = Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00'); ?>
            <td>{{ PostViews::whereIn('post_id', $posts_ids)->where('created_at', '>=', $period_begin)->where('created_at', '<=', $period_end)->count() }}</td>
        </tr>
        <tr>
            <td>За все время</td>
            <?php $period_begin = Carbon::create(2015, 1, 1, 0, 0, 0)->format('Y-m-d 00:00:00'); ?>
            <td>{{ PostViews::whereIn('post_id', $posts_ids)->where('created_at', '>=', $period_begin)->where('created_at', '<=', $period_end)->count() }}</td>
        </tr>
    </table>
</div>