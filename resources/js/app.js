import './invoice-form.js';

const menuButton = document.querySelector('[data-menu-toggle]');
const navigation = document.querySelector('#navigation');
function closeMenu() {
    navigation?.classList.remove('is-open');
    menuButton?.setAttribute('aria-expanded', 'false');
    menuButton?.setAttribute('aria-label', 'Buka navigasi');
}
menuButton?.addEventListener('click', () => {
    const open = navigation.classList.toggle('is-open');
    menuButton.setAttribute('aria-expanded', String(open));
    menuButton.setAttribute('aria-label', open ? 'Tutup navigasi' : 'Buka navigasi');
});
document.addEventListener('click', (event) => {
    if (!navigation?.contains(event.target) && !menuButton?.contains(event.target)) closeMenu();
});
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeMenu();
});
document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    });
});
document.querySelector('[data-print]')?.addEventListener('click', () => window.print());
document.querySelector('[data-validation-errors]')?.focus();

// Pesan bawaan browser juga menggunakan bahasa Indonesia.
document.querySelectorAll('input, textarea, select').forEach(localizeValidation);
document.addEventListener('invoice:item-added', (event) => {
    event.detail.querySelectorAll('input').forEach(localizeValidation);
});
function localizeValidation(input) {
    input.addEventListener('invalid', () => {
        input.setCustomValidity('');
        const validity = input.validity;
        if (validity.valueMissing) input.setCustomValidity('Kolom ini wajib diisi.');
        else if (validity.rangeUnderflow) input.setCustomValidity(`Nilai minimal adalah ${input.min}.`);
        else if (validity.rangeOverflow) input.setCustomValidity(`Nilai maksimal adalah ${input.max}.`);
        else if (validity.stepMismatch) input.setCustomValidity(input.step === '1' ? 'Gunakan bilangan bulat.' : 'Gunakan maksimal dua angka desimal.');
        else if (!validity.valid) input.setCustomValidity('Isian belum valid. Periksa kembali nilai yang dimasukkan.');
    });
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
}
