import express from 'express';
import { generateText } from '../js_functions/chatbot_gpt.js';

const router = express.Router();


router.post('/chat',async(req,res)=>{
    try {
        const input_message = req.body.text;
        const response = await generateText(input_message);
        res.json(response);
    } catch (error) {
        console.error("Error in /chat:", error);
        res.status(500).json({ error: error.message });
    }
})

export default router;