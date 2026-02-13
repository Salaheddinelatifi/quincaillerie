document.querySelectorAll('.magnifier-container').forEach(container => {
    const img = container.querySelector('.magnifier-image');
    const glass = container.querySelector('.magnifier-glass');

    const zoom = 1.6;

    img.addEventListener('mousemove', moveMagnifier);
    container.addEventListener('mouseleave', () => {
        glass.style.opacity = 0;
    });

    function moveMagnifier(e) {
        const rect = img.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        glass.style.opacity = 1;

        glass.style.left = x + 'px';
        glass.style.top = y + 'px';

        glass.style.backgroundImage = `url('${img.src}')`;
        glass.style.backgroundSize = (img.width * zoom) + 'px ' + (img.height * zoom) + 'px';

        const bgX = -((x * zoom) - glass.offsetWidth / 2);
        const bgY = -((y * zoom) - glass.offsetHeight / 2);

        glass.style.backgroundPosition = `${bgX}px ${bgY}px`;
    }
});
