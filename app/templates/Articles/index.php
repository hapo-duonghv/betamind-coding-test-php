<!-- File: templates/Articles/index.php -->

<h1>Articles</h1>

<?= $this->Html->link('Add Article', ['action' => 'add'], ['class' => 'button']) ?>

<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>
    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
        <tr>
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
            </td>
            <td>
                <?= $article->created_at ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
