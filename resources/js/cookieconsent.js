import 'vanilla-cookieconsent/dist/cookieconsent.css';
import * as CookieConsent from 'vanilla-cookieconsent';

// Google Analytics needs no code here: the library itself runs the <script type="text/plain" data-category="analytics">
// tags from partials/google-analytics.blade.php once analytics is accepted.

// Iframes marked with data-consent-src (Google Maps, Instagram) only get a real src after consent
function applyExternalConsent() {
    const accepted = CookieConsent.acceptedCategory('external');

    document.querySelectorAll('iframe[data-consent-src]').forEach((iframe) => {
        if (accepted && !iframe.getAttribute('src')) {
            iframe.src = iframe.dataset.consentSrc;
        } else if (!accepted && iframe.getAttribute('src')) {
            iframe.removeAttribute('src');
        }
    });

    document.querySelectorAll('[data-consent-placeholder]').forEach((placeholder) => {
        // inline style, because the `hidden` attribute loses to the placeholder's `flex` class
        placeholder.style.display = accepted ? 'none' : '';
    });
}

document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-consent-allow-external]')) {
        return;
    }

    const { acceptedCategories } = CookieConsent.getUserPreferences();
    CookieConsent.acceptCategory([...acceptedCategories, 'external']);
});

const cookieTableHeaders = {
    sk: { name: 'Názov', domain: 'Doména', description: 'Popis', expiration: 'Platnosť' },
    en: { name: 'Name', domain: 'Domain', description: 'Description', expiration: 'Expiration' },
    de: { name: 'Name', domain: 'Domain', description: 'Beschreibung', expiration: 'Ablauf' },
};

const necessaryCookies = {
    sk: [
        { name: '*_session', domain: location.hostname, description: 'Relácia používateľa (jazyk, prihlásenie, formuláre).', expiration: '2 hodiny' },
        { name: 'XSRF-TOKEN', domain: location.hostname, description: 'Ochrana formulárov pred útokmi CSRF.', expiration: '2 hodiny' },
        { name: 'cc_cookie', domain: location.hostname, description: 'Uloženie vašich nastavení cookies.', expiration: '6 mesiacov' },
    ],
    en: [
        { name: '*_session', domain: location.hostname, description: 'User session (language, login, forms).', expiration: '2 hours' },
        { name: 'XSRF-TOKEN', domain: location.hostname, description: 'Protects forms against CSRF attacks.', expiration: '2 hours' },
        { name: 'cc_cookie', domain: location.hostname, description: 'Stores your cookie preferences.', expiration: '6 months' },
    ],
    de: [
        { name: '*_session', domain: location.hostname, description: 'Benutzersitzung (Sprache, Anmeldung, Formulare).', expiration: '2 Stunden' },
        { name: 'XSRF-TOKEN', domain: location.hostname, description: 'Schützt Formulare vor CSRF-Angriffen.', expiration: '2 Stunden' },
        { name: 'cc_cookie', domain: location.hostname, description: 'Speichert Ihre Cookie-Einstellungen.', expiration: '6 Monate' },
    ],
};

const analyticsCookies = {
    sk: [
        { name: '_ga', domain: 'Google Analytics', description: 'Rozlišovanie návštevníkov.', expiration: '2 roky' },
        { name: '_ga_*', domain: 'Google Analytics', description: 'Uchovanie stavu relácie.', expiration: '2 roky' },
    ],
    en: [
        { name: '_ga', domain: 'Google Analytics', description: 'Distinguishes visitors.', expiration: '2 years' },
        { name: '_ga_*', domain: 'Google Analytics', description: 'Persists session state.', expiration: '2 years' },
    ],
    de: [
        { name: '_ga', domain: 'Google Analytics', description: 'Unterscheidet Besucher.', expiration: '2 Jahre' },
        { name: '_ga_*', domain: 'Google Analytics', description: 'Speichert den Sitzungsstatus.', expiration: '2 Jahre' },
    ],
};

function table(lang, body) {
    return { headers: cookieTableHeaders[lang], body };
}

