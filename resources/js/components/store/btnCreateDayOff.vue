<template>
    <div>
        <v-dialog v-model="dialog" persistent scrollable width="500">
            <template v-slot:activator="{ on }">
                <v-btn x-large class="info" v-on="on">
                    <v-icon left>today</v-icon>
                    เพิ่มวันหยุด
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    <v-icon left color="white">today</v-icon>เพิ่มวันหยุด
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-date-picker
                        class="mt-4"
                        v-model="dates"
                        range
                        :allowed-dates="allowedDates"
                        color="warning"
                        full-width
                        locale="th-TH"
                        elevation="1"
                    ></v-date-picker>
                </v-card-text>
                <v-card-actions>
                    <v-btn large class="error" @click="exit()">
                        <v-icon left> exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn large class="success" @click="save()">
                        <v-icon left> save</v-icon>
                        บันทึกข้อมูล
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            dates: [],
        };
    },
    methods: {
        async save() {
            if (this.dates.length < 2) {

                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    title: "โปรดเลือกวันที่",
                    icon: "warning",
                    timer: 5000,
                    timerProgressBar: true,
                    position: "bottom",
                });
                return;
            }
            let loader = this.$loading.show();
            const result = await axios.post(`/api/admin/v1/StoreDayOff/store`, {
                dates: this.dates,
            });

            this.exit();
            loader.hide();

            if (result.status == 200) {
                this.$swal({
                    toast: true,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    title: "สำเร็จ",
                    icon: "success",
                    timer: 5000,
                    timerProgressBar: true,
                    position: "bottom",
                });
            }

            this.$emit("emitSuccess");
        },
        exit() {
            this.dates = [];
            this.dialog = false;
        },
        allowedDates(val) {
            const subDate = new Date();
            subDate.setDate(subDate.getDate() - 1);
            const date = subDate.toISOString().substr(0, 10);
            return val > date;
        },
    },
};
</script>

<style></style>
