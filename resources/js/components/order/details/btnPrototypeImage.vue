<template>
    <div>
        <v-dialog v-model="dialog" scrollable width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="info" x-small rounded>
                    ต้นแบบสินค้า
                </v-btn>
            </template>

            <v-card>
                <imageThumbnailPathSizeFree
                    :path="propPath"
                    :size="400"
                ></imageThumbnailPathSizeFree>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import imageThumbnailPathSizeFree from "@/js/components/google/drive/imageThumbnailPathSizeFree";
export default {
    props: ["propPath"],
    components: {
        imageThumbnailPathSizeFree,
    },
    data() {
        return {
            dialog: false,
        };
    },
};
</script>
