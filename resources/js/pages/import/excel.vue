<template>
    <div>
        <v-file-input
            accept=".csv"
            label="File input"
            @change="changeFile"
        ></v-file-input>
        {{ file }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            file: {},
        };
    },
    methods: {
        async changeFile() {
            const file = event.target.files[0];

            const formData = new FormData();
            formData.append("file", file);
            //console.log(formData);
            await axios.post(`/api/admin/v1/import/excel`, formData);

        },
    },
};
</script>

<style></style>
