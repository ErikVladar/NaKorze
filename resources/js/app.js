import './bootstrap';

import Alpine from 'alpinejs';

import intlTelInput from "intl-tel-input";

const input = document.querySelector("#phone");

const iti = intlTelInput(input, {
    initialCountry: "auto",
    nationalMode: false,
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/utils.js",
});

window.Alpine = Alpine;

Alpine.start();
