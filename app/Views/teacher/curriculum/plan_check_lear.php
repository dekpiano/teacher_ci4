<?= $this->extend('teacher/layout/main') ?>

<?= $this->section('title') ?>
<?= esc($title ?? '') ?><?= esc($lean[0]->lear_namethai ?? '') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= esc($title ?? '') ?><?= esc($lean[0]->lear_namethai ?? '') ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?= site_url('curriculum/check-plan') ?>">กลุ่มสาระ</a></li>
                        <li class="breadcrumb-item active"><?= esc($lean[0]->lear_namethai ?? '') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="articles card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="h3">กลุ่มสาระการเรียนรู้<?= esc($lean[0]->lear_namethai ?? '') ?> </h4>
                </div>
                <?php if(isset($techer) && !empty($techer)): ?>
                <?php  foreach ($techer as $v_techer): ?>

                <div class="card-body no-padding">
                    <div class="item d-flex align-items-center">
                        <div class="image"><img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($v_techer->pers_img) ?>"
                                alt="..." class="img-fluid rounded-circle"></div>
                        <div class="text"><a href="<?= site_url('curriculum/check-plan-lear-teacher/' . esc($lean[0]->lear_id) . '/' . esc($v_techer->pers_id) . '/' . (isset($OnOff[0]) ? esc($OnOff[0]->seplanset_year) : '') . '/' . (isset($OnOff[0]) ? esc($OnOff[0]->seplanset_term) : '')) ?>">
                                <h3 class="h5">
                                    <?= esc($v_techer->pers_prefix . $v_techer->pers_firstname . ' ' . $v_techer->pers_lastname) ?></h3>
                            </a><small><?= esc($lean[0]->lear_namethai ?? '') ?></small>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="card-body">
                    <div class="text-center">ไม่พบครูผู้สอนในกลุ่มสาระนี้</div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>