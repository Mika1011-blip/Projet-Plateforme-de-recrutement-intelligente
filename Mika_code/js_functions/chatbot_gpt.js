import dotenv from 'dotenv';
dotenv.config();
import readline from 'readline';
import { Configuration, OpenAIApi } from "openai";
const apiKey = process.env.OPENAI_API_KEY;
const configuration = new Configuration({ apiKey });


const client = new OpenAIApi(configuration);

export async function generateText(input_text) {
  try {
    const completion = await client.createChatCompletion({
      model: "gpt-4o-mini",  // Replace with your desired model if needed
      temperature: 0.7,
      max_tokens: 50,
      messages: [
        {
          role: "system",
          content: "You will reply to my client in a professional tone on topics such as CVs, job offers, and how to improve a CV."
        },
        {
          role: "user",
          content: input_text
        }
      ]
    });
    return completion.data.choices[0].message.content;
  } catch (error) {
    console.error("Chatbot failed to respond:", error);
    throw error;
  }
}

function askQuestion(query) {
  const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
  });
  return new Promise(resolve => rl.question(query, ans => {
    rl.close();
    resolve(ans);
  }));
}

async function main() {
  const user_input = await askQuestion("Text: ");
  const response = await generateText(user_input);
  console.log("Response:", response);
}

main();
