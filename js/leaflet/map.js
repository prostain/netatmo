////////////// MAP //////////////
// Création de la carte
// SetView(Position, puissance du zoom)
let map = L.map('map').setView([44.94, 6.64], 11);

// Mentions aux développeurs
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);