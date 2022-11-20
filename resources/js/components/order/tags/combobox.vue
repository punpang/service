<template>
    <div>
        <v-combobox
            v-model="model"
            :filter="filter"
            :hide-no-data="!search"
            :items="items"
            :search-input.sync="search"
            hide-selected
            label="เลือกแท็ก"
            multiple
            small-chips
            solo
            hide-details
        >
            <template v-slot:no-data>
                <v-list-item>
                    <span class="subheading mr-2">สร้างใหม่</span>
                    <v-chip
                        :color="`${colors[nonce - 1]} lighten-3`"
                        label
                        small
                    >
                        {{ search }}
                    </v-chip>
                </v-list-item>
            </template>
            <template v-slot:selection="{ attrs, item, parent, selected }">
                <v-chip
                    v-if="item === Object(item)"
                    v-bind="attrs"
                    :color="`${item.color} lighten-3`"
                    :input-value="selected"
                    label
                    small
                >
                    <span class="pr-2">
                        {{ item.text }}
                    </span>
                    <v-icon small @click="parent.selectItem(item)">
                        $delete
                    </v-icon>
                </v-chip>
            </template>
            <template v-slot:item="{ index, item }">
                <v-text-field
                    v-if="editing === item"
                    v-model="editing.text"
                    autofocus
                    flat
                    background-color="transparent"
                    hide-details
                    solo
                    @keyup.enter="edit(index, item)"
                ></v-text-field>
                <v-chip
                    v-else
                    :color="`${item.color} lighten-3`"
                    dark
                    label
                    small
                >
                    {{ item.text }}
                </v-chip>
                <v-spacer></v-spacer>
                <v-list-item-action @click.stop>
                    <v-btn icon @click.stop.prevent="edit(index, item)">
                        <v-icon>{{
                            editing !== item ? "edit" : "check"
                        }}</v-icon>
                    </v-btn>
                </v-list-item-action>
            </template>
        </v-combobox>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propOrderDetail", "propOrderTags"],
    data() {
        return {
            activator: null,
            attach: null,
            colors: ["green", "purple", "indigo", "cyan", "teal", "orange"],
            editing: null,
            editingIndex: -1,
            // items: [
            //     // { header: "เลือกแท็กหรือเพิ่มแท็ก" },
            //     // {
            //     //     id: 1,
            //     //     text: "Foo",
            //     //     color: "blue",
            //     // },
            //     // {
            //     //     id: 2,
            //     //     text: "Bar",
            //     //     color: "red",
            //     // },
            //     // {
            //     //     id: 3,
            //     //     text: "เด็ก",
            //     //     color: "blue",
            //     // },
            //     // {
            //     //     id: 4,
            //     //     text: "ผู้ชาย",
            //     //     color: "blue",
            //     // },
            // ],
            nonce: 1,
            menu: false,
            model: [],
            x: 0,
            search: null,
            y: 0,
        };
    },
    watch: {
        async model(val, prev) {
            if (val.length === prev.length) return;
            this.model = await val.map((v) => {
                if (typeof v === "string") {
                    v = {
                        text: v,
                        color: this.colors[this.nonce - 1],
                    };
                    this.createNewTag(v);
                    this.nonce++;
                }
                return v;
            });
            await this.createOrderTags();
        },
    },
    async mounted() {
        for (let i = 0; i < this.propOrderTags.length; i++) {
            this.model.push(this.propOrderTags[i].tag);
        }
        this.nonce =
            this.propOrderTags.length > 0 ? this.propOrderTags.length + 1 : 1;
    },
    methods: {
        async createOrderTags() {
            const payload = {
                tags: this.model,
                order_detail_id: this.propOrderDetail.id,
            };
            let loader = this.$loading.show();
            await this.$store
                .dispatch("orderTags/tags_store", payload)
                .then((response) => {
                    // this.$swal({
                    //     toast: true,
                    //     title: response.title,
                    //     icon: response.icon,
                    //     allowOutsideClick: false,
                    //     timer: 3000,
                    //     timerProgressBar: true,
                    //     position: "top-right",
                    //     showConfirmButton: false,
                    // });
                })
                .catch((error) => {
                    console.log(error);
                });
            loader.hide();
        },
        async createNewTag(item) {
            let loader = this.$loading.show();
            const newTag = await this.$store
                .dispatch("orderTags/store", item)
                .then((result) => {
                    return result.tag;
                });
            this.items.push(newTag);
            loader.hide();
            // return newTag;
        },
        async edit(index, item) {
            if (!this.editing) {
                this.editing = item;
                this.editingIndex = index;
            } else {
                this.editing = null;
                this.editingIndex = -1;
                let loader = this.$loading.show();
                await this.$store
                    .dispatch("orderTags/edit_tag", item)
                    .then(() => {});
                loader.hide();
            }
        },
        filter(item, queryText, itemText) {
            if (item.header) return false;

            const hasValue = (val) => (val != null ? val : "");

            const text = hasValue(itemText);
            const query = hasValue(queryText);

            return (
                text
                    .toString()
                    .toLowerCase()
                    .indexOf(query.toString().toLowerCase()) > -1
            );
        },
    },
    computed: {
        ...mapGetters({
            items: "orderTags/fetch",
        }),
    },
};
</script>
