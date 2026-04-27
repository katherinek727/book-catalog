<?php

use yii\helpers\Html;

/** @var array $results */
/** @var int $year */

$this->title = 'Top-10 Authors by Book Count';
?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <form method="get" class="form-inline mb-4">
        <label for="year" class="mr-2">Year:</label>
        <input type="number" id="year" name="year" value="<?= (int)$year ?>"
               min="1000" max="<?= date('Y') ?>" class="form-control mr-2">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <?php if (empty($results)): ?>
        <p>No data found for <?= (int)$year ?>.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Author</th>
                    <th>Books in <?= (int)$year ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= Html::a(Html::encode($row['full_name']), ['/author/view', 'id' => $row['id']]) ?></td>
                    <td><?= (int)$row['book_count'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
