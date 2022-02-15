<template>
    <div>
        <v-simple-table>
            <tbody>
                <tr v-for="(addon, index) in propAddOns" :key="index">
                    <td>
                        <v-icon color="error" v-if="addon.am4_id != propAm4"
                            >priority_high</v-icon
                        >
                        + {{ addon.price }} {{ addon.goods_add_on.name }}
                    </td>
                    <td class="text-right">
                        <v-icon color="error" @click="clickRemove(index)"
                            >delete</v-icon
                        >
                    </td>
                </tr>
            </tbody>
        </v-simple-table>
    </div>
</template>

<script>
export default {
    props: ["propAddOns", "propAm4"],
    methods: {
        clickRemove(index) {
            this.$emit("emitRemoveAddOn", index);
        },
    },
};
</script>
