import { createI18n } from "vue-i18n";
import { langs } from ".";

const i18n = createI18n({
    locale: "en",
    fallbackLocale: "en",
    messages: langs,
});

export default i18n;
