<template>
    <div>
        <v-dialog
            persistent
            width="800"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <div v-on="on" style="cursor: pointer">
                    <v-icon color="cyan accent-4">attach_file</v-icon>
                    ต้นแบบสินค้า
                </div></template
            >
            <v-card>
                <v-card-title class="text-h6">
                    ต้นแบบสินค้า
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col
                            cols="12"
                            md="12"
                            v-for="(
                                { google_image }, index
                            ) in propProductPrototypes"
                            :key="index"
                        >
                            <v-card
                                ><imageThumbnailPathSize800
                                    :path="google_image.src_name"
                                ></imageThumbnailPathSize800>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
export default {
    props: ["propProductPrototypes"],
    components: { imageThumbnailPathSize800 },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
