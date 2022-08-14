<?php $this->extend('layout/template') ?>

<?php $this->section('tabs') ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active px-5" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Overview</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link px-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Streaming</button>
    </li>
</ul>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="tab-content my-4" id="myTabContent">
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="row my-5">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3 p-4">
                <div class="card">
                    <img src="https://image.tmdb.org/t/p/original<?= $result['poster_path']; ?>" class="card-img-top" alt="<?= ($result['title'] = null) ? $result['name'] : $result['title']; ?>" height="100%">
                    <div class="card-body bg-crimson rounded-bottom">
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <a href="#" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                </svg>
                                <span class="mx-2">Download</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-8 py-4">
                <div class="card">
                    <h1 class="card-title"><?= $title; ?> <?= ($year == '') ? '' : '(' . explode('-', $year)[0] . ')'; ?></h1>
                    <p class="card-text">
                        <small class="text-muted">
                            <span class="badge bg-secondary bg-warning text-bg-light">⭐<?= number_format($result['vote_average'], 1); ?></span>
                            <?php foreach ($result['genres'] as $genre) echo '<a href="/" class="text-muted">' . $genre['name'] . '</a>' . ' '; ?> •
                            <?php
                            $jam = $duration / 60; //dibagi 1 jam
                            $menit = $duration % 60; //sisa pembagian 60 mod

                            echo (int) $jam  . 'j ' . $menit . 'm';
                            ?>
                        </small>
                    </p>

                    <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; max-width: -webkit-fill-available; max-height: 100;">
                        <?= $deskripsi; ?>
                    </p>

                    <p class="card-text">
                        <small class="text-muted"><q><?= $result['tagline']; ?></q></small>
                    </p>

                    <!-- load season pake card -->
                    <?php if ($season == '') : ?>
                    <?php else : ?>
                        <div class="row d-flex mb-2">
                            <?php foreach ($season as $season) : ?>
                                <div class="card col-md-2 col-sm-3 col-6">
                                    <a href="/home/detail/tv/<?= $season['id']; ?>">
                                        <?php if ($season['poster_path'] == null) : ?>
                                            <img src="/img/noimage.png" class="card-img-top" alt="judul">
                                        <?php else : ?>
                                            <img src="https://image.tmdb.org/t/p/original<?= $season['poster_path']; ?>" class="card-img-top" alt="judul">
                                        <?php endif ?>
                                    </a>
                                    <div class="card-body p-1">
                                        <h6 class="card-title"><?= $season['name']; ?></h6>
                                        <p class="card-text text-white-50">
                                            <?php
                                            if (isset($season['air_date'])) {
                                                echo explode('-', $season['air_date'])[0];
                                            } else {
                                                echo 'Belum Rilis';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- trailer -->

                    <div class="col-12">
                        <?php
                        if (isset($result['videos']['results'][0]['key'])) {
                            echo '<iframe width="350" height="200" src="https://www.youtube.com/embed/' . $result['videos']['results'][0]['key'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        } else {
                            echo '';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        tempat streaming dan download
    </div>
</div>
<?php $this->endsection() ?>