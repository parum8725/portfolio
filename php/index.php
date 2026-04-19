<?php
require_once __DIR__ . '/includes/functions.php';

$profile = $conn->query("SELECT * FROM profile ORDER BY id ASC LIMIT 1")->fetch_assoc();
if (!$profile) {
    $profile = ['brand_name'=>'Sarah Ika','name'=>'Nama Anda','subtitle'=>'Subtitle','photo'=>null,'instagram'=>'#','linkedin'=>'#','footer_text'=>'© '.date('Y')];
}

$about = $conn->query("SELECT * FROM about ORDER BY id ASC LIMIT 1")->fetch_assoc();
$about_text = $about['content'] ?? '';

$organizations = $conn->query("SELECT * FROM organizations ORDER BY sort_order ASC, id ASC");
$projects = $conn->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC");

$flash = flash_get();
$img_base = IMG_URL_PUBLIC;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Portfolio | <?= e($profile['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
  </head>
  <body id="home">

    <!-- Navbar -->
    <nav class="navbar navbar-default fixed-top navbar-expand-lg navbar-dark shadow-sm" style="background-color: plum">
      <div class="container">
        <a class="navbar-brand" href="#"><?= e($profile['brand_name']) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#Organization">Organization</a></li>
            <li class="nav-item"><a class="nav-link" href="#projects">Projects & Certificate</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Jumbotron -->
    <section class="jumbotron text-center">
      <?php if (!empty($profile['photo'])): ?>
        <img src="<?= e($img_base . $profile['photo']) ?>" alt="<?= e($profile['name']) ?>"
             width="200" class="rounded-circle img-thumbnail" />
      <?php endif; ?>
      <h1 class="display-4"><?= e($profile['name']) ?></h1>
      <p class="lead"><?= e($profile['subtitle']) ?></p>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#fff" fill-opacity="1" d="M0,160L18.5,144C36.9,128,74,96,111,106.7C147.7,117,185,171,222,197.3C258.5,224,295,224,332,202.7C369.2,181,406,139,443,128C480,117,517,139,554,160C590.8,181,628,203,665,213.3C701.5,224,738,224,775,229.3C812.3,235,849,245,886,224C923.1,203,960,149,997,106.7C1033.8,64,1071,32,1108,64C1144.6,96,1182,192,1218,218.7C1255.4,245,1292,203,1329,197.3C1366.2,192,1403,224,1422,240L1440,256L1440,320L1421.5,320C1403.1,320,1366,320,1329,320C1292.3,320,1255,320,1218,320C1181.5,320,1145,320,1108,320C1070.8,320,1034,320,997,320C960,320,923,320,886,320C849.2,320,812,320,775,320C738.5,320,702,320,665,320C627.7,320,591,320,554,320C516.9,320,480,320,443,320C406.2,320,369,320,332,320C295.4,320,258,320,222,320C184.6,320,148,320,111,320C73.8,320,37,320,18,320L0,320Z"></path>
      </svg>
    </section>

    <!-- About -->
    <section id="about">
      <div class="container">
        <div class="row text-center mb-5">
          <div class="col"><h2>About Me</h2></div>
        </div>
        <div>
          <div>
            <p class="text-justify"><?= nl2br(e($about_text)) ?></p>
          </div>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgb(246, 226, 255)" fill-opacity="1" d="M0,224L1440,224L1440,320L0,320Z"></path></svg>
    </section>

    <!-- Organization -->
    <section id="Organization">
      <div class="container">
        <div class="row text-center">
          <div class="col mb-5"><h2>Organization</h2></div>
        </div>
        <div class="row">
          <?php if ($organizations && $organizations->num_rows): ?>
            <?php while ($o = $organizations->fetch_assoc()): ?>
              <div class="col-md-15 mb-1">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title"><?= e($o['title']) ?></h5>
                    <p class="card-text"><?= e($o['role']) ?></p>
                    <ul class="custom-list">
                      <?php foreach (explode("\n", $o['items']) as $item):
                              $item = trim($item);
                              if ($item === '') continue; ?>
                        <li><?= e($item) ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgb(246, 226, 255)" fill-opacity="1" d="M0,224L1440,224L1440,320L0,320Z"></path></svg>

    <!-- Projects -->
    <section id="projects">
      <div class="container">
        <div class="row text-center">
          <div class="col mb-5"><h2>My Projects & Certificate</h2></div>
        </div>
        <div class="row">
          <?php if ($projects && $projects->num_rows): ?>
            <?php while ($p = $projects->fetch_assoc()): ?>
              <div class="col-md-4 mb-3">
                <div class="card">
                  <?php if (!empty($p['image'])): ?>
                    <img src="<?= e($img_base . $p['image']) ?>" class="card-img-top" alt="<?= e($p['title']) ?>" />
                  <?php endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><?= e($p['title']) ?></h5>
                    <p class="card-text"><?= e($p['description']) ?></p>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgb(246, 226, 255)" fill-opacity="1" d="M0,224L1440,224L1440,320L0,320Z"></path></svg>
    </section>

    <!-- Contact -->
    <section id="contact">
      <div class="container mb-5">
        <div class="row text-center">
          <div class="col mb-5"><h2>Contact Me</h2></div>
        </div>

        <?php if ($flash): ?>
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
            </div>
          </div>
        <?php endif; ?>

        <div class="row justify-content-center">
          <div class="col-md-8">
            <form method="post" action="crud/contact_process.php">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" required />
              </div>
              <div class="mb-3">
                <label for="pesan" class="form-label">Massage</label>
                <textarea name="message" class="form-control" id="pesan" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary">SEND</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <footer class="d-flex text-white flex-wrap text-center justify-content-center align-items-center p-4">
      <div>
        <?php if (!empty($profile['instagram'])): ?>
          <a target="_blank" href="<?= e($profile['instagram']) ?>" class="text-white mx-2">
            <i class="bi bi-instagram" style="font-size: 1.5rem;"></i>
          </a>
        <?php endif; ?>
        <?php if (!empty($profile['linkedin'])): ?>
          <a target="_blank" href="<?= e($profile['linkedin']) ?>" class="text-white mx-2">
            <i class="bi bi-linkedin" style="font-size: 1.5rem;"></i>
          </a>
        <?php endif; ?>
      </div>
      <div class="w-100 text-center mt-2">
        <p><?= e($profile['footer_text'] ?? ('© ' . date('Y') . ' Created by ' . $profile['brand_name'])) ?></p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
