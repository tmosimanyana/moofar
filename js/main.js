document.querySelectorAll('[data-before-after]').forEach(slider => {
    const beforeImageUrl = slider.getAttribute('data-before-image');
    const afterImageUrl = slider.getAttribute('data-after-image');
    const beforeLabel = slider.getAttribute('data-before-label') || 'Before';
    const afterLabel = slider.getAttribute('data-after-label') || 'After';

    // Create before and after divs
    const afterDiv = document.createElement('div');
    afterDiv.classList.add('after-image');
    afterDiv.style.backgroundImage = `url(${afterImageUrl})`;

    const beforeDiv = document.createElement('div');
    beforeDiv.classList.add('before-image');
    beforeDiv.style.backgroundImage = `url(${beforeImageUrl})`;

    // Create labels
    const beforeText = document.createElement('span');
    beforeText.textContent = beforeLabel;
    beforeText.style.left = '10px';

    const afterText = document.createElement('span');
    afterText.textContent = afterLabel;
    afterText.style.right = '10px';

    // Handle
    const handle = document.createElement('div');
    handle.classList.add('handle');

    // Append elements
    slider.appendChild(afterDiv);
    slider.appendChild(beforeDiv);
    slider.appendChild(beforeText);
    slider.appendChild(afterText);
    slider.appendChild(handle);

    // Drag functionality
    let isDragging = false;

    const updateSlider = (x) => {
        const rect = slider.getBoundingClientRect();
        let offsetX = x - rect.left;
        if (offsetX < 0) offsetX = 0;
        if (offsetX > rect.width) offsetX = rect.width;
        beforeDiv.style.width = offsetX + 'px';
        handle.style.left = offsetX + 'px';
    };

    handle.addEventListener('mousedown', () => isDragging = true);
    window.addEventListener('mouseup', () => isDragging = false);
    window.addEventListener('mousemove', e => {
        if (isDragging) updateSlider(e.clientX);
    });

    // Optional: Move with mouse over the slider
    slider.addEventListener('mousemove', e => {
        if (!isDragging) updateSlider(e.clientX);
    });

    // Reset on mouse leave
    slider.addEventListener('mouseleave', () => {
        beforeDiv.style.width = '50%';
        handle.style.left = '50%';
    });
});

