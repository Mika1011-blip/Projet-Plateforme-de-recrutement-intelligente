import express from 'express';
import { analyze_compatibility } from '../js_functions/analyze_compatibility_gpt.js';

const router = express.Router();

// Sample job postings (in a real app, these might come from an external API)
let job_postings = [
  {
    "poste": "Développeur Web Full Stack",
    "description": "Nous recherchons un développeur web full stack pour rejoindre notre équipe dynamique. Vous serez responsable du développement et de la maintenance d'applications web innovantes.",
    "compétences": "JavaScript, Node.js, React, Express, HTML, CSS, SQL",
    "expérience": "Minimum 3 ans d'expérience en développement web",
    "niveau_d_etude": "Licence en informatique ou domaine connexe"
  },
  {
    "poste": "Data Scientist",
    "description": "Nous cherchons un Data Scientist capable d'analyser des ensembles de données volumineux et de fournir des insights exploitables. Vous collaborerez avec des équipes pluridisciplinaires pour optimiser les processus décisionnels.",
    "compétences": "Python, R, Machine Learning, Data Mining, SQL, Visualisation de données (Tableau, PowerBI)",
    "expérience": "2 à 5 ans d'expérience en analyse de données ou en science des données",
    "niveau_d_etude": "Master en statistiques, mathématiques, informatique ou domaine connexe"
  },
  {
    "poste": "Chef de Projet Digital",
    "description": "Responsable de la planification, l'exécution et la clôture de projets digitaux. Vous serez le point de contact principal entre les clients et l'équipe technique, et garantirez le respect des délais et du budget.",
    "compétences": "Gestion de projet, communication, marketing digital, outils de gestion de projet (JIRA, Trello), connaissances techniques de base en développement web",
    "expérience": "Minimum 4 ans d'expérience dans la gestion de projets digitaux",
    "niveau_d_etude": "Bac+5 en gestion de projet, marketing ou domaine similaire"
  }
];

router.post('/job-offers', async (req, res) => {
  try {
    const candidateData = req.body.candidateData;

    // If candidateData is not provided, assign compatibility metrics as "N/A"
    if (!candidateData) {
      const results = job_postings.map(job => ({
        ...job,
        compatibility: {
          skill_match: "N/A",
          experience_match: "N/A",
          education_match: "N/A",
          overall_fit: "N/A",
          comments: "N/A"
        }
      }));
      return res.json(results);
    }
    
    // Otherwise, calculate compatibility for each job offer
    const results = await Promise.all(
      job_postings.map(async (job) => {
        const analysis = await analyze_compatibility(candidateData, job);
        return {
          ...job,
          compatibility: analysis
        };
      })
    );
    
    res.json(results);
  } catch (error) {
    console.error("Error in /api/job-offers:", error);
    res.status(500).json({ error: "Internal server error." });
  }
});

export default router;
