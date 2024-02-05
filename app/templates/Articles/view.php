<!-- File: templates/Articles/view.php -->
<style>
    .like-btn {
        padding: 1px 15px;
        background: #0080ff;
        font-size: 15px;
        font-family: "Open Sans", sans-serif;
        border-radius: 5px;
        color: #e8efff;
        outline: none;
        border: none;
        cursor: pointer;
    }
</style>
<h1>
    <?= h($article->title) ?>
</h1>
<p>
    <?= h($article->body) ?>
</p>
<br>
<p>
    <small>Created:
        <?= $article->created_at ?>
    </small>

    <?= $this->Form->create(null, ['url' => ['controller' => 'Articles', 'action' => 'like', 'method' => 'POST']]) ?>
        <?= $this->Form->hidden('article_id', ['value' => $article->id]) ?>
        <button type="submit" class="like-btn" <?php $article->like_status && print('disabled') ?>>
            <span style="position: relative; top: 5px;">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8 10V20M8 10L4 9.99998V20L8 20M8 10L13.1956 3.93847C13.6886 3.3633 14.4642 3.11604 15.1992 3.29977L15.2467 3.31166C16.5885 3.64711 17.1929 5.21057 16.4258 6.36135L14 9.99998H18.5604C19.8225 9.99998 20.7691 11.1546 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20L8 20"
                        stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    />
                </svg>
            </span>
            <span>Like</span>
        </button>
    <?= $this->Form->end() ?>
    <span>
        <b> <?= count($article->article_likes) ?></b> people like this post
    <span>
</p>
<br>
<?php echo($currentUserInfo->id == $article->id)?>
<p>
    <?php
        $currentUserInfo->id == $article->user_id
        && print($this->Html->link('Edit', ['action' => 'edit', $article->id], ['class' => 'button']))
    ?>
</p>
