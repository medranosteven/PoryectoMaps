const menuContainer = document.querySelector('.menu-container');
let isDragging = false;
let startX;
let scrollLeft;
let velocity = 0;
let friction = 0.95; // Ajustar fricción para suavizar el final del arrastre

// Evento al presionar el mouse o toque
const startDragging = (e) => {
  isDragging = true;
  startX = (e.pageX || e.touches[0].pageX) - menuContainer.offsetLeft;
  scrollLeft = menuContainer.scrollLeft;
  menuContainer.style.cursor = 'grabbing'; // Cambia el cursor al arrastrar
};

// Evento cuando el mouse o el toque se mueve
const dragging = (e) => {
  if (!isDragging) return;
  e.preventDefault();
  const x = (e.pageX || e.touches[0].pageX) - menuContainer.offsetLeft;
  const walk = (x - startX) * 6; // Ajustar la velocidad del desplazamiento
  menuContainer.scrollLeft = scrollLeft - walk;
  velocity = walk; // Registrar velocidad del desplazamiento
};

// Evento al soltar el mouse o el toque
const stopDragging = () => {
  isDragging = false;
  menuContainer.style.cursor = 'grab'; // Restablecer el cursor
  // Aplicar fricción para suavizar el final del arrastre
  requestAnimationFrame(applyFriction);
};

// Aplicar fricción cuando se suelta el arrastre
const applyFriction = () => {
  if (Math.abs(velocity) > 0.1) {
    menuContainer.scrollLeft -= velocity;
    velocity *= friction; // Aplicar fricción
    requestAnimationFrame(applyFriction);
  }
};

// Eventos del mouse
menuContainer.addEventListener('mousedown', startDragging);
menuContainer.addEventListener('mousemove', dragging);
menuContainer.addEventListener('mouseup', stopDragging);
menuContainer.addEventListener('mouseleave', stopDragging);

// Eventos de toque (pantallas táctiles)
menuContainer.addEventListener('touchstart', startDragging);
menuContainer.addEventListener('touchmove', dragging);
menuContainer.addEventListener('touchend', stopDragging);

// Función para mostrar más tarjetas (sin cambios)
function showMoreCards(sectionId) {
  const hiddenCards = document.getElementById(sectionId);
  if (hiddenCards.style.display === "none") {
    hiddenCards.style.display = "grid";
  } else {
    hiddenCards.style.display = "none";
  }
}

// Funcionalidad para buscar por nombre o departamento (sin cambios)
const searchInput = document.querySelector('.boton__texto');
searchInput.addEventListener('input', function () {
  const searchTerm = this.value.toLowerCase();
  const sections = document.querySelectorAll('.section-container');
  
  sections.forEach(section => {
    const departmentTitle = section.querySelector('.section-title').textContent.toLowerCase();
    const cards = section.querySelectorAll('.card');
    let hasVisibleCard = false;
    
    cards.forEach(card => {
      const cardTitle = card.querySelector('h3').textContent.toLowerCase();
      if (cardTitle.includes(searchTerm) || departmentTitle.includes(searchTerm)) {
        card.style.display = "block";
        hasVisibleCard = true;
      } else {
        card.style.display = "none";
      }
    });
    
    // Mostrar u ocultar secciones basadas en si hay tarjetas visibles
    if (hasVisibleCard || departmentTitle.includes(searchTerm)) {
      section.style.display = "block";
    } else {
      section.style.display = "none";
    }
  });
});
