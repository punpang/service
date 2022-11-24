<template>
    <div>
        <v-row class="mt-1">
            <v-col md="4" cols="8">
                <v-text-field
                    dense
                    label="ค้นหาข้อความ"
                    outlined
                    hide-details
                    prepend-inner-icon="search"
                    v-model="search"
                ></v-text-field>
            </v-col>
            <v-col md="8" cols="4">
                <div class="d-flex justify-end">
                    <createSms @emitExit="emitExit"></createSms>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-data-table
            :headers="headers"
            :items="messages"
            :items-per-page="-1"
            mobile-breakpoint="0"
            hide-default-footer
            :search="search"
        >
            <template v-slot:item.manages="{ item }">
                <div class="d-flex flex-row justify-end">
                    <sentMessage
                        @emitExit="emitExit"
                        :propMessage="item"
                        :propSmall="true"
                        class="mr-2"
                    ></sentMessage>
                    <updateSms
                        @emitExit="emitExit"
                        :propMessage="item"
                        :propUpdate="true"
                        :propSmall="true"
                        class
                    ></updateSms>
                </div>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import createSms from "@/js/components/sms/create";
import sentMessage from "@/js/components/sms/sentMessage";
import updateSms from "@/js/components/sms/update";
import { mapGetters } from "vuex";
export default {
    components: { createSms, sentMessage, updateSms },
    data() {
        return {
            search: "",
            headers: [
                { text: "ข้อความ", value: "message" },
                { text: "จำนวนครั้งที่ส่ง", value: "count" , align: "center"},
                { text: "การจัดการ", value: "manages", align: "end" },
            ],
        };
    },
    methods: {
        emitExit() {
            this.fetch();
        },
        async fetch() {
            let loader = this.$loading.show();
            const payload = "sortByCount=DESC";
            await this.$store
                .dispatch("smsMessages/fetch", payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        title: response.title,
                        icon: response.icon,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                })
                .catch((error) => {
                    console.error(error);
                    this.$swal({
                        toast: true,
                        title: "เกิดข้อผิดพลาดบางอย่าง",
                        icon: "error",
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        position: "bottom",
                        showConfirmButton: false,
                    });
                });
            loader.hide();
        },
    },
    async mounted() {
        await this.fetch();
    },
    computed: {
        ...mapGetters({
            messages: "smsMessages/fetch",
        }),
    },
};
</script>

<style></style>
