export default {
    namespaced: true,
    state: {},
    mutations: {},
    getters: {},
    actions: {
        async store({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/imageGoodsReviewToCustomer/${payload.order_detail_id}/store`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async delete({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/imageGoodsReviewToCustomer/${payload.order_detail_id}/delete`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
