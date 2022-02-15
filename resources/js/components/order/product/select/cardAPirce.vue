<template>
    <div>
        <p class="mb-0">
            <strong>{{ propAPrice.name_goods }}</strong>
        </p>
        <p class="mb-0">
            <strong>{{ propAPrice.price | formatNumber }}</strong>
        </p>
    </div>
</template>

<script>
var numeral = require("numeral");
Vue.filter("formatNumber", function (value) {
    return numeral(value).format("0,0.00");
});
export default {
    props: ["propAPrice"],
};
</script>
