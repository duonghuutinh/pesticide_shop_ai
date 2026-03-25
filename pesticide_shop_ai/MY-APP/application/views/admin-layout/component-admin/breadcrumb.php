<!-- <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?php echo $title?></h2>
        <ol class="breadcrumb breadcrumb-custom">
            <li>
                <a href="<?php echo base_url('dashboard')?>">Dashboard</a>
            </li>
            <li class="active"><strong><?php echo $title?></strong></li>
        </ol>
    </div>
</div> -->



<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?= $title ?? '' ?></h2>
        <?php if (!empty($breadcrumb)): ?>
            <ol class="breadcrumb breadcrumb-custom">
                <?php foreach ($breadcrumb as $item): ?>
                    <li class="<?= isset($item['url']) ? '' : 'active' ?>">
                        <?php if (isset($item['url'])): ?>
                            <a href="<?= base_url($item['url']) ?>"><?= $item['label'] ?></a>
                        <?php else: ?>
                            <strong><?= $item['label'] ?></strong>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</div>
