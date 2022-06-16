<template>
    <div>
        <v-alert
            border="top"
            class="pt-5 pl-1 pb-0 mb-2"
            colored-border
            color="yellow darken-3"
            elevation="1"
            @click="clickUpdateRating()"
            v-if="order.status === 9"
        >
            <strong class="ml-2">ให้คะแนนคำสั่งซื้อนี้ของคุณ</strong>
            <v-rating
                empty-icon="star_outline"
                full-icon="star"
                half-icon="star_half"
                hover
                length="5"
                size="24"
                v-model="order.rating"
                color="yellow darken-3"
                background-color="yellow darken-3"
            ></v-rating>
        </v-alert>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    methods: {
        async clickUpdateRating() {
            let loader = this.$loading.show();
            const payload = {
                uuid: this.$route.params.uuid,
                rating: this.order.rating,
            };
            await this.$store
                .dispatch("orderIndex/updateRatingByUuid", payload)
                .then((result) => {
                    this.$toast.success(result.data.text);
                })
                .catch((error) => {
                    console.error(error.message);
                });
            loader.hide();
        },
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
