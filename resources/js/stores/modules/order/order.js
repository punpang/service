export default {
    namespaced: true,
    state: {
        orders: [],
        orders_details: [],
        orders_details_pos:[],
        setNameGoods: "",
        order: {
            sum_all: {
                sumASC: 0,
                sumGoods: 0,
                sumTASC: 0,
                sumBalance: 0,
                sumDeposited: 0,
                sumAccessory: 0,
                sumService: 0,
                sumDiscount: 0,
                sumAddOn: 0,
                sumDeliverService: 0,
            },
            customer: {
                status_consent_condition: 1,
            },
        },
        paymentSummary: {
            text: {
                title: "สรุปยอดทั้งหมด",
                amount: "จำนวนเงินที่ชำระ",
                thb: "บาท",
                sumTASC: "ยอดทั้งหมด",
                deposited: "ยอดชำระแล้ว",
                balance: "ยอดคงเหลือ",
                status: "สถานะ",
                totalGoods: "ยอดรวมสินค้า",
                accessory: "อุปกรณ์เสริม",
                service: "ค่าบริการอื่น ๆ",
                discount: "ส่วนลด",
            },
            rules: {
                amount: [(v) => !!v || "ห้ามเว้นว่าง"],
            },
        },
        useChannelPayments: {},
    },
    mutations: {
        order(state, data) {
            state.order = data;
        },
        customer(state, data) {
            state.order.customer = data;
        },
        sumAll(state, data) {
            state.order.sumAll = data;
        },
        useChannelPayments(state, data) {
            state.useChannelPayments = data;
        },
        setNameGoods(state, data) {
            state.setNameGoods = data;
        },
        orders(state, data) {
            state.orders = data;
        },
        orders_details(state, data) {
            state.orders_details = data;
        },
        orders_details_pos(state, data){
            state.orders_details_pos = data;
        }
    },
    getters: {
        order: (state) => state.order,
        paymentSummary: (state) => state.paymentSummary,
        sumAll: (state) => state.order.sumAll,
        useChannelPayments: (state) => state.useChannelPayments,
        setNameGoods: (state) => state.setNameGoods,
        orders: (state) => state.orders,
        orders_details: (state) => state.orders_details,
        orders_details_pos: (state) => state.orders_details_pos,
    },
    actions: {
        async getOrderByUUID({ commit }, payload) {
            return await axios
                .get(`/api/v1/guest/order/fetchByUUID/${payload.uuid}`)
                .then((res) => {
                    commit("order", res.data.order);
                    commit("sumAll", res.data.order.sum_all);
                    commit("setNameGoods", res.data.order.name_goods);
                    return res;
                })
                .catch((error) => {
                    console.error(error);
                    return error;
                });
        },
        async getOrderByID({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/order/${payload.orderID}/getOrderByID`)
                .then((response) => {
                    commit("order", response.data.order);
                    commit("setNameGoods", response.data.order.name_goods);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                    return err;
                });
        },
        async paymentByOrderID({}, payload) {
            const res = await axios.post(
                `/api/admin/v1/order/paymentByOrderID`,
                payload
            );
            return res;
        },
        async pickUpOrderByID({}, payload) {
            const res = await axios.post(
                `/api/admin/v1/order/${payload.orderID}/pickUpOrderByID`
            );
            return res;
        },
        async getUseChannelPayments({ commit }) {
            const res = await axios.get(
                `/api/admin/v1/order/channelPayment/getUse`
            );
            commit("useChannelPayments", res.data);
        },

        async confirmConsentConditions({ commit }, payload) {
            const res = await axios.post(
                `/api/v1/guest/order/confirmConsentConditions`,
                payload
            );
            commit("customer", res.data);
            return res;
        },
        async alertPaymentByOrderID({}, payload) {
            return await axios
                .post(`/api/admin/v1/order/alertPaymentByOrderID`, payload)
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    log.error(err);
                });
        },
        async updateRatingByUuid({}, payload) {
            const res = await axios.post(
                `/api/v1/guest/order/updateRatingByUuid`,
                payload
            );
            return res;
        },
        async newOrder({}, payload) {
            const res = await axios.post(
                `/api/admin/v1/order/newOrder`,
                payload
            );

            return res;
        },
        async orderDetailDelete({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/${payload.id}/delete`,
                    payload
                )
                .then((response) => {
                    dispatch("getOrderByID", {
                        orderID: payload.order_id,
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async orderDetailUpdate({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/${payload.id}/update`,
                    payload
                )
                .then((response) => {
                    dispatch("getOrderByID", {
                        orderID: payload.order_id,
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async createAddOns({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/addOn/${payload.order_detail_id}/create`,
                    payload
                )
                .then((response) => {
                    dispatch("getOrderByID", {
                        orderID: payload.order_id,
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async autoUpdateAddOns({ dispatch }, payload) {
            // const payload = {
            //     order_detail_id: this.propOrderDetail.id,
            //     order_id: this.propOrderDetail.order_id,
            //     m4: this.propOrderDetail.a_price.m4,
            //     add_ons: this.propOrderDetail.add_ons,
            // };
            const filter_add_ons = payload.add_ons.filter((e) => {
                return e.product_add_on.am4_id != payload.m4;
            });
            if (filter_add_ons.length > 0) {
                payload.add_ons = filter_add_ons;
                // const payload = {
                //     order_detail_id: this.propOrderDetail.id,
                //     order_id: this.propOrderDetail.order_id,
                //     m4: this.propOrderDetail.a_price.m4,
                //     add_ons: filter_add_ons,
                // };

                return await axios
                    .post(
                        `/api/admin/v1/order/detail/addOn/${payload.order_detail_id}/autoUpdateAddOns`,
                        payload
                    )
                    .then((response) => {
                        dispatch("getOrderByID", {
                            orderID: payload.order_id,
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
            return;
        },

        async deleteAddOns({ dispatch }, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/addOn/${payload.order_detail_id}/delete`,
                    payload
                )
                .then((response) => {
                    dispatch("getOrderByID", {
                        orderID: payload.order_id,
                    });
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async createProductAddOn({}, payload) {
            return await axios.post(
                `/api/admin/v1/order/productAddOn/create`,
                payload
            );
        },

        async switchStatusUploadImagesFromCustomer({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/${payload.order_detail_id}/switchStatusUploadImagesFromCustomer`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async switchIsTakeAPhoto({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/detail/${payload.order_detail_id}/switchIsTakeAPhoto`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async addGoodsCake({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/addGoodsCake`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async changeCustomer({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/changeCustomer`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async changeDateTimeGet({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/changeDateTimeGet`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async prepareGoods({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/prepareGoods`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async pickUpGoods({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/pickUpGoods`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        async customerNoPayment({}, payload) {
            return await axios
                .post(
                    `/api/admin/v1/order/${payload.order_id}/customerNoPayment`,
                    payload
                )
                .then((response) => {
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async fetch_orders({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/orders/fetch?${payload}`)
                .then((response) => {
                    commit("orders", response.data);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async fetch_orders_details({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/orders/details/fetch?${payload}`)
                .then((response) => {
                    commit("orders_details", response.data);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async fetch_pre_order_lists({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/orders/details/fetch_pre_order_lists`)
                .then((response) => {
                    commit("orders_details", response.data);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        async fetch_pre_pos_lists({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/orders/details/pos/fetch_pre_pos_lists`)
                .then((response) => {
                    commit("orders_details_pos", response.data);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        
        async fetch_orders_details_pos({ commit }, payload) {
            return await axios
                .get(`/api/admin/v1/orders/details/pos/fetch?${payload}`)
                .then((response) => {
                    commit("orders_details_pos", response.data);
                    return response;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
