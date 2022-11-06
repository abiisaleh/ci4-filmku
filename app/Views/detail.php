<?php $this->extend('layout/template') ?>

<?php $this->section('padding') ?>
pb-2
<?php $this->endSection('padding') ?>

<?php $this->section('content') ?>
<div class="tab-content my-4" id="myTabContent">
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="row my-5">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                <div class="card p-4">
                    <img src="https://image.tmdb.org/t/p/original<?= $result['poster_path']; ?>" class="card-img-top" alt="<?= ($result['title'] = null) ? $result['name'] : $result['title']; ?>" height="100%">
                    <div class="card-body bg-crimson rounded-bottom">
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <?php if ($season == 'TRUE') : ?>
                                <a href="#daftarSeason" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                    </svg>
                                    <span class="mx-1">Pesan</span>
                                </a>
                            <?php else : ?>   
                                <a href="https://wa.me/6282238204776?text=<?= urlencode($title.' ('.explode('-',$year)[0].')') ?>" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                    </svg>
                                    <span class="mx-1">Pesan</span>
                                </a>
                            <?php endif;?>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-8 py-4">
                <div class="card">
                    <h1 class="card-title"><?= $title; ?> <?= ($year == '') ? '' : '(' . explode('-', $year)[0] . ')'; ?></h1>
                    <p class="card-text">
                        <small class="text-muted">
                            <span class="badge bg-secondary bg-warning text-bg-light">⭐<?= number_format($rating, 1); ?></span>
                            <?php if (isset($genre)) : ?>
                                <?php foreach ($genre as $genre) : ?>
                                    <a href="/home/genre/<?= $genre['id']; ?>" class="text-muted"><?= $genre['name']; ?></a>
                                <?php endforeach; ?> •
                            <?php endif; ?>
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

                    <?php if (isset($result['tagline'])) : ?>
                        <p class="card-text">
                            <small class="text-muted"><q><?= $result['tagline']; ?></q></small>
                        </p>
                    <?php endif; ?>

                    <div class="row">
                        <!-- load season pake card -->
                        <?php if ($season == '') : ?>
                        <?php elseif ($season == 'TRUE') : ?>
                            <!-- movie player -->
                            <div class="col-12 px-4">
                                <div class="row">
                                    <?php if ($season == '') : ?>
                                    <?php else : ?>
                                        <div class="accordion" id="accordionExample">
                                            <?php foreach ($result['episodes'] as $se) : ?>
                                                <div class="accordion-item text-white">
                                                    <h2 class="accordion-header" id="hs<?= $se['episode_number']; ?>">
                                                        <button class="accordion-button text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#s<?= $se['episode_number']; ?>" aria-expanded="false" aria-controls="s<?= $se['episode_number']; ?>">
                                                            S<?= $se['season_number']; ?>E<?= $se['episode_number']; ?>: <?= $se['name']; ?>
                                                        </button>
                                                    </h2>
                                                    <div id="s<?= $se['episode_number']; ?>" class="accordion-collapse collapse" aria-labelledby="hs<?= $se['episode_number']; ?>" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <?= $se['overview']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="row d-flex my-5" id="daftarSeason">
                                <?php foreach ($season as $seasons) : ?>
                                    <div class="card col-md-2 col-sm-3 col-6 mb-3">
                                        <a href="https://wa.me/6282238204776?text=<?= urlencode($title.' Season '.$seasons['season_number'].' ('.explode('-',$year)[0].')') ?>">
                                            <?php if ($seasons['poster_path'] == null) : ?>
                                                <img src="/img/noimage.png" class="card-img-top" alt="judul">
                                            <?php else : ?>
                                                <img src="https://image.tmdb.org/t/p/original<?= $seasons['poster_path']; ?>" class="card-img-top" alt="judul">
                                            <?php endif ?>
                                        </a>
                                        <div class="card-body p-1">
                                            <h6 class="card-title"><?= $seasons['name']; ?> - 
                                            <?php
                                                if (isset($seasons['air_date'])) {
                                                    echo explode('-', $seasons['air_date'])[0];
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                            </h6>
                                            <p class="card-text text-white-50">
                                                <?= $seasons['episode_count'] ?> E - IDR 
                                                <?= ($seasons['episode_count'] > 10) ? number_format($seasons['episode_count']*5000) : number_format($seasons['episode_count']*10000) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- trailer -->

                    <div class="col-12">
                        <?php
                        foreach ($result['videos']['results'] as $trailer) {
                            if ($trailer['type'] == "Trailer") {
                                $trailerVideo = $trailer;
                            }
                        }
                        if(isset($trailerVideo)) {
                            echo '<iframe src="https://www.youtube.com/embed/' . $trailerVideo['key'] . '" title="'.$trailerVideo['name'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" style="width: 100%; height: 25vh;" allowfullscreen></iframe>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endsection() ?>