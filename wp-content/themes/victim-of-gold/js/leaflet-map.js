/**
 * Victim of Gold - Leaflet Map Integration
 * 
 * Initializes a custom styled map for the shop location using Leaflet and OpenStreetMap
 * This file is specifically for the map-section on the homepage
 */

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Check if the map container exists
  const mapElement = document.getElementById('leaflet-map');
  if (!mapElement) return;
  
  // Initialize the map
  initLeafletMap();
});

// Initialize the map
function initLeafletMap() {
  // Check if the map container exists
  const mapElement = document.getElementById('leaflet-map');
  if (!mapElement) return;
  
  // Create the map
  const map = L.map('leaflet-map', {
    center: [shopLocation.lat, shopLocation.lng],
    zoom: 15,
    zoomControl: false,
    attributionControl: false,
    dragging: true,
    scrollWheelZoom: true
  });
  
  // Add zoom control to the bottom right
  L.control.zoom({
    position: 'bottomright'
  }).addTo(map);
  
  // Add the tile layer with custom styling
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors',
    className: 'map-tiles'
  }).addTo(map);
  
  // Custom marker icon
  const goldIcon = L.divIcon({
    html: '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#957B4D"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
    className: 'custom-marker',
    iconSize: [40, 40],
    iconAnchor: [20, 40]
  });
  
  // Add a marker for the shop location
  const marker = L.marker([shopLocation.lat, shopLocation.lng], {
    icon: goldIcon
  }).addTo(map);
  
  // Add popup to the marker
  marker.bindPopup("<b>Victim of Gold</b><br>112 Allée des Tournesols, 06400 Cannes").openPopup();
  
  // Add custom CSS to the map tiles
  const style = document.createElement('style');
  style.textContent = `
    .map-tiles {
      filter: invert(100%) brightness(0.6) contrast(1.1) saturate(0);
    }
    .custom-marker {
      filter: drop-shadow(0 0 3px rgba(0,0,0,0.3));
    }
  `;
  document.head.appendChild(style);
  
  // Force a resize event after a short delay to ensure proper rendering
  setTimeout(function() {
    window.dispatchEvent(new Event('resize'));
  }, 500);
} 