CookieConsent.run({
    guiOptions: {
        consentModal: { layout: 'box', position: 'bottom left', equalWeightButtons: true },
        preferencesModal: { layout: 'box', equalWeightButtons: true },
    },

    categories: {
        necessary: { enabled: true, readOnly: true },
        analytics: {
            // the GA script can't be unloaded, so reload the page when consent is withdrawn
            autoClear: { cookies: [{ name: /^_ga/ }], reloadPage: true },
        },
        external: {},
    },

    onConsent: applyExternalConsent,
    onChange: applyExternalConsent,

    language: {
        default: 'sk',
        autoDetect: 'document',
        translations: {
            sk: {
                consentModal: {
                    title: 'Používame cookies 🍪',
                    description: 'Nevyhnutné cookies potrebujeme na fungovanie stránky. S vaším súhlasom použijeme aj analytické cookies (Google Analytics) a zobrazíme obsah tretích strán (Mapy Google, Instagram), ktorý ukladá vlastné cookies.',
                    acceptAllBtn: 'Prijať všetky',
                    acceptNecessaryBtn: 'Len nevyhnutné',
                    showPreferencesBtn: 'Nastavenia',
                },
                preferencesModal: {
                    title: 'Nastavenia cookies',
                    acceptAllBtn: 'Prijať všetky',
                    acceptNecessaryBtn: 'Len nevyhnutné',
                    savePreferencesBtn: 'Uložiť nastavenia',
                    closeIconLabel: 'Zavrieť',
                    sections: [
                        { description: 'Svoj súhlas môžete kedykoľvek zmeniť cez odkaz „Nastavenia cookies“ v pätičke stránky.' },
                        { title: 'Nevyhnutné cookies', description: 'Potrebné na základné fungovanie stránky. Nedajú sa vypnúť.', linkedCategory: 'necessary', cookieTable: table('sk', necessaryCookies.sk) },
                        { title: 'Analytické cookies', description: 'Pomáhajú nám pochopiť, ako návštevníci stránku používajú (Google Analytics).', linkedCategory: 'analytics', cookieTable: table('sk', analyticsCookies.sk) },
                        { title: 'Externý obsah', description: 'Mapa Google a príspevky z Instagramu. Ich poskytovatelia (Google, Meta) pri zobrazení ukladajú vlastné cookies.', linkedCategory: 'external' },
                    ],
                },
            },
            en: {
                consentModal: {
                    title: 'We use cookies 🍪',
                    description: 'Essential cookies keep the site working. With your consent we also use analytics cookies (Google Analytics) and show third-party content (Google Maps, Instagram) that sets its own cookies.',
                    acceptAllBtn: 'Accept all',
                    acceptNecessaryBtn: 'Essential only',
                    showPreferencesBtn: 'Settings',
                },
                preferencesModal: {
                    title: 'Cookie settings',
                    acceptAllBtn: 'Accept all',
                    acceptNecessaryBtn: 'Essential only',
                    savePreferencesBtn: 'Save settings',
                    closeIconLabel: 'Close',
                    sections: [
                        { description: 'You can change your consent at any time via the “Cookie settings” link in the footer.' },
                        { title: 'Essential cookies', description: 'Required for the site to work. They cannot be turned off.', linkedCategory: 'necessary', cookieTable: table('en', necessaryCookies.en) },
                        { title: 'Analytics cookies', description: 'Help us understand how visitors use the site (Google Analytics).', linkedCategory: 'analytics', cookieTable: table('en', analyticsCookies.en) },
                        { title: 'External content', description: 'Google Maps and Instagram posts. Their providers (Google, Meta) set their own cookies when shown.', linkedCategory: 'external' },
                    ],
                },
            },
            de: {
                consentModal: {
                    title: 'Wir verwenden Cookies 🍪',
                    description: 'Notwendige Cookies halten die Website funktionsfähig. Mit Ihrer Zustimmung verwenden wir außerdem Analyse-Cookies (Google Analytics) und zeigen Inhalte Dritter (Google Maps, Instagram) an, die eigene Cookies setzen.',
                    acceptAllBtn: 'Alle akzeptieren',
                    acceptNecessaryBtn: 'Nur notwendige',
                    showPreferencesBtn: 'Einstellungen',
                },
                preferencesModal: {
                    title: 'Cookie-Einstellungen',
                    acceptAllBtn: 'Alle akzeptieren',
                    acceptNecessaryBtn: 'Nur notwendige',
                    savePreferencesBtn: 'Einstellungen speichern',
                    closeIconLabel: 'Schließen',
                    sections: [
                        { description: 'Sie können Ihre Zustimmung jederzeit über den Link „Cookie-Einstellungen“ in der Fußzeile ändern.' },
                        { title: 'Notwendige Cookies', description: 'Für den Betrieb der Website erforderlich. Sie können nicht deaktiviert werden.', linkedCategory: 'necessary', cookieTable: table('de', necessaryCookies.de) },
                        { title: 'Analyse-Cookies', description: 'Helfen uns zu verstehen, wie Besucher die Website nutzen (Google Analytics).', linkedCategory: 'analytics', cookieTable: table('de', analyticsCookies.de) },
                        { title: 'Externe Inhalte', description: 'Google Maps und Instagram-Beiträge. Deren Anbieter (Google, Meta) setzen beim Anzeigen eigene Cookies.', linkedCategory: 'external' },
                    ],
                },
            },
        },
    },
});
