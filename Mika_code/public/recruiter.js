// public/recruiter.js

// Sample candidate profiles (you can replace these with dynamic data)
const candidateProfiles = [
    "Data science is an interdisciplinary field that uses scientific methods, processes, algorithms and systems to extract knowledge and insights from data.",
    "Deep learning is a subset of machine learning that uses neural networks to analyze various factors of data.",
    "Natural language processing is a branch of artificial intelligence that helps computers understand, interpret, and generate human language."
  ];
  
  // Get references to DOM elements
  const profilesList = document.getElementById("profiles");
  const compatibilityResult = document.getElementById("compatibility-result");
  const offerTextArea = document.getElementById("offer-input");
  
  // Render candidate profiles in a list
  candidateProfiles.forEach((profile, index) => {
    const li = document.createElement("li");
    li.textContent = profile;
    li.dataset.index = index; // save index for reference if needed
    li.style.cursor = "pointer";
    // When a profile is clicked, compute compatibility with the current job offer.
    li.addEventListener("click", () => {
      computeCompatibility(profile);
    });
    profilesList.appendChild(li);
  });
  
  // Compute compatibility between a candidate's CV and the job offer.
  // In this example, the unified corpus consists of the job offer and all candidate profiles.
  async function computeCompatibility(candidateCV) {
    const offer = offerTextArea.value.trim();
    if (!offer) {
      compatibilityResult.textContent = "N/A (No job offer provided)";
      return;
    }
    
    // Build payload along with unified corpus.
    // Note: We're sending the corpus to the server, so the server-side route must expect it.
    // Alternatively, you could have the server use its own pre-defined corpus.
    const payload = { cv: candidateCV, offer: offer, corpus: [offer, ...candidateProfiles] };
  
    try {
      const response = await fetch('/api/compatibility', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      });
      const data = await response.json();
      compatibilityResult.textContent = (data.similarity * 100).toFixed(2) + "%";
    } catch (err) {
      compatibilityResult.textContent = "Error: " + err.message;
    }
  }
  