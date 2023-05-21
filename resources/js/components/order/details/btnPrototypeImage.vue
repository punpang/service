<template>
    <div>
        <v-dialog v-model="dialog" scrollable width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="info" x-small rounded>
                    ต้นแบบสินค้า ({{ propPaths.length }} รูป)
                </v-btn>
            </template>

            <v-card>
                <!-- <imageThumbnailPathSizeFree
                    :path="propPath"
                    :size="400"
                ></imageThumbnailPathSizeFree> -->

                <imageThumbnailPathSizeFree
                    v-for="image in propPaths"
                    :key="image.id"
                    :path="image.google_image.src_name"
                    :size="600"
                ></imageThumbnailPathSizeFree>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import imageThumbnailPathSizeFree from "@/js/components/google/drive/imageThumbnailPathSizeFree";
export default {
    props: ["propPath", "propPaths"],
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
