<template>
    <div>
        {{ testest }}
        <v-file-input
            accept="image/*"
            label="File input"
            @decode="onDecode"
            v-model="testest"
            @change="asdhasno"
        ></v-file-input>
        <QrcodeCapture @decode="onDecode()" ></QrcodeCapture>
    </div>
</template>

<script>
import { QrcodeCapture } from "vue-qrcode-reader";

export default {
    components: {
        QrcodeCapture,
    },
    data() {
        return {
            testest: {},
            dshgfui:{}
        };
    },
    methods: {
        asdhasno() {
            console.log(event);
            console.log(event.target.files[0]);
            this.onDecode(event)
        },
        onDecode(decodedString) {
            console.log(
                "🚀 ~ file: qr-code-reader.vue:18 ~ onDecode ~ decodedString",
                decodedString
            );
            // ...
        },
    },
};
</script>

<style></style>
