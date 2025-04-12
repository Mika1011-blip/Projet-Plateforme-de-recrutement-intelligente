// js_functions/analyze_compatibility_nlp.js
import natural from 'natural';
const porterStemmer = natural.PorterStemmer;

// Stopword lists (minimal sample; extend as needed)
const stopwordsEnglish = ["the", "is", "an", "and", "to", "of", "that", "uses", "with", "a", "in", "from", "for", "on", "it", "by", "are", "this", "as"];
const stopwordsFrench = ["le", "la", "les", "un", "une", "et", "à", "de", "des", "du", "en", "est", "qui", "pour"];
const stopwords = new Set([...stopwordsEnglish, ...stopwordsFrench]);

// --- Phase 1: Text Preprocessing Functions ---

// Remove special characters: keep only letters, digits, and whitespace.
function removeSpecialChars(inputStr) {
  return inputStr.replace(/[^\w\s]/g, "");
}

// Tokenize: split a string on whitespace.
function tokenizeStr(inputStr) {
  inputStr = inputStr.trim();
  return inputStr.split(/\s+/);
}

// Remove stopwords: filter tokens not in our stopword set.
function removeStopwords(tokens) {
  return tokens.filter(token => !stopwords.has(token));
}

// Stem tokens using the Porter stemmer from Natural.
function stemTokens(tokens) {
  return tokens.map(token => porterStemmer.stem(token));
}

// Preprocess the input string: lowercase, remove special chars, tokenize, remove stopwords, then stem.
function preprocess(inputStr) {
  inputStr = inputStr.toLowerCase().trim();
  const noSpecial = removeSpecialChars(inputStr);
  const tokens = tokenizeStr(noSpecial);
  const filtered = removeStopwords(tokens);
  return stemTokens(filtered);
}

// --- Phase 2: Vectorization Functions ---

// Compute Term Frequency (TF): returns an object mapping tokens to their normalized frequency.
function computeTF(tokens) {
  const tf = {};
  tokens.forEach(token => {
    tf[token] = (tf[token] || 0) + 1;
  });
  const total = tokens.length;
  Object.keys(tf).forEach(token => {
    tf[token] = tf[token] / total;
  });
  return tf;
}

// Compute Document Frequency (DF): counts in how many documents a token appears.
function computeDF(token, corpusTokens) {
  let count = 0;
  corpusTokens.forEach(docTokens => {
    if (docTokens.includes(token)) count++;
  });
  return count;
}

// Compute Inverse Document Frequency (IDF) for a token.
function computeIDF(token, corpusTokens) {
  const N = corpusTokens.length;
  return Math.log(N / (1 + computeDF(token, corpusTokens)));
}

// Compute TF‑IDF for a document given its tokens and a corpus (an array of token arrays).
function tfIdf(tokens, corpusTokens) {
  const tfidf = {};
  const tf = computeTF(tokens);
  const uniqueTokens = Array.from(new Set(tokens));
  uniqueTokens.forEach(token => {
    tfidf[token] = tf[token] * computeIDF(token, corpusTokens);
  });
  // Sort the entries alphabetically by token for consistency.
  const sortedEntries = Object.entries(tfidf).sort((a, b) => a[0].localeCompare(b[0]));
  return Object.fromEntries(sortedEntries);
}

// --- Phase 3: Cosine Similarity Function ---

function cosineSimilarity(vectorA, vectorB) {
  // Form union of keys and sort them.
  const keys = Array.from(new Set([...Object.keys(vectorA), ...Object.keys(vectorB)])).sort();
  const valsA = keys.map(key => vectorA[key] || 0);
  const valsB = keys.map(key => vectorB[key] || 0);

  const dotProduct = valsA.reduce((sum, a, i) => sum + a * valsB[i], 0);
  const normA = Math.sqrt(valsA.reduce((sum, a) => sum + a * a, 0));
  const normB = Math.sqrt(valsB.reduce((sum, b) => sum + b * b, 0));

  if (normA === 0 || normB === 0) return 0;
  return dotProduct / (normA * normB);
}

// --- Main Export: Compute Document Similarity ---
// Given two documents (as strings) and a unified corpus (array of strings),
// this function computes the cosine similarity between the TF‑IDF vectors.
export function computeDocumentSimilarity(doc_a, doc_b, corpus) {
  // Preprocess the entire corpus.
  const corpusTokens = corpus.map(doc => preprocess(doc));
  
  // Preprocess the two input documents.
  const tokens_a = preprocess(doc_a);
  const tokens_b = preprocess(doc_b);
  
  // Compute TF‑IDF vectors for each document against the unified corpus.
  const vectorizedDoc_a = tfIdf(tokens_a, corpusTokens);
  const vectorizedDoc_b = tfIdf(tokens_b, corpusTokens);
  
  // Return the cosine similarity.
  return cosineSimilarity(vectorizedDoc_a, vectorizedDoc_b);
}
