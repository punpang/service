<template>
    <div>
        <v-dialog
            v-model="dialog"
            persistent
            fullscreen>
            <template v-slot:activator="{ on }">
                <v-btn block color="primary" v-on="on" class="mb-2">รายการสินค้า</v-btn>
            </template>
            <v-card>
                <v-card-title>
                    รายการสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    {{ order }}
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props:[
        'order'
    ],
    data() {
        return {
            dialog:false
        }
    },
};
</script>

<style></style>
