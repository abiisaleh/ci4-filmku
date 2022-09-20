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

<?php $this->section('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="#"><?= ($season == '') ? 'Movie' : 'TV Show'; ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
<?php $this->endSection('breadcrumb'); ?>

<?php $this->section('content') ?>
<div class="tab-content my-4" id="myTabContent">
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="row my-5">
            <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                <div class="card p-4">
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
        <div class="row">
            <!-- load season pake card -->
            <?php if ($season == '') : ?>

                <!-- webtorrent player -->
                <div class="col-auto" id="stream"></div>
            <?php elseif ($season == 'TRUE') : ?>
                <!-- movie player -->
                <div class="col-12 col-lg-8 px-2 mb-2">
                    <iframe class="col-12" src="https://drive.google.com/file/d/1xaxncu1Q6GzWScdrBYmwvPl3dBSbIcxY/preview" allow="autoplay" style="height: 60vh"></iframe>
                </div>
                <div class="col-12 col-lg-4 px-4">
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
                <div class="row d-flex my-5">
                    <?php foreach ($season as $seasons) : ?>
                        <div class="card col-md-2 col-sm-3 col-6 mb-3">
                            <a href="/home/detail/tv/<?= $result['id']; ?>/<?= $seasons['season_number']; ?>">
                                <?php if ($seasons['poster_path'] == null) : ?>
                                    <img src="/img/noimage.png" class="card-img-top" alt="judul">
                                <?php else : ?>
                                    <img src="https://image.tmdb.org/t/p/original<?= $seasons['poster_path']; ?>" class="card-img-top" alt="judul">
                                <?php endif ?>
                            </a>
                            <div class="card-body p-1">
                                <h6 class="card-title"><?= $seasons['name']; ?></h6>
                                <p class="card-text text-white-50">
                                    <?php
                                    if (isset($seasons['air_date'])) {
                                        echo explode('-', $seasons['air_date'])[0];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php $this->endsection() ?>

    <?php $this->section('script'); ?>
    <!-- Include the latest version of WebTorrent -->
    <script src="https://cdn.jsdelivr.net/npm/webtorrent@latest/webtorrent.min.js"></script>

    <script>
        const client = new WebTorrent()

        // Sintel, a free, Creative Commons movie
        // const torrentId = 'magnet:?xt=urn:btih:08ada5a7a6183aae1e09d831df6748d566095a10&dn=Sintel&tr=udp%3A%2F%2Fexplodie.org%3A6969&tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&tr=udp%3A%2F%2Ftracker.empire-js.us%3A1337&tr=udp%3A%2F%2Ftracker.leechers-paradise.org%3A6969&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337&tr=wss%3A%2F%2Ftracker.btorrent.xyz&tr=wss%3A%2F%2Ftracker.fastcast.nz&tr=wss%3A%2F%2Ftracker.openwebtorrent.com&ws=https%3A%2F%2Fwebtorrent.io%2Ftorrents%2F&xs=https%3A%2F%2Fwebtorrent.io%2Ftorrents%2Fsintel.torrent'

        const torrentId = 'magnet:?xt=urn:btih:784C259129A0C749881F4724570E2F0BFE11F797&amp;dn=Day%20Shift%20(2022)&amp;tr=udp%3A%2F%2Fglotorrents.pw%3A6969%2Fannounce&amp;tr=udp%3A%2F%2Ftracker.openbittorrent.com%3A80&amp;tr=udp%3A%2F%2Ftracker.coppersurfer.tk%3A6969&amp;tr=udp%3A%2F%2Fp4p.arenabg.ch%3A1337&amp;tr=udp%3A%2F%2Ftracker.internetwarriors.net%3A1337'

        client.add(torrentId, function(torrent) {
            // Torrents can contain many files. Let's use the .mp4 file
            const file = torrent.files.find(function(file) {
                return file.name.endsWith('.mp4')
            })

            // Display the file by adding it to the DOM.
            // Supports video, audio, image files, and more!
            file.appendTo('#stream')
        })
    </script>
    <?php $this->endsection() ?>