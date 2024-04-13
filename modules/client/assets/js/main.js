const searchIcon = document.querySelector('.search__icon');

searchIcon.addEventListener('click', () => {
  const searchInput = document.querySelector('.input__search');
  searchInput.classList.toggle('input__search--active');
});