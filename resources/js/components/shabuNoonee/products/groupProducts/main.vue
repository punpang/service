<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" color="success">กลุ่มสินค้า</v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <h3>กลุ่มสินค้า</h3>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="dialog = false">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <addGroupProduct></addGroupProduct>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import addGroupProduct from "@/js/components/shabuNoonee/products/groupProducts/add";

export default {
    components :{
        addGroupProduct
    },
    data () {
        return {
            dialog:false
        }
    }

    
}
</script>