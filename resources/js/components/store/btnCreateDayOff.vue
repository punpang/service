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
                    <v-row class="mt-2">
                        <v-col cols="12" md="6">
                            <v-menu
                                ref="menu"
                                v-model="start_time"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="start_time"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        class="mt-2"
                                        v-model="times.start"
                                        label="เวลาสิ้นสุด"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hide-details
                                        outlined
                                    ></v-text-field>
                                </template>
                                <v-time-picker
                                    v-if="start_time"
                                    v-model="times.start"
                                    :allowed-minutes="allowedMinutes"
                                    full-width
                                    @click:minute="$refs.menu.save(times.start)"
                                    scrollable
                                    format="24hr"
                                ></v-time-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-menu
                                ref="menu"
                                v-model="end_time"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="end_time"
                                transition="scale-transition"
                                offset-y
                                max-width="290px"
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        class="mt-2"
                                        v-model="times.end"
                                        label="เวลาสิ้นสุด"
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hide-details
                                        outlined
                                    ></v-text-field>
                                </template>
                                <v-time-picker
                                    v-if="end_time"
                                    v-model="times.end"
                                    :allowed-minutes="allowedMinutes"
                                    full-width
                                    @click:minute="$refs.menu.save(times.end)"
                                    scrollable
                                    format="24hr"
                                ></v-time-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
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
            times: {
                start: "00:00",
                end: "23:30",
            },
            start_time: false,
            end_time: false,
        };
    },
    methods: {
        allowedMinutes: (v) => v % 30 == 0,
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
            await axios
                .post(`/api/admin/v1/StoreDayOff/store`, {
                    dates: this.dates,
                    times: this.times,
                })
                .then((result) => {
                    if (result.data.status == "success") {
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
                        this.exit();
                        this.$emit("emitSuccess");
                    } else if (result.data.status == "error") {
                        this.$toast.error(result.data.message);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

            loader.hide();

            // if (result.status == 200) {

            // }
        },
        exit() {
            this.dates = [];
            this.times = {
                start: "00:00",
                end: "23:59",
            };
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
