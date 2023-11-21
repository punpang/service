<template>
    <td>
        <btnUseCoupon :propOrder="propOrder"></btnUseCoupon>
    </td>

</template>

<script>
import btnUseCoupon from "@/js/components/order/manages/useCoupon/btn";
export default {
    props: ["propOrder"],
    components: {
        btnUseCoupon,
    },
};
</script>

<style></style>
