<template>
    <div>
        <v-btn @click="newOrder()">
            <!-- @click="save()" :disabled="!self.id" -->
            <span class="white--text"> สร้างออร์เดอร์ใหม่ </span>
            <v-icon class="white--text">add_circle</v-icon>
        </v-btn>
        <v-btn> </v-btn>
    </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
    methods: {
        async newOrder() {
            let loader = this.$loading.show();
            const payload = {
                temp: this.temp,
            };
            const result = await this.$store
                .dispatch(`orderIndex/newOrder`, payload)
                .then((result) => {
                    loader.hide();
                    this.$swal({
                        title: result.data.message,
                        icon: result.data.status,
                        allowOutsideClick: false,
                        confirmButtonText: "ไปยังรายการใหม่",
                        // denyButtonText: "รับรายการใหม่",
                        showDenyButton: true,
                        confirmButtonColor:"#2E7D32",
                        // denyButtonColor: "#3F51B5"
                    }).then((resultSwal) => {
                        if (resultSwal.isConfirmed) {
                            window.location.href = `/manages/order/${result.data.order_id}/showOrderByID`;
                        } else {
                            location.reload();
                        }
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    computed: {
        ...mapGetters({
            temp: "orderTemp/temp",
        }),
    },
};
</script>
