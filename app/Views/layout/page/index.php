<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>
<div class="row">
    <h1>Populer</h1>
    <?php foreach ($result as $judul) : ?>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div class="card">
                <img src="<?= $judul['image']; ?>" class="card-img-top" alt="<?= $judul['title']; ?>">
                <div class="card-body">
                    <p class="card-text"><?= $judul['title']; ?> • <?= $judul['year']; ?> • <?= $judul['imDbRating']; ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php $this->endsection('content'); ?>