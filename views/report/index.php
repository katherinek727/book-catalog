<?php

use yii\helpers\Html;

/** @var array $results */
/** @var int $year */

$this->title = 'Top-10 Authors Report';
?>
<div class="report-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-muted" style="margin-bottom:24px;">Top 10 authors by number of books published in a given year.</p>

    <form method="get" class="form-inline" style="margin-bottom:28px;">
        <label for="year-input" style="font-weight:600;margin-right:8px;">Year:</label>
        <input type="number" id="year-input" name="year"
               value="<?= (int)$year ?>"
               min="1000" max="<?= date('Y') ?>"
               class="form-control"
               style="width:120px;">
        <button type="submit" class="btn btn-primary" style="margin-left:8px;">Filter</button>
    </form>

    <?php if (empty($results)): ?>
        <div class="card">
            <div class="card-body text-muted">
                No data found for <?= (int)$year ?>.
            </div>
        </div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Author</th>
                    <th style="width:160px;">Books in <?= (int)$year ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= Html::a(Html::encode($row['full_name']), ['/author/view', 'id' => $row['id']]) ?></td>
                    <td>
                        <span style="display:inline-block;background:#2c3e50;color:#fff;padding:2px 10px;border-radius:12px;font-size:.85rem;">
                            <?= (int)$row['book_count'] ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
