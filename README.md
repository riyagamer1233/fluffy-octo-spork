<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Viral Video's</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
  font-family: Arial, sans-serif;
  background: #f8fafc;
  margin: 0;
  color: #1f2937;
}
header {
  background: #1e90ff;
  color: white;
  padding: 1rem;
  text-align: center;
  font-size: 1.25rem;
  font-weight: bold;
}
form {
  background: #fff;
  padding: 1rem;
  margin: 1rem;
  border-radius: 6px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
form input {
  width: 100%;
  margin: 0.5rem 0;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
form button {
  background: #1e90ff;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  margin-top: 0.5rem;
  cursor: pointer;
  border-radius: 4px;
}
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin: 1rem;
}
.card {
  background: white;
  padding: 0.5rem;
  border-radius: 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  text-align: center;
}
.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.card button {
  margin: 0.25rem;
  padding: 0.25rem 0.5rem;
  font-size: 0.9rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.edit-btn { background: #28a745; color: #fff; }
.delete-btn { background: #dc3545; color: #fff; }
</style>
</head>
<body>

<header>Admin Panel - Viral Video's</header>

<form id="videoForm">
  <input type="text" id="poster" placeholder="Poster Image URL" required>
  <input type="text" id="download" placeholder="Download Link URL" required>
  <button type="submit">Save Video</button>
</form>

<div class="grid" id="videoList"></div>

<script>
const form = document.getElementById('videoForm');
const posterInput = document.getElementById('poster');
const downloadInput = document.getElementById('download');
const videoList = document.getElementById('videoList');

let videos = JSON.parse(localStorage.getItem('videos') || '[]');
let editIndex = -1;

function saveVideos() {
  localStorage.setItem('videos', JSON.stringify(videos));
  loadVideos();
}

function loadVideos() {
  videoList.innerHTML = '';
  if (!videos.length) {
    videoList.innerHTML = '<p style="grid-column:1/-1;text-align:center;">No videos added yet.</p>';
    return;
  }
  videos.forEach((v,i) => {
    const card = document.createElement('div');
    card.className = 'card';
    const img = document.createElement('img');
    img.src = v.poster;
    const link = document.createElement('p');
    link.textContent = v.download;
    const editBtn = document.createElement('button');
    editBtn.textContent = 'Edit';
    editBtn.className = 'edit-btn';
    editBtn.onclick = () => editVideo(i);
    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.className = 'delete-btn';
    deleteBtn.onclick = () => deleteVideo(i);
    card.appendChild(img);
    card.appendChild(link);
    card.appendChild(editBtn);
    card.appendChild(deleteBtn);
    videoList.appendChild(card);
  });
}

form.onsubmit = e => {
  e.preventDefault();
  const poster = posterInput.value.trim();
  const download = downloadInput.value.trim();
  if (!poster || !download) return;
  if (editIndex >= 0) {
    videos[editIndex] = { poster, download };
    editIndex = -1;
  } else {
    videos.push({ poster, download });
  }
  posterInput.value = '';
  downloadInput.value = '';
  saveVideos();
};

function editVideo(i) {
  posterInput.value = videos[i].poster;
  downloadInput.value = videos[i].download;
  editIndex = i;
}

function deleteVideo(i) {
  if (!confirm('Delete this video?')) return;
  videos.splice(i,1);
  saveVideos();
}

loadVideos();
</script>

</body>
</html>
