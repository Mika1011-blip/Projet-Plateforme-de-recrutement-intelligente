<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidat - Postuler</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    #debug_console {
      white-space: pre-wrap;
      background: #f8f9fa;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ced4da;
      max-height: 150px;
      overflow-y: auto;
      font-size: 0.85rem;
    }
  </style>
  <script>
    const apiUrl = 'http://localhost:8000';

    async function listJobs() {
      const container = document.getElementById('job_list');
      container.innerHTML = '<p>Chargement des offres...</p>';
      try {
        const res = await fetch(`${apiUrl}/jobs`);
        if (!res.ok) {
          throw new Error(`Erreur ${res.status}: ${res.statusText}`);
        }
        const jobs = await res.json();

      
        container.innerHTML = '';

        if (!Array.isArray(jobs) || jobs.length === 0) {
          container.innerHTML = '<p>Aucune offre disponible.</p>';
          return;
        }

        jobs.forEach(job => {
          const card = document.createElement('div');
          card.className = 'card mb-3 p-3';
          card.innerHTML = `
            <h5>${job.title}</h5>
            <p>${job.description}</p>
            <p><strong>Lieu:</strong> ${job.location || 'N/A'} | <strong>Salaire:</strong> ${job.salary_range || 'N/A'}</p>
            <button class="btn btn-primary" onclick="showApplicationForm(${job.id}, '${job.title}')">Postuler</button>
          `;
          container.appendChild(card);
        });
      } catch (error) {
        container.innerHTML = '<p class="text-danger">Erreur lors du chargement des offres.</p>';
        // document.getElementById('debug_console').textContent = error;
        document.getElementById('debug_console').textContent = error.message;

      }
    }

    function showApplicationForm(jobId, jobTitle) {
      document.getElementById('form_container').classList.remove('d-none');
      document.getElementById('job_id').value = jobId;
      document.getElementById('job_title_display').textContent = jobTitle;
    }

    async function submitApplication() {
      const form = document.getElementById('application_form');
      const formData = new FormData(form);
      try {
        const response = await fetch(`${apiUrl}/applications/upload`, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();
        if (response.ok) {
          alert('Candidature envoyée avec succès !');
          form.reset();
          document.getElementById('form_container').classList.add('d-none');
        } else {
          alert('Erreur : ' + JSON.stringify(result));
          document.getElementById('debug_console').textContent = JSON.stringify(result, null, 2);
        }
      } catch (error) {
      alert("Erreur lors de l'envoi.");
      document.getElementById('debug_console').textContent = error;
    }

        }

    window.onload = listJobs;
  </script>

</head>

<body class="bg-light">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
  <div class="container-fluid">
      <a class="navbar-brand" href="#">JobSyn</a>

      <div class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav">
              <li class="nav-item text-center mx-2">
                  <a class="nav-link" href="../../index.php"><i class="bi bi-house"></i><br>Accueil</a>
              </li>
              <li class="nav-item text-center mx-2">
                  <a class="nav-link" href="../../about.php"><i class="bi bi-people"></i><br>A propos</a>
              </li>
              <li class="nav-item text-center mx-2">
                  <a class="nav-link" href="../../message.php"><i class="bi bi-envelope"></i><br>Messagerie</a>
              </li>
              <li class="nav-item text-center mx-2">
                  <!-- <a class="nav-link" href="../../notification.php"><i class="bi bi-bell"></i><br>Notification</a> -->
                  <a class="nav-link" href="./candidate.php"><i class="bi bi-bell"></i><br>Nos offres</a>
              </li>
              <li class="nav-item text-center mx-2">
                  <a class="nav-link active" href="../../profil.php"><i class="bi bi-person-circle"></i><br>Profil</a>
              </li>
              <li>
                <?php
                    if (isset($_SESSION["nom"])) {
                        echo "Bonjour " . $_SESSION["nom"];
                    } else {
                        echo "<a class='btn btn-primary' href='../../test_laissad/decoData.html'>se connecter</a>";
                    }
                ?>
            </li>
          </ul>
      </div>
  </div>
</nav>




  <div class="container py-5">
    <h2 class="mb-4 text-center">🎯 Offres d'emploi disponibles</h2>
    <div id="job_list"></div>

    <div id="form_container" class="card p-4 shadow-sm mt-4 d-none">
      <h4>Formulaire de candidature pour : <span id="job_title_display"></span></h4>
      <form id="application_form" onsubmit="event.preventDefault(); submitApplication();">
        <input type="hidden" name="job_id" id="job_id">
        <input class="form-control mb-2" type="text" name="candidate_name" placeholder="Votre nom" required>
        <input class="form-control mb-2" type="email" name="candidate_email" placeholder="Votre email" required>
        <input class="form-control mb-2" type="text" name="candidate_phone" placeholder="Votre téléphone" required>
        <label class="form-label">Votre CV :</label>
        <input class="form-control mb-2" type="file" name="cv" accept="application/pdf" required>
        <label class="form-label">Lettre de motivation :</label>
        <input class="form-control mb-2" type="file" name="cover_letter" accept="application/pdf" required>
        <button class="btn btn-success">Envoyer</button>
      </form>
    </div>

    <!-- <div class="mt-4">
      <label> Console de debug</label>
      <input type="text" id="debug_console" class="form-control bg-white" readonly>
    </div> -->
    
  </div>


  <div class="container py-4">
    <footer class="pt-4 mt-4 border-top">
      <div class="row">
        <!-- Logo & Description -->
        <div class="col-md-4 mb-3">
          <h5 class="fw-bold text-primary">JobSyn</h5>
          <p class="text-muted">
            JobSyn est une plateforme de recrutement en ligne qui connecte les talents aux meilleures opportunités d’emploi. Simple, rapide et efficace.
          </p>
        </div>
  
        <!-- Liens utiles -->
        <div class="col-md-4 mb-3">
          <h6 class="fw-semibold">Liens utiles</h6>
          <ul class="list-unstyled">
            <li><a href="#" class="text-decoration-none text-muted">Accueil</a></li>
            <li><a href="#" class="text-decoration-none text-muted">Offres d'emploi</a></li>
            <li><a href="#" class="text-decoration-none text-muted">Candidats</a></li>
            <li><a href="#" class="text-decoration-none text-muted">Contact</a></li>
          </ul>
        </div>
  
        <!-- Contact -->
        <div class="col-md-4 mb-3">
          <h6 class="fw-semibold">Nous contacter</h6>
          <p class="text-muted mb-1"> Paris, France</p>
          <p class="text-muted mb-1"> +33 77 123 45 67</p>
          <p class="text-muted">📧 contact@jobsyn.com</p>
        </div>
      </div>
  
      <!-- Bas de page -->
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
        <p class="mb-0 text-muted">&copy; 2025 JobSyn. Tous droits réservés.</p>
        <div>
          <a href="#" class="text-muted me-3"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
    </footer>
  </div>
</body>
</html>