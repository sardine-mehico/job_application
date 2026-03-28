import './bootstrap';
import posthog from 'posthog-js';

const posthogConfig = window.posthogConfig ?? {};
const posthogKey = posthogConfig.key;
const posthogHost = posthogConfig.host || 'https://us.i.posthog.com';

if (posthogKey) {
    posthog.init(posthogKey, {
        api_host: posthogHost,
        capture_pageview: true,
        capture_pageleave: true,
        person_profiles: 'identified_only',
        loaded: (client) => {
            if (import.meta.env.DEV) {
                client.debug();
            }
        },
    });

    window.posthog = posthog;

    window.addEventListener('application-submitted', (event) => {
        const detail = Array.isArray(event.detail) ? event.detail[0] ?? {} : event.detail ?? {};

        posthog.capture('job_application_submitted', detail);
    });
}
