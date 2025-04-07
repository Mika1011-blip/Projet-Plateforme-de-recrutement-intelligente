import express from 'express';
import { fileURLToPath } from 'url';
import path from 'path';
import cvUploadRouter from './routes/cvUpload_api.js';
import jobOffersRouter from './routes/jobOffers_api.js';
import chatbotRouter from './routes/chatbot_api.js';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const port = process.env.PORT || 3000;

// Serve static files from the "public" directory
app.use(express.static('public'));

// Parse JSON bodies for API endpoints
app.use(express.json());

// Use routes for the CV upload and job compatibility endpoints
app.use('/api', cvUploadRouter);
app.use('/api', jobOffersRouter);
app.use('/api', chatbotRouter);

app.listen(port, () => {
  console.log(`Server listening on port ${port}`);
});
