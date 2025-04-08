<script>
export default {
    data(){
        return {
            lang:'አማርኛ',
        };
    },
    methods: {
        changelanguage() {
            this.$i18n.locale = this.$i18n.locale === 'en' ? 'am' : 'en';
            this.lang = this.$i18n.locale === 'en' ? 'አማርኛ' : 'English';
        }    
    }
}
</script>

<template>
    <div>
        <button class="text-white bg-orange-400 rounded-md p-1 text-md font-normal" @click="changelanguage">{{ lang }}</button>
    </div>
</template>
