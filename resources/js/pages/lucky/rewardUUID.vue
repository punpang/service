<template>
  <div>
    <v-card class="mb-4">
      <v-card-title class="pb-0">
        <h2>ลุ้นรางวัล (สำหรับลูกค้า)</h2>
      </v-card-title>
      <v-divider class="mb-0"></v-divider>
      <v-card-text>
        <!-- /// -->
        <v-row justify="center">
          <v-col md="4" cols="12">
            <h5 class="mb-0">ชื่อ : {{ datas.name }}</h5>
          </v-col>
          <v-col md="4" cols="12">
            <h5 class="mb-0">
              <p class="mb-0">เบอร์โทรศัพท์ : {{ datas.phone }}</p>
            </h5>
            <!-- <h5 class="mb-0 d-none d-sm-flex">
              เบอร์โทรศัพท์ : {{ datas.phone }}
            </h5> -->
          </v-col>
          <v-col md="4" cols="12">
            <h5 class="mb-0">จำนวน {{ datas.labels.length }} รางวัล</h5>
            <!-- <h5 class="mb-0 d-none d-sm-flex">
              จำนวน {{ datas.labels.length }} รางวัล
            </h5> -->
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
    <v-row>
      <v-col md="4" cols="12" v-for="label in datas.labels" :key="label.key">
        <v-card height="100%">
          <v-card-text class="text-center" v-if="label.status_open === 0">
            <openReward :propOpenReward="label" :propUuid="uuid"></openReward>
          </v-card-text>

          <!-- /// -->

          <v-card-text class="text-center" v-else>
            <div v-if="label.reward_id === 1">
              <strong>วัน-เวลาทำรายการ : {{ label.updated_at }}</strong>
              <v-alert type="error">
                <strong>ไม่ได้รางวัล</strong>
              </v-alert>
            </div>
            <div v-else>
              <v-simple-table>
                <tbody>
                  <tr>
                    <td class="text-left">
                      <strong>ชื่อของรางวัล</strong>
                    </td>
                    <td class="text-right">
                      <strong>{{ label.reward.name }}</strong>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left"><strong>มูลค่า</strong></td>
                    <td class="text-right">
                      <strong>{{ label.reward.value }} บาท</strong>
                    </td>
                  </tr>
                </tbody>
              </v-simple-table>
              <getRedeemCode
                v-if="label.status_use_redeem_code === 0"
                :propGetRedeemCode="label"
                :propUuid="uuid"
              ></getRedeemCode>

              <v-alert class="mt-3 mb-0" type="success" v-else>
                <strong>แลกของรางวัลแล้ว</strong>
              </v-alert>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <!-- {{ datas.labels }} -->
  </div>
</template>

<script>
import openReward from "@/js/components/lucky/rewards/open";
import getRedeemCode from "@/js/components/lucky/rewards/getRedeemCode";

export default {
  components: {
    openReward,
    getRedeemCode,
  },
  data() {
    return {
      datas: {
        labels: [],
      },
      uuid: "",
    };
  },
  methods: {
    async start() {
      let loader = this.$loading.show();
      const datas = await this.$store.dispatch("orderLuckyReward/getByUUID", {
        uuid: this.$route.params.uuid,
      });
      if (datas.status === 204) {
        this.$swal({
          title: "ลิงก์หมดอายุ",
          icon: "error",
          text: "โปรดติดต่อ 091-885-3402 เพื่อขอลิงก์ใหม่",
          allowOutsideClick: false,
          showConfirmButton: false,
        });
      }

      this.datas = datas.data;
      this.uuid = this.$route.params.uuid;

      loader.hide();
    },
  },
  async mounted() {
    this.start();
    // await axios.get(`/api/${this.$route.params.id}/test`);
  },
};
</script>
