<?php

use yii\helpers\Html;

$this->title = 'Top Authors Report';
?>
<div class="page-header">
    <div>
        <h1>Top Authors Report</h1>
        <p style="color:var(--ink-4);font-size:.9rem;margin-top:4px;">Ranked by books published in a given year.</p>
    </div>
    <form method="get" class="d-flex align-items-center gap-2">
        <label for="year-input" style="font-size:.75rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-3);white-space:nowrap;">
            Year
        </label>
        <input type="number" id="year-input" name="year"
               value="<?= (int)$year ?>" min="1000" max="<?= date('Y') ?>"
               style="width:100px;">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
    </form>
</div>

<?php if (empty($results)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">📊</div>
        <h3>No data for <?= (int)$year ?></h3>
        <p>No books were published in this year, or none have been added yet.</p>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:64px;">Rank</th>
                    <th>Author</th>
                    <th style="width:180px;text-align:right;">Books in <?= (int)$year ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $i => $row): ?>
                <tr>
                    <td>
                        <?php $rc = match($i) { 0=>'rank-1', 1=>'rank-2', 2=>'rank-3', default=>'rank-n' }; ?>
                        <span class="rank <?= $rc ?>"><?= $i + 1 ?></span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="author-avatar" style="width:34px;height:34px;font-size:.9rem;">
                                <?= mb_strtoupper(mb_substr($row['full_name'], 0, 1)) ?>
                            </div>
                            <?= Html::a(Html::encode($row['full_name']), ['/author/view', 'id' => $row['id']]) ?>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <span class="badge badge-gold"><?= (int)$row['book_count'] ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
