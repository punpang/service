<template>
    <div>
        <v-card-actions>
            <v-btn class="error" @click="exit()">
                <v-icon left>exit_to_app</v-icon>
                ออก
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
                class="success"
                @click="clickSave()"
                :disabled="cashSum <= 0 || thbSum <= 0 || cash.max < cashSum"
            >
                <v-icon left>save</v-icon>
                บันทึก
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
export default {
    methods: {
        async clickSave() {
            if (this.cashSum <= 0 || this.thbSum <= 0) {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    title: "โปรดกรอกข้อมูลให้ครบถ้วน",
                    position: "bottom",
                });
                return;
            }
        },
    },
};
</script>

<style></style>
