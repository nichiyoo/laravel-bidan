import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'
import humanize from 'humanize-duration';

/**
 * Function to format the time in human readable format
 * @param {*} seconds
 * @returns {string} formatted time
 */
window.humanizeTime = (seconds) => {
    return humanize(seconds * 1000, {
        largest: 3,
        round: true,
        language: 'id',
        units: ['h', 'm', 's'],
    });
};

window.Alpine = Alpine;
Alpine.plugin(persist);
Alpine.start();

