import dotenv from 'dotenv';
dotenv.config();

import { Configuration, OpenAIApi } from "openai";
const apiKey = process.env.OPENAI_API_KEY;
const configuration = new Configuration({ apiKey });
const client = new OpenAIApi(configuration);


export async function requestDataGPT(input_document_str) {
  try {
    const completion = await client.createChatCompletion({
      model: "gpt-4o-mini",
      temperature: 0.0,
      max_tokens: 250,
      messages: [
        {
          role: "system",
          content: `Vous êtes un assistant d'extraction de données. Analysez le texte de CV fourni et extrayez les informations suivantes :
- "nom": Le nom complet du candidat.
- "âge": L'âge du candidat (si non disponible, utilisez "N/A").
- "email": L'adresse e-mail du candidat.
- "téléphone": Le numéro de téléphone du candidat.
- "compétences": Une liste ou une chaîne de caractères séparée par des virgules des compétences techniques et interpersonnelles clés.
- "poste": Le poste ciblé, déduit du CV si ce n'est pas explicitement mentionné.
- "expériences": Un bref résumé des expériences professionnelles du candidat.
- "niveau_d_etude": Le niveau d'études du candidat.
- "score_de_motivation": Un score de 1 à 10 évaluant la qualité de la lettre de motivation. Si aucune lettre de motivation n'est détectée, utilisez "N/A".
- "score_de_qualité": Un score de 1 à 10 évaluant la correspondance entre les compétences/expériences du candidat et le poste ciblé.

Retournez votre réponse strictement sous la forme d'un objet JSON avec les clés :
"nom", "âge", "email", "téléphone", "compétences", "poste", "expériences", "niveau_d_etude", "score_de_motivation", et "score_de_qualité". Ne fournissez aucun commentaire supplémentaire.`
        },
        {
          role: "user",
          content: `Voici le texte extrait : ${input_document_str}`
        }
      ]
    });

    const messageContent = completion.data.choices[0].message.content;
    return messageContent;
  } catch (error) {
    console.error("Error in requestDataGPT:", error);
    throw error;
  }
}
