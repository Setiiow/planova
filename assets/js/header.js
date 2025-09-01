document.addEventListener('DOMContentLoaded', function () { 
  const tabs = document.querySelectorAll('.header-tabs .tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('pill'));
      tab.classList.add('pill');
    });
  });
});

