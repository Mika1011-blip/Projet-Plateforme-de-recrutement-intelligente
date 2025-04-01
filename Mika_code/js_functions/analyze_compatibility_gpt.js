import dotenv from 'dotenv';
dotenv.config();

import { Configuration, OpenAIApi } from "openai";
const apiKey = process.env.OPENAI_API_KEY;
const configuration = new Configuration({ apiKey });
const client = new OpenAIApi(configuration);


  export async function analyze_compatibility(cv_data_extract, job_data_extract) {
    const prompt = `You are an expert candidate compatibility analyzer.
  Given the following candidate data:
  ${cv_data_extract}
  
  And the following job posting data:
  ${job_data_extract}
  
  Please analyze the compatibility between the candidate and the job requirements.
  Return your answer strictly as a JSON object with the following keys:
  - "skill_match": a percentage (without % symbol)or description of how the candidate's skills match the job requirements.
  - "experience_match": a percentage (without % symbol) reflecting how the candidate's experience fits.
  - "education_match": a percentage (without % symbol)indicating the match in terms of education level.
  - "overall_fit": a percentage (without % symbol)summarizing the overall compatibility.
  - "comments": a brief explanation of your analysis and add what's to be improved or learned (write as you are talking to the candidate).
  
  Do not include any additional text. and all output in french`;
  
    try {
      const completion = await client.createChatCompletion({
        model: "gpt-4o-mini",
        temperature: 0.0,
        max_tokens: 250,
        messages: [
          {
            role: "system",
            content: prompt
          }
        ]
      });
  
      let messageContent = completion.data.choices[0].message.content;
      
      // Remove markdown code block markers if present
      messageContent = messageContent.replace(/```(json)?/g, '').replace(/```/g, '').trim();
      
      const analysis_result = JSON.parse(messageContent);
      //console.log(analysis_result);
      return analysis_result;
    } catch (error) {
      console.error("Error in requestDataGPT:", error);
      throw error;
    }
  }
  