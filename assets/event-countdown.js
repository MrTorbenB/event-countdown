(() => {
  const pad = (value) => String(value).padStart(2, '0');
  document.querySelectorAll('[data-event-countdown]').forEach((root) => {
    const target = new Date(root.dataset.target).getTime();
    const timer = root.querySelector('.event-countdown__timer');
    const update = () => {
      const difference = target - Date.now();
      if (difference <= 0) {
        timer.textContent = root.dataset.expired;
        return false;
      }
      root.querySelector('[data-days]').textContent = Math.floor(difference / 86400000);
      root.querySelector('[data-hours]').textContent = pad(Math.floor((difference % 86400000) / 3600000));
      root.querySelector('[data-minutes]').textContent = pad(Math.floor((difference % 3600000) / 60000));
      root.querySelector('[data-seconds]').textContent = pad(Math.floor((difference % 60000) / 1000));
      return true;
    };
    if (update()) window.setInterval(update, 1000);
  });
})();
