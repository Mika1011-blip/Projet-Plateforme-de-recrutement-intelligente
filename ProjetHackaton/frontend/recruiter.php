<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recruteur - Gestion des Offres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script>
    const apiUrl = 'http://localhost:8000';

    async function createJob() {
      const recruiterId = document.getElementById('recruiter_id').value;
      const title = document.getElementById('title').value;
      const description = document.getElementById('description').value;
      const location = document.getElementById('location').value;
      const salary = document.getElementById('salary_range').value;

      const response = await fetch(`${apiUrl}/jobs`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ recruiter_id: recruiterId, title, description, location, salary_range: salary })
      });

      const result = await response.json();
      if (response.ok) {
        alert('Offre créée !');
        listJobs();
      } else {
        alert('Erreur : ' + JSON.stringify(result));
      }
    }

    async function listJobs() {
      const recruiterId = document.getElementById('recruiter_id').value;
      const res = await fetch(`${apiUrl}/jobs`);
      const jobs = await res.json();

      const tbody = document.getElementById('job_table_body');
      tbody.innerHTML = '';

      jobs.filter(job => job.recruiter_id == recruiterId).forEach(job => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${job.id}</td>
          <td>${job.title}</td>
          <td>${job.location}</td>
          <td>${job.salary_range}</td>
          <td>
            <button class="btn btn-info btn-sm" onclick="showUpdateForm(${job.id}, '${job.title}', '${job.description}', '${job.location}', '${job.salary_range}')">Modifier</button>
            <button class="btn btn-danger btn-sm" onclick="deleteJob(${job.id})">Supprimer</button>
            <button class="btn btn-secondary btn-sm" onclick="viewApplications(${job.id})">Candidatures</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    async function deleteJob(id) {
      if (!confirm('Supprimer cette offre ?')) return;
      const res = await fetch(`${apiUrl}/jobs/${id}`, { method: 'DELETE' });
      const result = await res.json();
      alert(result.message);
      listJobs();
    }

    function showUpdateForm(id, title, description, location, salary) {
      document.getElementById('update_section').classList.remove('d-none');
      document.getElementById('update_id').value = id;
      document.getElementById('update_title').value = title;
      document.getElementById('update_description').value = description;
      document.getElementById('update_location').value = location;
      document.getElementById('update_salary_range').value = salary;
    }

    async function updateJob() {
      const id = document.getElementById('update_id').value;
      const title = document.getElementById('update_title').value;
      const description = document.getElementById('update_description').value;
      const location = document.getElementById('update_location').value;
      const salary_range = document.getElementById('update_salary_range').value;

      const response = await fetch(`${apiUrl}/jobs/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ recruiter_id: parseInt(document.getElementById("recruiter_id").value), title, description, location, salary_range })
      });

      const result = await response.json();
      if (response.ok) {
        alert('Offre mise à jour !');
        listJobs();
        document.getElementById('update_section').classList.add('d-none');
      } else {
        alert('Erreur lors de la mise à jour');
      }
    }

    async function viewApplications(jobId) {
      const res = await fetch(`${apiUrl}/applications/${jobId}`);
      const apps = await res.json();
      alert(`Candidatures pour l'offre ${jobId} :\n` + JSON.stringify(apps, null, 2));
    }
  
    async function viewApplications(jobId) {
      const res = await fetch(`${apiUrl}/applications/${jobId}`);
      const apps = await res.json();

      const container = document.getElementById("application_list");
      container.innerHTML = "";

      if (apps.length === 0) {
        container.innerHTML = "<p>Aucune candidature trouvée.</p>";
      } else {
        apps.forEach(app => {
          const statusBadge = {
            pending: ' En attente',
            reviewed: ' Vue',
            accepted: ' Acceptée',
            rejected: ' Refusée'
          };

          const div = document.createElement("div");
          div.classList.add("border", "rounded", "p-3", "mb-3", "bg-light");

          div.innerHTML = `
            <p><strong>Nom:</strong> ${app.full_name}</p>
            <p><strong>Email:</strong> ${app.email}</p>
            <p><strong>Statut:</strong> ${statusBadge[app.status]}</p>
            <button class="btn btn-success btn-sm me-2" onclick="updateApplicationStatus(${app.id}, 'accepted', ${jobId})"> Accepter</button>
            <button class="btn btn-danger btn-sm" onclick="updateApplicationStatus(${app.id}, 'rejected', ${jobId})"> Refuser</button>
          `;

          container.appendChild(div);
        });
      }

      const modal = new bootstrap.Modal(document.getElementById('applicationModal'));
      modal.show();
    }

    async function updateApplicationStatus(appId, status, jobId) {
      const res = await fetch(`${apiUrl}/applications/${appId}/status`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ status: status })
      });

      if (res.ok) {
        viewApplications(jobId);
      } else {
        const err = await res.json();
        alert("Erreur : " + JSON.stringify(err));
      }
    }
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
                  <a class="nav-link" href="../../notification.php"><i class="bi bi-bell"></i><br>Notification</a>
              </li>
              <li class="nav-item text-center mx-2">
                  <a class="nav-link active" href="../../profil.php"><i class="bi bi-person-circle"></i><br>Profil</a>
              </li>
          </ul>
      </div>
  </div>
