// public/candidate.js

async function computeCompatibility() {
    // Extract the text values from the textareas.
    const cv = document.getElementById('cv-input').value;
    const offer = document.getElementById('offer-input').value;
  
    // Build the payload to be sent to the server.
    const payload = { cv, offer };
  
    try {
      const response = await fetch('/api/compatibility', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });
      const data = await response.json();
      // Convert the similarity (0-1) to a percentage string.
      document.getElementById('compatibility-result').innerHTML = (data.similarity * 100).toFixed(2) + "%";
    } catch (err) {
      document.getElementById('compatibility-result').innerHTML = 'Error: ' + err.message;
    }
  }
  
  // Listen for the form submission.
  document.getElementById('files_upload').addEventListener('submit', async (e) => {
    e.preventDefault();
    computeCompatibility();
  });
  