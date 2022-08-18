<template>
    <div>
        <v-card>
            <v-card-title class="text-h6">
                <v-icon left>settings</v-icon>
                ตั้งค่า
            </v-card-title>
            <v-card-text>
                <strong class="text-h6">เวลาเปิด-ปิด</strong>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-menu
                            ref="menu"
                            v-model="open_store"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="open_store"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    class="mt-2"
                                    v-model="setting.open_store"
                                    label="open_store"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    hide-details
                                    outlined
                                ></v-text-field>
                            </template>
                            <v-time-picker
                                v-if="open_store"
                                v-model="setting.open_store"
                                full-width
                                @click:minute="
                                    $refs.menu.save(setting.open_store)
                                "
                                scrollable
                                format="24hr"
                            ></v-time-picker>
                        </v-menu>
                    </v-col>

                    <v-col cols="12" md="6">
                        <v-menu
                            ref="menu"
                            v-model="close_store"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="close_store"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    class="mt-2"
                                    v-model="setting.close_store"
                                    label="close_store"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    hide-details
                                    outlined
                                ></v-text-field>
                            </template>
                            <v-time-picker
                                v-if="close_store"
                                v-model="setting.close_store"
                                full-width
                                @click:minute="
                                    $refs.menu.save(setting.close_store)
                                "
                                scrollable
                                format="24hr"
                            ></v-time-picker>
                        </v-menu>
                    </v-col>
                </v-row>

                <v-divider></v-divider>

                <strong class="text-h6">LINE</strong>

                <v-switch
                    color="success"
                    class="mb-4 mt-2"
                    inset
                    label="line_status_bot"
                    v-model="setting.line_status_bot"
                    hide-details
                >
                </v-switch>

                <v-text-field
                    class="mb-4"
                    hide-details
                    outlined
                    x-large
                    label="line_client_id"
                    v-model="setting.line_client_id"
                    :append-icon="
                        hide_key.line_client_id
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.line_client_id = !hide_key.line_client_id)
                    "
                    :type="hide_key.line_client_id ? 'password' : 'text'"
                    :readonly="hide_key.line_client_id ? true : false"
                ></v-text-field>

                <v-text-field
                    class="mb-4"
                    hide-details
                    outlined
                    x-large
                    label="line_client_secret"
                    v-model="setting.line_client_secret"
                    :append-icon="
                        hide_key.line_client_secret
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.line_client_secret =
                                !hide_key.line_client_secret)
                    "
                    :type="hide_key.line_client_secret ? 'password' : 'text'"
                    :readonly="hide_key.line_client_secret ? true : false"
                ></v-text-field>

                <v-text-field
                    class="mb-4"
                    hide-details
                    outlined
                    x-large
                    label="line_access_token"
                    v-model="setting.line_access_token"
                    :append-icon="
                        hide_key.line_access_token
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.line_access_token =
                                !hide_key.line_access_token)
                    "
                    :type="hide_key.line_access_token ? 'password' : 'text'"
                    :readonly="hide_key.line_access_token ? true : false"
                ></v-text-field>

                <v-text-field
                    class="mb-4"
                    hide-details
                    outlined
                    x-large
                    label="line_key_notify"
                    v-model="setting.line_key_notify"
                    :append-icon="
                        hide_key.line_key_notify
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.line_key_notify =
                                !hide_key.line_key_notify)
                    "
                    :type="hide_key.line_key_notify ? 'password' : 'text'"
                    :readonly="hide_key.line_key_notify ? true : false"
                ></v-text-field>

                <v-divider></v-divider>

                <strong class="text-h6">FACEBOOK</strong>
                <v-switch
                    color="success"
                    class="mb-4 mt-2"
                    inset
                    label="facebook_status_bot"
                    v-model="setting.facebook_status_bot"
                    hide-details
                >
                </v-switch>
                <v-text-field
                    class="mb-4"
                    hide-details
                    outlined
                    x-large
                    label="facebook_access_token"
                    v-model="setting.facebook_access_token"
                    :append-icon="
                        hide_key.facebook_access_token
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.facebook_access_token =
                                !hide_key.facebook_access_token)
                    "
                    :type="hide_key.facebook_access_token ? 'password' : 'text'"
                    :readonly="hide_key.facebook_access_token ? true : false"
                ></v-text-field>

                <v-divider></v-divider>
                <strong class="text-h6">KSHER PAYMENT GATEWAY</strong>
                <!-- <v-switch
                    color="success"
                    class="mb-4 mt-2"
                    inset
                    label="ksher_is_use"
                    v-model="setting.ksher_is_use"
                    hide-details
                >
                </v-switch> -->
                <v-text-field
                    class="mb-4 mt-2"
                    hide-details
                    outlined
                    x-large
                    label="ksher_access_token"
                    v-model="setting.ksher_access_token"
                    :append-icon="
                        hide_key.ksher_access_token
                            ? 'visibility'
                            : 'visibility_off'
                    "
                    @click:append="
                        () =>
                            (hide_key.ksher_access_token =
                                !hide_key.ksher_access_token)
                    "
                    :type="hide_key.ksher_access_token ? 'password' : 'text'"
                    :readonly="hide_key.ksher_access_token ? true : false"
                ></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-btn x-large class="warning" @click="fecth()">
                    <v-icon left>refresh</v-icon>
                    โหลดข้อมูลใหม่
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn x-large class="success" @click="save()">
                    <v-icon left>save</v-icon>
                    บันทึกข้อมูล
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            setting: {},
            open_store: false,
            close_store: false,
            hide_key: {
                line_access_token: true,
                line_client_id: true,
                line_client_secret: true,
                line_key_notify: true,
                facebook_access_token: true,
                ksher_access_token: true,
            },
        };
    },
    methods: {
        async fecth() {
            let loader = this.$loading.show();
            const result = await axios.get(`/api/admin/v1/setting/fetch`);
            this.setting = result.data;
            loader.hide();
        },
        async save() {
            let loader = this.$loading.show();
            const result = await axios.post(`/api/admin/v1/setting/update`, {
                setting: this.setting,
            });
            this.$swal({
                toast: true,
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
                icon: result.status == 200 ? "success" : "error",
                title: result.status == 200 ? "สำเร็จ" : "ล้มเหลว",
                position: "bottom",
            });
            loader.hide();
        },
    },
    async mounted() {
        await this.fecth();
    },
};
</script>

<style></style>
