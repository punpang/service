<template>
    <v-overlay :value="overlay">
        <v-progress-circular
            indeterminate
            :size="this.$store.getters['main/sizeOverlay']"
        ></v-progress-circular>
    </v-overlay>
</template>

<script>
export default {
    props:[
        'overlay'
    ]
};
</script>

<style></style>
