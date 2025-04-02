<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messagerie JobSyn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    
    .messaging-container {
      display: flex;
      gap: 20px;
      padding: 20px;
      background-color: #f1f1f1;
      height: 90vh;
    }
    .contacts {
      width: 25%;
      background-color: #f9f9f9;
      border-radius: 20px;
      padding: 20px;
    }
    .contacts h4 {
      text-align: center;
      font-weight: bold;
    }
    .contact {
      background-color: #c3bfe5;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }
    .chat-area {
      flex: 1;
      background-color: #d9d9d9;
      border-radius: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px;
    }
    .chat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
    }
    .chat-header img {
      height: 24px;
    }
    .messages {
      flex: 1;
      margin: 20px 0;
      overflow-y: auto;
    }
    .chat-input {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .chat-input input[type="text"] {
      flex: 1;
      border-radius: 20px;
      padding: 10px 20px;
      border: none;
    }
    .chat-input button {
      background: none;
      border: none;
    }
    .message.you {
      background-color: #333;
      color: white;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 5px;
      max-width: 70%;
    }
    #attachmentMenu {
      position: absolute;
      top: -40px;
      left: 0;
      display: none;
      background-color: white;
      border: 1px solid #ccc;
      padding: 5px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

    <!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">JobSyn</a>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="index.php"><i class="bi bi-house"></i><br>Accueil</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="emploie.php"><i class="bi bi-people"></i><br>Emplois</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="message.php"><i class="bi bi-envelope"></i><br>Messagerie</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link" href="notification.php"><i class="bi bi-bell"></i><br>Notification</a>
                </li>
                <li class="nav-item text-center mx-2">
                    <a class="nav-link active" href="profil.php"><i class="bi bi-person-circle"></i><br>Profil</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

  <main class="messaging-container">
    <div class="contacts">
      <h4>CONTACT</h4>
      <div class="contact" onclick="selectUser('User A')">
        <img src="https://img.icons8.com/ios-filled/50/user.png">
        USER A
      </div>
      <div class="contact" onclick="selectUser('User B')">
        <img src="https://img.icons8.com/ios-filled/50/user.png">
        USER B
      </div>
    </div>

    <div class="chat-area">
      <div class="chat-header">
        <div><img src="https://img.icons8.com/ios-filled/50/user.png"> <span id="chat-user">USER A</span></div>
        <img src="https://img.icons8.com/ios-filled/50/video-call.png" alt="cam">
      </div>

      <div class="messages" id="messages"></div>

      <div class="chat-input">
        <div style="position: relative;">
          <button id="plusBtn"><img src="https://img.icons8.com/ios-glyphs/30/plus-math.png" alt="+"></button>
          <div id="attachmentMenu">
            <label>
              Pièce jointe
              <input type="file" style="display: none;" onchange="handleFile(event)" />
            </label>
          </div>
        </div>

        <input type="text" id="messageInput" placeholder="Écrire un message..." />
        <button onclick="sendMessage()"><img src="https://img.icons8.com/ios-filled/50/sent.png" alt="envoyer"></button>
      </div>
    </div>
  </main>

  <script>
    function sendMessage() {
      const input = document.getElementById("messageInput");
      const text = input.value.trim();
      if (text !== "") {
        const msg = document.createElement("div");
        msg.className = "message you";
        msg.textContent = text;
        document.getElementById("messages").appendChild(msg);
        input.value = "";
        document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
      }
    }

    function selectUser(name) {
      document.getElementById("chat-user").textContent = name;
      document.getElementById("messages").innerHTML = '';
    }

    document.getElementById("plusBtn").addEventListener("click", () => {
      const menu = document.getElementById("attachmentMenu");
      menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", (e) => {
      const menu = document.getElementById("attachmentMenu");
      const plusBtn = document.getElementById("plusBtn");
      if (!menu.contains(e.target) && !plusBtn.contains(e.target)) {
        menu.style.display = "none";
      }
    });

    function handleFile(event) {
      const file = event.target.files[0];
      if (file) {
        const messageContainer = document.getElementById("messages");
        const msg = document.createElement("div");
        msg.className = "message you";

        const url = URL.createObjectURL(file);
        const extension = file.name.split('.').pop().toLowerCase();

        if (extension === "pdf" || extension === "docx") {
          const preview = document.createElement("div");
          preview.style.display = "flex";
          preview.style.alignItems = "center";
          preview.style.gap = "10px";

          const icon = document.createElement("img");
          icon.src = extension === "pdf"
            ? "https://img.icons8.com/ios-filled/30/pdf.png"
            : "https://img.icons8.com/ios-filled/30/ms-word.png";
          icon.alt = extension;
          icon.style.width = "24px";

          const link = document.createElement("a");
          link.href = url;
          link.target = "_blank";
          link.textContent = file.name;
          link.style.color = "white";
          link.style.textDecoration = "underline";

          preview.appendChild(icon);
          preview.appendChild(link);
          msg.appendChild(preview);
        } else {
          const link = document.createElement("a");
          link.href = url;
          link.target = "_blank";
          link.textContent = `Pièce jointe : ${file.name}`;
          link.style.color = "white";
          link.style.textDecoration = "underline";
          msg.appendChild(link);
        }

        messageContainer.appendChild(msg);
        messageContainer.scrollTop = messageContainer.scrollHeight;
      }
    }
  </script>
</body>
</html>
