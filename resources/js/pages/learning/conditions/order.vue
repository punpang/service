<template>
    <div>
        <v-card outlined>
            <v-card-text>
                <textCondition></textCondition>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import textCondition from "@/js/components/learning/conditions/order";
export default {
    components: {
        textCondition,
    },
};
</script>

<style></style>
