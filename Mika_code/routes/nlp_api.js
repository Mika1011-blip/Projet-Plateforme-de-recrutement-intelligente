// routes/nlp_api.js
import { Router } from 'express';
import { computeDocumentSimilarity } from '../js_functions/analyze_compatibility_nlp.js';

const router = Router();

// Define a fixed sample corpus to be used in compatibility calculations.
const corpus = [
  "Data science is an interdisciplinary field that uses scientific methods, processes, algorithms and systems to extract knowledge and insights from data.",
  "Machine learning is an application of artificial intelligence that provides systems the ability to automatically learn and improve from experience.",
  "Deep learning is a subset of machine learning that uses neural networks to analyze various factors of data.",
  "Artificial intelligence is the simulation of human intelligence in machines that are programmed to think like humans and mimic their actions.",
  "Natural language processing is a branch of artificial intelligence that helps computers understand, interpret, and generate human language.",
  "Big data analytics involves examining large data sets to uncover hidden patterns, correlations, and other insights.",
  "Data mining is the process of discovering patterns in large data sets using methods that blend machine learning, statistics, and database systems.",
  "Computer vision is an interdisciplinary field that trains computers to interpret and understand the visual world.",
  "Predictive modeling is a process that uses statistical techniques and machine learning algorithms to predict future outcomes based on historical data.",
  "Robotics is a branch of technology that involves the design, construction, and operation of robots, which are automated machines."
];

// POST /api/compatibility
// Expects JSON: { cv: string, offer: string }
router.post('/compatibility', (req, res) => {
  console.log("Reached the API port for compatibility computation");
  const { cv, offer } = req.body || {};

  if (!cv || !offer) {
    return res.status(400).json({ error: 'Invalid request data. Both cv and offer are required.' });
  }
  
  try {
    const similarity = computeDocumentSimilarity(cv, offer, corpus);
    return res.json({ similarity });
  } catch (err) {
    console.error("Error computing document similarity:", err);
    return res.status(500).json({ error: err.message });
  }
});

export default router;
