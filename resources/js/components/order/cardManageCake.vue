<template>
    <div>
        <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn dark icon v-bind="attrs" v-on="on">
                    <v-icon color="black" >more_vert</v-icon>
                </v-btn>
            </template>

            <v-list class="p-0">
                <productSelectCake></productSelectCake>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
import productSelectCake from "@/js/components/order/product/select/cake";

export default {
    components: {
        productSelectCake,
    },
    data() {
        return {};
    },
};
</script>
