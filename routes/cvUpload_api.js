import express from 'express';
import multer from 'multer';
import fs from 'fs';
import { extractTextFromPDF } from '../js_functions/extract_text_pdf.js';
import { requestDataGPT } from '../js_functions/extract_data_gpt.js';
import { fileURLToPath } from 'url';
import path from 'path';

const router = express.Router();
const upload = multer({ dest: 'uploads/' });

// Get __dirname for ES modules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

router.post('/upload', upload.any(), async (req, res) => {
  try {
    const files = req.files;
    const cv_file = files.find(file => file.fieldname === 'cv');
    const ltr_mtv_file = files.find(file => file.fieldname === 'ltr_mtv');
    let extracted_text = "";
    
    if (cv_file) {
      let cv_path = path.join(__dirname, '..', cv_file.path);
      const cv_text = await extractTextFromPDF(cv_path);
      extracted_text = "CV : " + cv_text;
      fs.unlinkSync(cv_path);
    }
    if (ltr_mtv_file) {
      let ltr_mtv_path = path.join(__dirname, '..', ltr_mtv_file.path);
      const ltr_mtv_text = await extractTextFromPDF(ltr_mtv_path);
      extracted_text += "Lettre de motivation : " + ltr_mtv_text;
      fs.unlinkSync(ltr_mtv_path);
    }
    
    if (extracted_text.length > 0) {
      const gptResult = await requestDataGPT(extracted_text);
      console.log(gptResult);
      res.json({ result: gptResult });
    } else {
      res.status(400).json({ message: "No file uploaded" });
    }
  } catch (error) {
    console.error("Error in /api/upload:", error);
    res.status(500).send("Error processing file.");
  }
});

export default router;
