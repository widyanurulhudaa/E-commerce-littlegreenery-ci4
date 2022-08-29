<?php $pager->setSurroundCount(2) ?>

<div class="block-27">

    <ul class="">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="">
                <span class="">
                    <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">«

                    </a>
                </span>
            </li>
            <li class="">
                <span class="">
                    <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">&lt;

                    </a>
                </span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="<?= $link['active'] ? 'active' : '' ?>">
                <span class="">
                    <a style="<?= $link['active'] ? 'color: white;' : '' ?> text-center" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </span>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="">
                <span class="">
                    <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">&gt;

                    </a>
                </span>
            </li>
            <li class="">
                <span class="">
                    <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">»

                    </a>
                </span>
            </li>
        <?php endif ?>
    </ul>

</div>