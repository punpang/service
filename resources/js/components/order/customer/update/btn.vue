<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small dark v-on="on" >
                    <v-icon>edit</v-icon>
                </v-btn></template
            >
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    แก้ไขข้อมูลลูกค้า
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small dark @click="clickExit()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text class="pt-8">
                    <v-text-field
                        label="ชื่อลูกค้า"
                        outlined
                        hide-details
                        v-model="propCustomer.name"
                        class="mb-3"
                    ></v-text-field>
                    <v-text-field
                        label="เบอร์โทรศัพท์"
                        outlined
                        hide-details
                        v-model="propCustomer.tel"
                        class="mb-3"
                    ></v-text-field>
                    <v-text-field
                        label="ช่องทางอื่น ๆ"
                        outlined
                        hide-details
                        v-model="propCustomer.social_is"
                        class="mb-3"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn class="error" @click="clickExit()">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="success" @click="clickSave()">
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propCustomer"],
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        async fetch_order() {
            let loader = this.$loading.show();
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            loader.hide();
        },
        clickExit() {
            this.dialog = false;
        },
        async clickSave() {
            let loader = this.$loading.show();
            const payload = this.propCustomer;
            await this.$store
                .dispatch("orderCustomer/update", payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        title: response.title,
                        icon: response.icon,
                        position: "bottom",
                        timerProgressBar: true,
                        timer: 3000,
                    });
                    this.fetch_order();
                    this.dialog = false;
                })
                .catch((err) => {
                    this.$swal({
                        toast: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        title: "เกิดข้อผิดพลาดบางอย่าง",
                        icon: "error",
                        position: "bottom",
                        timerProgressBar: true,
                        timer: 3000,
                    });
                });
            loader.hide();
        },
    },
};
</script>

<style></style>
