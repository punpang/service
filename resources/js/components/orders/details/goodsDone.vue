<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-list-item class="light-green darken-2" v-on="on">
                    <v-list-item-icon>
                        <v-icon>local_mall</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="py-1"
                            >เตรียมสินค้า</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <v-card>
                <v-card-title
                    >เตรียมสินค้า
                    <v-spacer></v-spacer>
                    <v-icon color="error">close</v-icon>
                </v-card-title>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog: false
        };
    }
};
</script>
