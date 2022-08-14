<?php $this->extend('layout/template') ?>

<?php $this->section('content') ?>
<div>
    <ul class="text-center nav justify-content-center">
        <li class="nav-item">
            <a class="d-block text-dark text-decoration-none mx-3" href="/">
                <div class="p-2 bg-dark text-center rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" fill="<?= ($nav == 'trending') ? 'crimson' : '#adb5bd'; ?>" class="bi bi-fire" viewBox="0 0 16 16">
                        <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">Trending</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="d-block text-dark text-decoration-none mx-3" href="/home/populer">
                <div class="p-2 bg-dark text-center rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" fill="<?= ($nav == 'populer') ? 'crimson' : '#adb5bd'; ?>" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">Populer</div>
            </a>
        </li>
        <li class="nav-item">
            <a class="d-block text-dark text-decoration-none mx-3" href="/home/genre">
                <div class="p-2 bg-dark text-center rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" fill="<?= ($nav == 'genre') ? 'crimson' : '#adb5bd'; ?>" class="bi bi-grid-fill" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z" />
                    </svg>
                </div>
                <div class="name text-muted text-decoration-none text-center pt-1">Genre</div>
            </a>
        </li>
    </ul>
</div>

<div class="row my-5 py-3">
    <div class="col text-center">
        <?php foreach ($genre as $genres) : ?>
            <a href="/home/genre/<?= $genres['name']; ?>" class="btn btn-outline-danger m-1"><?= $genres['name']; ?></a>
        <?php endforeach; ?>
    </div>
</div>

<?php $this->endsection() ?>