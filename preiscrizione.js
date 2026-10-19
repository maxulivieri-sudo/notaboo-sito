// NoTaboo 2027: conto alla rovescia, copia dati bonifico, chiusura automatica pre-iscrizioni.
(() => {
  const body = document.body;
  const now = new Date();

  // L'apertura deve comparire anche se app.js è in cache in una versione vecchia.
  document.querySelectorAll('.prereg-hero .reveal').forEach((el, index) => {
    setTimeout(() => el.classList.add('is-visible'), 150 + index * 130);
  });

  const festival = new Date(body.dataset.festival);
  const countdown = document.querySelector('[data-countdown]');
  if (countdown && !Number.isNaN(festival.getTime())) {
    const days = Math.max(0, Math.ceil((festival - now) / 86400000));
    countdown.textContent = String(days);
  }

  const deadline = new Date(body.dataset.deadline);
  if (!Number.isNaN(deadline.getTime()) && now > deadline) {
    body.classList.add('is-closed');
    document.querySelector('.prereg-status')?.replaceChildren('Pre-iscrizioni chiuse');
  }

  document.querySelectorAll('.copy-btn').forEach((button) => {
    button.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(button.dataset.copy);
        button.textContent = 'Copiato';
        button.classList.add('is-copied');
        setTimeout(() => {
          button.textContent = 'Copia';
          button.classList.remove('is-copied');
        }, 1800);
      } catch {
        button.textContent = 'Seleziona e copia';
      }
    });
  });
})();
