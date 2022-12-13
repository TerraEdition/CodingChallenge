<?php $pager->setSurroundCount(4) ?>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-start">
        <li class="page-item active">
            <a href="#" class="page-link">
                <span aria-hidden="true">Total : <?= $pager->total ?> Data</span>
            </a>
        </li>
    </ul>
    <ul class="pagination justify-content-end">
        <?php if ($pager->hasPrevious()) : ?>
        <li>
            <a href="<?php echo $pager->getPrevious() ?>" aria-label="<?php echo lang('Pager.previous') ?>"
                class="page-item">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php endif ?>
        <?php foreach ($pager->links() as $link) : ?>
        <li class="page-item <?php echo $link['active'] ? 'active' : '' ?>">
            <a href="<?php echo $link['uri'] ?>" class="page-link">
                <?php echo $link['title'] ?>
            </a>
        </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a href="<?php echo $pager->getNext() ?>" aria-label="<?php echo lang('Pager.next') ?>">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php endif ?>
    </ul>
</nav>