</nav>

  <div class="container py-5">
    <h2 class="mb-4 text-center">🧑‍💼 Espace Recruteur</h2>

    <div class="mb-4">
      <label for="recruiter_id" class="form-label">ID Recruteur :</label>
      <input type="number" id="recruiter_id" class="form-control" placeholder="Entrez votre ID recruteur" oninput="listJobs()">
    </div>

    <div class="card p-4 mb-4">
      <h4>Créer une offre</h4>
      <input class="form-control mb-2" type="text" id="title" placeholder="Titre">
      <textarea class="form-control mb-2" id="description" placeholder="Description"></textarea>
      <input class="form-control mb-2" type="text" id="location" placeholder="Localisation">
      <input class="form-control mb-2" type="text" id="salary_range" placeholder="Salaire">
      <button class="btn btn-primary" onclick="createJob()">Créer</button>
    </div>

    <div class="card p-4 mb-4">
      <h4>Liste de vos offres</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Localisation</th>
            <th>Salaire</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="job_table_body"></tbody>
      </table>
    </div>

    <div id="update_section" class="card p-4 d-none">
      <h4>Modifier une offre</h4>
      <input type="hidden" id="update_id">
      <input class="form-control mb-2" type="text" id="update_title" placeholder="Titre">
      <textarea class="form-control mb-2" id="update_description" placeholder="Description"></textarea>
      <input class="form-control mb-2" type="text" id="update_location" placeholder="Localisation">
      <input class="form-control mb-2" type="text" id="update_salary_range" placeholder="Salaire">
      <button class="btn btn-success" onclick="updateJob()">Mettre à jour</button>
    </div>
  </div>

<!-- MODALE CANDIDATURES -->
<div class="modal fade" id="applicationsModal" tabindex="-1" aria-labelledby="applicationsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicationsModalLabel">Candidatures</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Candidat</th>
              <th>Nom</th>
              <th>Email</th>
              <th>CV</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="applicationsTableBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  async function viewApplications(jobId) {
    const res = await fetch(`${apiUrl}/applications/${jobId}`);
    const applications = await res.json();
    const tableBody = document.getElementById("applicationsTableBody");
    tableBody.innerHTML = "";

    if (applications.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="6" class="text-center">Aucune candidature</td></tr>`;
    } else {
      applications.forEach(app => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${app.candidate_id}</td>
          <td>${app.candidate_name}</td>
          <td>${app.candidate_email}</td>
          <td><a href="${app.resume_url}" target="_blank">Voir le CV</a></td>
          <td>${app.status}</td>
          <td>
            <button class="btn btn-success btn-sm" onclick="updateApplicationStatus(${app.id}, 'acceptée')">Accepter</button>
            <button class="btn btn-danger btn-sm" onclick="updateApplicationStatus(${app.id}, 'refusée')">Refuser</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    }

    const modal = new bootstrap.Modal(document.getElementById("applicationsModal"));
    modal.show();
  }

  async function updateApplicationStatus(applicationId, status) {
    const res = await fetch(`${apiUrl}/applications/${applicationId}/status`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ status: status })
    });

    if (res.ok) {
      alert("Statut mis à jour !");
      const recruiterId = document.getElementById("recruiter_id").value;
      listJobs(); // refresh job list
    } else {
      alert("Erreur lors de la mise à jour");
    }
  }
</script>


<!-- Modal Bootstrap -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="applicationModalLabel">Candidatures</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div id="application_list"></div>
      </div>
    </div>
  </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
