<template>
    <div>
        <v-item-group>
            <v-container>
                <v-row>
                    <v-col
                        v-for="option in options"
                        :key="option.id"
                        cols="12"
                        md="6"
                        @click="clickSelected(option)"
                    >
                        <v-item v-slot="{ active, toggle }">
                            <v-card
                                :color="active ? 'warning' : 'white'"
                                class="d-flex align-center"
                                height="100"
                                @click="toggle"
                            >
                                <v-scroll-y-transition>
                                    <div
                                        v-if="active"
                                        class="text-h6 flex-grow-1 text-center white--text"
                                    >
                                        {{ option.title }}
                                    </div>
                                    <div
                                        v-else
                                        class="text-h6 flex-grow-1 text-center"
                                    >
                                        {{ option.title }}
                                    </div>
                                </v-scroll-y-transition>
                            </v-card>
                        </v-item>
                    </v-col>
                    <v-col>
                        <v-select
                            :items="waiting_periods"
                            item-text="waiting_periods"
                            outlined
                            label="ระยะรอคอย"
                            menu-props="auto"
                            v-model="propOption.waiting_period"
                            hide-details
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </v-item-group>
    </div>
</template>

<script>
export default {
    props: ["propOption"],
    data() {
        return {
            options: [
                {
                    id: 1,
                    title: "เตรียมสินค้า",
                    keyword: "payment",
                    status_id: 3,
                },
                {
                    id: 2,
                    title: "รอเตรียมสินค้า",
                    keyword: "no_payment",
                    status_id: 4,
                },
            ],
            waiting_periods: [
                "10-30 นาที",
                "20-40 นาที",
                "30-50 นาที",
                "40-60 นาที",
            ],
            waiting_period: "10-30 นาที",
            selected: "",
        };
    },
    methods: {
        clickSelected(item) {
            this.propOption.status_id = item.status_id;
        },
    },
};
</script>
